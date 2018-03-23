<?php 
/**
 * 回调、匿名函数和闭包
 */
//namespace chapter4;
class Product{
    public $name;
    public $price;
    
    function __construct($name,$price){
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale{
    private $callbacks;
    
    function registerCallback($callback){
        if(!is_callable($callback)){
            throw new Exception("callback not callable");
        }
        
        $this->callbacks[] = $callback;
    }
    
    function sale($product){
        print "{$product->name}:processiong".(IS_CLI ? PHP_EOL : "\N");
        foreach($this->callbacks as $callback){
            call_user_func($callback,$product);
        }
    }
}

$logger = create_function('$product', 'print "  logging({$product->name})\n";');
$logger2 = function($product){
    print "     logging({$product->name})\n";
};

class Mailer{
    function doMail($product){
        print "     mailling ({$product->name})\n";
    }
}

class Totalizer{
    static function warnAmount(){
        return function($product){//匿名函数
            if($product->price > 5){
                print "     reach high price: {$product->price}\n";
            }
        };
    }
    
    static function warnAmountEst($amt){
        $count = 0;
        return function($product) use($amt,&$count){//闭包
            $count += $product->price;
            print "     count:{$count}\n";
            if($count > $amt){
                print "     high price reached:{$count}\n";
            }
        };
    }
}

$processor = new ProcessSale();
$processor->registerCallback($logger2);
$processor->registerCallback(array(new Mailer,"doMail"));
$processor->registerCallback(Totalizer::warnAmount());
$processor->registerCallback(Totalizer::warnAmountEst(8));

$processor->sale(new Product("shoes",5));
print PHP_EOL;
$processor->sale(new Product("coffee",6));