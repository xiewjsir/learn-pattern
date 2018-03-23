<?php
//namespace tmp;
class tmp {
    public $name;
    
    function __construct($name){
        $this->name = $name;
    }
    
    public function index() {
        try {
            //throw new \Exception("sunyue");
        } catch (\throwable $e) {
            echo $e->getMessage() . ':'.$this->name.PHP_EOL;
        }
    }
    
    public function __clone() {
        $this->name = 'hello';
    }
    
    public function __call($name, $arguments) {
        echo $name.'::'.var_dump($arguments);
    }
}

$tmp = new tmp('test');
$tmp->index();

$tmp2 = clone $tmp;
$tmp2->index();

function test($arg,&$arg2){
    $arg2 = 3;
    echo __FUNCTION__.PHP_EOL;
}

$arg = $arg2 = 2;
call_user_func_array("test", [$arg,&$arg2]);
echo $arg.PHP_EOL;
echo $arg2.PHP_EOL.PHP_EOL;

class test{
    function __construct($arg1,$arg2) {
        echo __CLASS__.$arg1.'::'.$arg2.PHP_EOL;
    }
    
    public function index($arg1,$arg2){
        echo 'hello';
    }
    
    public static function world(){
        echo " world".PHP_EOL;
    }
}

$test = new test(3,4);
call_user_func_array([$test,"index"],[1,2]);
call_user_func(["test","world"]);

call_user_func_array([$test,"index"],[1,2]);
call_user_func_array(["test","world"],[]);

