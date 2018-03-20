<?php

abstract class tmpObject {

    public static function create() {
        //$class = __CLASS__;
        //return new $class();
        return new static(); //return new self();
    }

}

class tmp1 extends tmpObject {

    public function index() {
        echo 'this is test1';
    }

}

class tmp2 extends tmpObject {

    public function index() {
        echo 'this is test2';
    }

}

tmp1::create()->index();
echo '<br>';

class StringThing {
    
}

$st = new StringThing();

//print $st;

class Person {

    function getName() {
        return "Bob";
    }

    function getAge() {
        return 66;
    }

    function __toString() {
        $desc = $this->getName();
        $desc .= "(age" . $this->getAge() . ")<br>";
        return $desc;
    }

}

$st = new Person();
print $st;

//call_user_func函数类似于一种特别的调用函数的方法，使用方法如下：
function nowamagic($a, $b) {
    echo $a . '<br>';
    echo $b . '<br>';
}

call_user_func('nowamagic', "111", "222");
call_user_func('nowamagic', "333", "444"); //显示 111 222 333 444   

class a {

    function b($c) {
        echo $c . '<br>';
    }

}

call_user_func(array("a", "b"), "111"); //显示 111   
//call_user_func_array函数和call_user_func很相似，只不过是换了一种方式传递了参数，让参数的结构更清晰：

function a2($b, $c) {
    echo $b . '<br>';
    echo $c . '<br>';
}

call_user_func_array('a2', array("111", "222")); //显示 111 222  

Class ClassA {

    function bc($b, $c) {
        $bc = $b + $c;
        echo $bc . '<br>';
    }

}

call_user_func_array(array('ClassA', 'bc'), array("111", "222")); //显示 333 
//call_user_func函数和call_user_func_array函数都支持引用，这让他们和普通的函数调用更趋于功能一致：

function a3($b) {
    $b++;
}

$c = 0;
call_user_func('a3', $c);
echo $c . '<br>'; //显示 1   
call_user_func_array('a3', array($c));
echo $c . '<br>'; //显示 2  
//另外，call_user_func函数和call_user_func_array函数都支持引用。

function increment(&$var) {
    $var++;
}

$a = 0;
//call_user_func('increment', $a);
echo $a . '<br>'; // 0
call_user_func_array('increment', array(&$a)); // You can use this instead
echo $a . '<br>'; // 1

class foo {

    static public function test() {
        var_dump(get_called_class());
    }

}

class bar extends foo {
    
}

foo::test();
bar::test();

//get_parent_class() - 返回对象或类的父类名
//get_class() - 返回对象的类名
//is_subclass_of() - 如果此对象是该类的子类，则返回 TRUE

class CopyMe {

    public $id;

    function __construct($id) {
        $this->id = $id;
    }

    function __clone() {//通过PHP内置的方法__clone() 可以控制复制什么
        $this->id = 0;
    }

}

$first = new CopyMe('1');
$second = $first; //PHP4:$second 和$first是两个完全不同的对象,PHP5及以后的版本:$second和$first指向同一个对象

echo $first->id . '::' . $second->id . '<br>';

$second = clone $first; //PHP5及以后的版本:$second和$first现在是两个不同的对象
echo $first->id . '::' . $second->id . '<br>';


$data = array('foo' => 'bar', 'baz' => 'boom', 'cow' => 'milk', 'php' => 'hypertext processor');
echo http_build_query($data); //输出：foo=bar&baz=boom&cow=milk&php=hypertext+processor

$data = array('foo', 'bar', 'baz', 'boom', 'cow' => 'milk', 'php' => 'hypertext processor');
echo http_build_query($data); //输出：0=foo&1=bar&2=baz&3=boom&cow=milk&php=hypertext+processor
echo http_build_query($data, 'myvar_'); // 输出：myvar_0=foo&myvar_1=bar&myvar_2=baz&myvar_3=boom&cow=milk&php=hypertext+processor 

$data = array('user' => array('name' => 'Bob Smith', 'age' => 47, 'sex' => 'M', 'dob' => '5/12/1956'),
    'pastimes' => array('golf', 'opera', 'poker', 'rap'),
    'children' => array('bobby' => array('age' => 12, 'sex' => 'M'),
        'sally' => array('age' => 8, 'sex' => 'F')),
    'CEO'
);
echo http_build_query($data, 'flags_');

//输出：（为了可读性对其进行了折行）
//user[name]=Bob+Smith&user[age]=47&user[sex]=M&user[dob]=5%1F12%1F1956&
//pastimes[0]=golf&pastimes[1]=opera&pastimes[2]=poker&pastimes[3]=rap&
//children[bobby][age]=12&children[bobby][sex]=M&children[sally][age]=8&
//children[sally][sex]=F&flags_0=CEO
//注意：只有基础数组中的数字下标元素“CEO”才获取了前缀，其它数字下标元素（如
//pastimes 下的元素）则不需要为了合法的变量名而加上前缀。

class myClass {

    var $foo;
    var $baz;

    function myClass() {
        $this->foo = 'bar';
        $this->baz = 'boom';
    }

}

$data = new myClass();
echo http_build_query($data); //输出：foo=bar&baz=boom


$firstname = "Bill";
$lastname = "Gates";
$age = "60";
$result = compact("firstname", "lastname", "age");
print_r($result); //Array ( [firstname] => Bill [lastname] => Gates [age] => 60 ) 
// Store cache
file_put_contents($cachePath, "<?php\nreturn " . var_export($myDataArray, true) . ";");
// Retrieve cache
$myDataArray = include($cachePath);

//var_export必须返回合法的php代码，也就是说，var_export返回的代码，可以直接当作php代码赋值个一个变量。 而这个变量就会取得和被var_export一样的类型的值
//但是， 当变量类型为resource的时候，是无法简单copy复制的，所以， 当var_export的变量是resource类型时， var_export会返回NULL
// Store cache
file_put_contents($cachePath, "<?php\nreturn " . var_export($myDataArray, true) . ";");
// Retrieve cache
$myDataArray = include($cachePath);

















