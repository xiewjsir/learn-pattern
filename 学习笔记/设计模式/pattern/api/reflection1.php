<?php

class test {

    private $name;
    private $sex;

    function __construct() {
        $this->aaa = 'aaa';
    }

}

//$reflect = new ReflectionClass($test);
//$pro = $reflect->getDefaultProperties();
//print_r($pro); //打印结果：Array ( [name] => [sex] => )
//echo $test->aaa; //打印结果：aaa

$test = new test();
$reflect = new ReflectionObject($test);
$pro = $reflect->getProperties();
print_r($pro);
