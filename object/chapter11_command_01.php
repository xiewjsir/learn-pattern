<?php
/**
 * 命令模式
 */
abstract class Command{
    abstract function execute(CommandContext $context);
}
//FeedBackCommand.php
class FeedbackCommand extends Command{
    function execute(CommandContext $context){
        $msgSystem = Register::ferMessageSystem();

        $email = $context->get('email');
        $msg = $context->get('msg');
        $topic = $context->get('topic');

        $result = $msgSystem->send($email,$msg,$topic);
        if(!$result){
            $context->setError($msgSystem->getError());
        }else{
            return true;
        }
    }
}

//命令对象
class LoginCommand extends Command{
    function execute(CommandContext $context){
        $manger = Register::getAccessMananger();//虚拟类，处理用户登录系统的具体细节
        
        $user = $context->get('username');
        $pass = $context->get('pass');

        $user_obj = $manger->login($user,$pass);
        if(is_null($user_obj)){
            $context->setError($manger->getError());
            return false;
        }
        $context->addParam('user',$user_obj);
        return true;
    }
}

class CommandContext {
    private $params = array();
    private $error='';
    function __construct(){
        $this->params = $_REQUEST;
    }
    function addParam($key,$value){
        $this->params[$key] = $value;
    }

    function get($key){
        return $this->params[$key];
    }

    function setError($error){
        $this->error = $error;
    }

    function getError(){
        return $this->error;
    }
}


class CommandNotFoundException extends Exception{}

//client,实例化命令对象的客户端
class CommandFactory{
    private static $dir = 'commands';
    static function getCommand($action='Default'){
        if(preg_match('/\W/', $action)){
            throw new Exception("illegal characters in action");
        }
        $class = UCFirst(strtolower($action))."Command";
        $file = self::$dir.DIRECTORY_SEPARATOR."{$class}.php";
        if(!file_exists($file)){
            throw new CommandNotFoundException("could not find $file");
        }
        require_once($file);
        if(!class_exists($class)){
            throw new CommandNotFoundException("not $class class located");
        }
        $cmd = new $class();
        return $cmd;
    }
}


//invoker,使用命令对象的类
class Controller{
    private $context;
    function __construct(){
        $this->context = new CommandContext();
    }

    function getContext(){
        return $this->context;
    }

    function process(){
        $cmd = CommandFactory::getCommand($this->context->get('action'));
        if(!$cmd->execute($this->context)){
            //处理失败
        }else{
            //成功
            //分发视图
        }
    }
}


$controller = new Controller();
//模拟用户请求
$context = $controller->getContext();
$context->addParam('action','login');
$context->addParam('username','bob');
$context->addParam('pass','tiddlies');
$controller->process();