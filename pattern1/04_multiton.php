<?php

/**
 * 多例模式
 * @author cbf4Life cbf4life@126.com 
 * I'm glad to share my knowledge with you all. 
 * 中国的历史上一般都是一个朝代一个皇帝，有两个皇帝的话，必然要PK出一个皇帝出来。 
 * 问题出来了：如果真在一个时间，中国出现了两个皇帝怎么办？比如明朝土木堡之变后， 
 * 明英宗被俘虏，明景帝即位，但是明景帝当上皇帝后乐疯了，竟然忘记把他老哥明英宗削为太上皇， 
 * 也就是在这一个多月的时间内，中国竟然有两个皇帝！ 
 *  
 */
abstract class Multiton {

    private static $instances = array();

    public static function getInstance() {
        $key = get_called_class() . serialize(func_get_args());
        if (!isset(self::$instances[$key])) {
            $rc = new ReflectionClass(get_called_class());
            self::$instances[$key] = $rc->newInstanceArgs(func_get_args());
        }
        return self::$instances[$key];
    }

}

class Hello extends Multiton {

    public function __construct($string = 'World') {
        echo "Hello $string\n";
    }

}

class GoodBye extends Multiton {

    public function __construct($string = 'my', $string2 = 'darling') {
        echo "Goodbye $string $string2\n";
    }

}

$a = Hello::getInstance('World');
$b = Hello::getInstance('bob');
// $a !== $b 

$c = Hello::getInstance('World');
// $a === $c 

$d = GoodBye::getInstance();
$e = GoodBye::getInstance();
// $d === $e 

$f = GoodBye::getInstance('your');
// $d !== $f 

 function test(){        
    print_r(func_get_args());   
    echo "\n";   
    echo func_get_arg(1);   
    echo "\n";   
    echo func_num_args();
    echo "\n";
}   

test("www","jb51","net");  
?>
