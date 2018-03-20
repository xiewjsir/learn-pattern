<?php
/*
 * 适配器模式
 * @author http://blog.samoay.me/post/view/14
 * MEMENTO—同时跟几个MM聊天时，一定要记清楚刚才跟MM说了些什么话，不然MM发现了会不高兴的哦，
 * 幸亏我有个备忘录，刚才与哪个MM说了什么话我都拷贝一份放到备忘录里面保存，这样可以随时察看以前的记录啦。
 * 备忘录对象是一个用来存储另外一个对象内部状态的快照的对象。备忘录模式的用意是在不破坏封装的条件下，
 * 将一个对象的状态捉住，并外部化，存储起来，从而可以在将来合适的时候把这个对象还原到存储起来的状态。
 */

//首先，提供一个统一的接口，我们称为适配目标，即被适配对象都要实现适配目标规定的接口
interface CacheInterface{
    public function set($key, $value, $expire=86400);
    public function get($key);
    public function delete($key);
    public function flush();
    //实际上还可以实现诸如批量set、批量get、递增、递减等接口，这里省略
}

//其次，被适配对象，这里说明一下，被适配对象一定是已经存在的（不然就不需要什么适配了），
//我们这个例子中就是缓存服务提供的PHP接口对象，比如文件操作函数集、APC扩展函数集、
//Memcache对象等等。这些被适配的对象都能实现key-value方式的数据缓存，但是他们所提供
//的接口又都是不一样的。（函数集的意思是，在PHP中并没用一个统一的对象，而是提供了一系
//列相关功能的函数调用）
//再次，实现适配器，以下已APC和Memcache为例，实现CacheInterface中规定的需要适配的方法
class ApcAdapter implements CacheInterface{
    //比较好得实现是，在这里加入PHP脚本缓存（即运行时缓存），这样如果是在
    //一次运行过程中二次读取缓存数据，不用调用底层服务，就能直接返回数据
    private $runningCache = array();

    public function set($key, $value, $expire=0){
        $res = apc_store($key, $value, $expire);
        if ($res){
            $this->runningCache[$key] = $value;
        }
        return $res;
    }

    public function get($key){
        if (isset($this->runningCache[$key])){
            return $this->runningCache[$key];
        }
        return apc_fetch($key);
    }

    public function delete($key){
        $res = apc_delete($key);
        if ($res){
            unset($this->runningCache[$key]);
        }
        return $res;
    }

    public function flush(){
        $res = apc_clear_cache('user');
        if ($res){
            $this->runningCache = array();
        }
        return $res;
    }
}

class MemcacheAdapter implements CacheInterface{
    //比较好得实现是，在这里加入PHP脚本缓存（即运行时缓存），这样如果是在
    //一次运行过程中二次读取缓存数据，不用调用底层服务，就能直接返回数据
    private $runningCache = array();

    //Memcache对象实例
    private $memcache;

    //实现Memcache服务的初始化和连接，实际项目中肯定需要根据配置文件初始化，这里简化
    public function __construnct(){
        $memcache = new Memcache;
        $memcache->connect('memcache_host', 11211);
        $this->memcache = $memcache;
    }

    public function set($key, $value, $expire=0){
        $res = $this->memcache->set($key, $value, $expire);
        if ($res){
            $this->runningCache[$key] = $value;
        }
        return $res;
    }

    public function get($key){
        if (isset($this->runningCache[$key])){
            return $this->runningCache[$key];
        }
        return $this->memcache->get($key);
    }

    public function delete($key){
        $res = $this->memcache->delete($key);
        if ($res){
            unset($this->runningCache[$key]);
        }
        return $res;
    }

    public function flush(){
        $res = $this->memcache->flush();
        if ($res){
            $this->runningCache = array();
        }
        return $res;
    }
}

//最后，客户端调用，比较好得做法是，我们使用一个简单工厂返回Cache实例，这样就不用在各个需要
//调用缓存的地方去初始化某个具体的缓存Adapter对象了，只用调用全局的工厂方法去返回一个实例
class CacheFactory{
    //缓存我们已经实例化过的类，类似单例模式，但不是很严格
    private static $instance;

    //这里具体返回哪个Cache实例，根据全局的常量配置：CACHE_TYPE
    public static function getInstance(){
        if (is_null(self::$instance)){
            if (CACHE_TYPE == 'APC'){
                self::$instance = new ApcAdapter();
            }elseif (CACHE_TYPE == 'Memcache'){
                self::$instance = new MemcacheAdapter();
            }
         }
         return self::$instance;
    }
}

$cacheKey = "data_123";
$cache = CacheFactory::getInstance();//客户具体使用的时候，完全不用关心底层用的什么服务
$data = $cache->get($cacheKey);
if ($data === false){
    $data = getDataFromMysql(123);
    if ($data){
        $fileCache->set($cacheKey, $data, 86400);
    }
}
//这个时候如果想换底层服务，基本上只用改下常量CACHE_TYPE的值就行了，但是还是要注意一下，如果底层
//使用文件缓存或APC缓存的话，会有分布式部署的问题，即如果有多个前端，缓存就只是在当前访问的那个前端有效
//这部分的差异，是没法单纯从代码封装上去解决的

