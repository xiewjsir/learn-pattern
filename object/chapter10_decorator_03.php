<?php
class RequestHelper{} // 请求助手

abstract class ProcessRequest { // 进程请求
    abstract function process( RequestHelper $req );
}

class MainProcess extends ProcessRequest { // 主进程
    function process( RequestHelper $req ) {
        print __CLASS__.": doing something useful with request\n";
    }
}

abstract class DecorateProcess extends ProcessRequest { // 装饰进程
    protected $processrequest;
    function __construct( ProcessRequest $pr ) { // 引用对象，委托
        $this->processrequest = $pr;
    }
}

class LogRequest extends DecorateProcess { // 日志请求
    function process( RequestHelper $req ) {
        print __CLASS__.": logging request\n"; // 当前类,有点递归的感觉
        $this->processrequest->process( $req );
    }
}

class AuthenticateRequest extends DecorateProcess { // 认证请求
    function process( RequestHelper $req ) {
        print __CLASS__.": authenticating request\n";
        $this->processrequest->process( $req );
    }
}

class StructureRequest extends DecorateProcess { // 组织结构请求
    function process( RequestHelper $req ) {
        print __CLASS__.": structuring request\n";
        $this->processrequest->process( $req );
    }
}

$process = new AuthenticateRequest( new StructureRequest(
                                    new LogRequest (
                                    new MainProcess()
                                    ))); // 这样可以很灵活的组合进程的关系，省去很多重复的继承

$process->process( new RequestHelper() );
print_r($process);