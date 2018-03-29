<?php
class Login implements SplSubject{
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $status = array();    
    private $storage;
    
    function __construct() {
        $this->storage = new SplObjectStorage();
    }
    
    public function attach(\SplObserver $observer){
        $this->storage->attach($observer);
    }

    public function detach(\SplObserver $observer){
        $this->storage->detach($observer);
    }

    public function notify(){
        foreach($this->storage as $obs){
            $obs->update($this);
        }
    }
 
    function handleLogin($user,$pass,$ip){
        switch(rand(1,3)){
            case 1:
                $this->setStatus(self::LOGIN_ACCESS,$user,$ip);
                $ret = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS,$user,$ip);
                $ret = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN,$user,$ip);
                $ret = false;
                break;
        }
        
        $this->notify();
        return $ret;
    }
    
    private function setStatus($status,$user,$ip){
        $this->status = array($status,$user,$ip);
    }
    
    function getStatus(){
        return $this->status;
    }
}

abstract class LoginObserver implements SplObserver{
    private $login;
    function __construct(Login $login) {
        $this->login = $login;
        $login->attach($this);
    }
    
    function update(\SplSubject $subject) {
        if($subject === $this->login){
            $this->doUpdate($subject);
        }
    }
    
    abstract function doUpdate(Login $login);
}


class SecurityMonitor extends LoginObserver{
    function doUpdate(Login $login){
        $status = $login->getStatus();
        if($status[0] == login::LOGIN_WRONG_PASS){
            //发送邮件给系统管理员
            print __CLASS__.":\tsending mail to sysadmin\n";
        }
    }
}

class GeneralLogger extends LoginObserver{
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        //发送邮件给系统管理员
        print __CLASS__.":\tadd login data to log\n";        
    }
}

class PartnershipTool extends LoginObserver{
    function doUpdate(Login $login){
        $status = $login->getStatus();
        //检查IP
        //如果匹配列表，则设置cookie
        print __CLASS__.":\tset cookie if IP matches a list\n";   
    }
}

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);
$login->handleLogin('test', '123', '127.0.0.1');