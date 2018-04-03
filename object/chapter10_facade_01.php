<?php
/**
 * template method 是继承关系，父类规定函数调用顺序，子类对各函数进行实现
 * facade 是组合关系，facede 清楚组合进来的类函数调用顺序，这些类不需要继承 facade
 */

function getProductFileLines($file){
    return file($file);
}

function getProductObjectFromID($id,$productname){
    // 一些数据库查询
    return new Product($id,$productname);
}

function getNameFromLine(){
    if (preg_match("/.*-(.*)\s\d+/",$line,$array)) {
        return str_replace('_',' ',$array[1]);
    }
    return '';
}

function getIDFromLine($line){
    if (preg_match("/^(\d{1,3})-/",$line,$array)){
        return $array[1];
    }
    return -1;
}

class Product{
    public $id;
    public $name;
    function __construct($id,$name){
        $this->id = $id;
        $this->id = $name;
    }
}

$lines = getProductFileLines('text.txt');
$objects = array();
foreach ($lines as $line) {
    $id = getIDFromLine($line);
    $name = getNameFromLine($line);
    $objects[$id] = getProductObjectFromID($id, $name);
}

#+++++++++++++++++++++++++++分隔线+++++++++++++++++++++++#

class ProductFacade{
    private $products = array();
    
    function __construct($file)
    {
        $this->file = $file;
        $this->compile();
    }

    private function complie(){
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line) {
            $id = getIDFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromID($id, $name);
        }
    }

    function getProducts(){
        return $this->products;
    }

    function getProduct($id){
        return $this->product[$id];
    }
}

$facade = new ProductFacade('test.txt');
$facade->getProduct(234);