<?php
/*
 * 适配器模式
 * @author http://blog.samoay.me/post/view/14
 * MEMENTO—同时跟几个MM聊天时，一定要记清楚刚才跟MM说了些什么话，不然MM发现了会不高兴的哦，
 * 幸亏我有个备忘录，刚才与哪个MM说了什么话我都拷贝一份放到备忘录里面保存，这样可以随时察看以前的记录啦。
 * 备忘录对象是一个用来存储另外一个对象内部状态的快照的对象。备忘录模式的用意是在不破坏封装的条件下，
 * 将一个对象的状态捉住，并外部化，存储起来，从而可以在将来合适的时候把这个对象还原到存储起来的状态。
 * 
 * 工厂，生产同一类产品，比如Nokia手机厂家，就只出Nokia手机，虽然一堆型号。
 * 适配，拿了什么手机，你就得用什么充电器！你拿了Nokia得手机，用Moto得充电器，不怕爆炸？？？
 */
//目标角色  
interface Target {  
    public function simpleMethod1();  
    public function simpleMethod2();  
}  
  
//源角色  
class Adaptee {  
      
    public function simpleMethod1(){  
        echo 'Adapter simpleMethod1'."<br>";  
    }  
}  
  
//类适配器角色  
class Adapter implements Target {  
    private $adaptee;  
      
      
    function __construct(Adaptee $adaptee) {  
        $this->adaptee = $adaptee;   
    }  
      
    //委派调用Adaptee的sampleMethod1方法  
    public function simpleMethod1(){  
        echo $this->adaptee->simpleMethod1();  
    }  
      
    public function simpleMethod2(){  
        echo 'Adapter simpleMethod2'."<br>";     
    }   
      
}  
  
//客户端  
class Client {  
      
    public static function main() {  
        $adaptee = new Adaptee();  
        $adapter = new Adapter($adaptee);  
        $adapter->simpleMethod1();  
        $adapter->simpleMethod2();   
    }  
}  
  
Client::main();
