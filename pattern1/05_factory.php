<?php
/**
 * 工厂模式
 * @author http://blog.samoay.me/post/view/27
 */

//统一的操作接口，保证对于外部调用是透明统一的
interface DbInterface{
    public function connect(Array $params=array());
    public function query($sql);
    public function insert($table, $record);
    public function update($table, $record, $where);
    public function delete($table, $where);
}

class Mysql implements DbInterface{
    //...省略具体实现
}

class SqlServer implements DbInterface{
    //...省略具体实现
}

class Sqlite implements DbInterface{
    //...省略具体实现
}

//我们具体的应用中，一般只会使用一种数据引擎，一般会根据一个全局的配置
class GlobalConfig{
    const DBENGINE = "mysql";
}

//原始的方法每次需要使用数据库的时候都使用if或者switch方法判断配置并实例化需要的数据库操作类。
//这样代码中会出现大量重复的代码，那么我们应该将相应的代码迁移到一个统一的类当中，这就是简单工厂了
class DbFactory{
    //一般为了调用便利，不需要初始化这个工具类，将方法定义为静态方法
    public static function factory(){
        if (GlobalConfig::DBENGINE=='mysql'){
            return new Mysql();
        }elseif (GlobalConfig::DBENGINE=='sqlserver'){
            return new SqlServer();
        }elseif (GlobalConfig::DBENGINE=='sqlite'){
            return new Sqlite();
        }
    }
}

//需要使用时
$db = DbFactory::factory();
$db->connect();//当然，我们可以把connect操作在类的构造方法中去实现了

