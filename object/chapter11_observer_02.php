<?php
interface Observable{
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

class Login implements Observable{
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $status = array();
    private $observers;
    
    function __construct() {
        $this->observers = [];
    }
            
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $new_observers = [];
        foreach($this->observers as $obs){
            if($obs !== $observer){
                $new_observers = $obs;
            }
        }
        
        $this->observers = $new_observers;
    }

    public function notify() {
        foreach($this->observers as $obs){
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

interface Observer{
    function update(Observable $obervable);
}

class SecurityMonitor implements Observer{
    function update(Observable $observable){
        $status = $observable->getStatus();
        if($status[0] == login::LOGIN_WRONG_PASS){
            //发送邮件给系统管理员
            print __CLASS__.":\tsending mail to sysadmin\n";
        }
    }
}

$login = new Login();
$login->attach(new SecurityMonitor());
$login->handleLogin('test', '123', '127.0.0.1');
