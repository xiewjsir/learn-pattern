<?php

/* 
 * 回调  匿名函数和闭包
 */
class Product{
    public $name;
    public $price;
    function __construct($name,$price) {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProccessSale{
    private $callbacks;
    function registerCallBack($callback){
        if(!is_callable($callback)){
            throw new Exception("callback not callable");
        }
        $this->callbacks[] = $callback;
    }
    
    function sale($product){
        print "{$product->name}:processing \n";
        foreach($this->callbacks as $callback){
            call_user_func($callback,$product);
        }
    }
}

$logger = create_function('$product', 'print "  logging({$product->name})\n";');

$processor = new ProccessSale();
$processor->registerCallBack($logger);
$processor->sale(new Product("shoes",6));
print "\n";
$processor->sale(new Product("coffee",6));

$logger2 = function($product){
    print "  logging({$product->name})\n";
};//注意:因为这是一条内联语句,所以在代码的末尾需要使用分号

$processor = new ProccessSale();
$processor->registerCallBack($logger2);
$processor->sale(new Product("shoes",6));
print "\n";
$processor->sale(new Product("coffee",6));

class Totalizer{
    static function warnAmount($amt){
        $count = 0;
        return function($product)use($amt,&$count){
            $count += $product->price;
            print "     count:$count\n";
            if($count > $amt){
                print "     high price reached:{$count}\n";
            }
        };
    }
}

$processor = new ProccessSale();
$processor->registerCallBack(Totalizer::warnAmount(8));
$processor->sale(new Product("shoes",6));
print "\n";
$processor->sale(new Product("coffee",6));