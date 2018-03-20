<?php
/**
 * 多例模式
 * @author http://blog.samoay.me/post/view/13
 */
class MysqlServer{
    //注意，变成复数了哦^_^  当然只是为了标识而已
    private static $instances = array();

    //业务变量，保持当前实例的mysqli对象
    private $conn;

    //显著特征：私有的构造方法，避免在类外部被实例化
    private function __construct($host, $username, $password, $dbname, $port){
        $this->conn = new mysqli($host, $username, $password, $dbname, $port);
    }

    //类唯一实例的全局访问点
    public static function getInstance($host='localhost', $username='root', $password='123456', $dbname='mydb', $port='3306'){
        $key = "{$host}:{$port}:{$username}:{$dbname}";
        if (empty(self::$instances[$key])){
            //这里也可以用 new self(); 的方式
            $class = __CLASS__;
            self::$instances[$key] = new $class($host, $username, $password, $dbname, $port);
        }
        return self::$instances[$key];
    }

    //重载__clone方法，不允许对象实例被克隆
    public function __clone(){
        throw new Exception("Singleton Class Can Not Be Cloned");
    }

    //查询业务方法，后面省略其它业务方法
    public function query($sql){
        return $this->conn->query($sql);
    }

    //尽早释放资源
    public function __destruct(){
        $this->conn->close();
    }
}

