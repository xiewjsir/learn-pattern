<?php

/**
  单例模式
 * @author http://blog.samoay.me/post/view/27
 */
class Logger {

    //首先，需要一个私有的静态变量来存储产生的对象实例
    private static $instance;
    //业务变量，保存日志写入路径
    private $logDir;

    //构造方法，注意必须也是私有的，不允许被外部实例化（即在外部被new）
    private function __construct() {
        //调试输出，测试对象被new的次数
        echo "new Logger instance\r\n";
        $logDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "logs";
        if (!is_dir($logDir) || !file_exists($logDir)) {
            @mkdir($logDir);
        }
        $this->logDir = $logDir;
    }

    //类唯一实例的全局访问点，用于判断并返回对象实例，供外部调用
    public static function getInstance() {
        if (is_null(self::$instance)) {
            $class = __CLASS__; //获得本对象的类名，也可以用 new self() 方式
            self::$instance = new $class();
        }
        return self::$instance;
    }

    //重载__clone方法，不允许对象实例被克隆
    public function __clone() {
        throw new Exception("Singleton Class Can Not Be Cloned");
    }

    //具体的业务方法，实际可以有很多方法，示例简略
    public function logError($message) {
        $logFile = $this->logDir . DIRECTORY_SEPARATOR . "error.log";
        error_log($message, 3, $logFile);
    }

}

//日志调用
$logger = Logger::getInstance();
$logger->logError("An error occured");
$logger->logError("Another error occured");
//或者这样调用
Logger::getInstance()->logError("Still have error");
Logger::getInstance()->logError("I should fix it");
