<?php
/*
 * 原型模式
 * @author http://blog.sina.com.cn/s/blog_6dbbafe001018vcy.html
 * 
 * 先说一下深拷贝和浅拷贝通俗理解 
 * 深拷贝：赋值时值完全复制，完全的copy，对其中一个作出改变，不会影响另一个
 * 浅拷贝：赋值时，引用赋值，相当于取了一个别名。对其中一个修改，会影响另一个
 * PHP中， = 赋值时，普通对象是深拷贝，但对对象来说，是浅拷贝。也就是说，对象的赋值是引用赋值。（对象作为参数传递时，也是引用传递，无论函数定义时参数前面是否有&符号）
 * 
 * 通过给出一个原型对象来指明所要创建的对象类型，然后用复制这个原型对象的办法创建出更多的同类型对象。
 * 从孙大圣的手段谈起
 * 孙悟空在与黄风怪的战斗中，"使一个身外身的手段：把毫毛揪下一把，用口嚼得粉碎，望上一喷，叫声'变'，变有百十个行者，
 * 都是一样得打扮，各执一根铁棒，把那怪围在空中。"换而言之，孙悟空可以根据自己的形象，复制出很多"身外身"来。
 * 老孙这种身外身的手段在面向对象设计领域里叫原型（Prototype）模式。
 */

/**
 * 原型模式
 * 用原型实例指定创建对象的种类.并且通过拷贝这个原型来创建新的对象
 */

/**
 * 声明一个克隆自身的接口,即抽象原型角色
 */
interface Prototype {
    public function copy1();
    public function copy2();
    public function copy3();
}

/**
 * 实现克隆自身的操作,具体原型角色
 */
class ConcretePrototype implements Prototype {
    public $name;
    public $obj;
    function __construct($name,test $obj) {
        $this->name = $name;
        $this->obj = $obj;
    }

    function output() {
        echo $this->name;
        echo PHP_EOL;
        print_r($this->obj->array);
        echo PHP_EOL;
    }

    /**
     * 浅拷贝
     */
    function copy1() {
        return $this;
    }
    
    /**
     * 浅拷贝
     * clone函数存在这么一个问题，克隆对象时，原对象的普通属性能值复制，但是源对象的对象属性赋值时还是引用赋值，浅拷贝。
     */
    function copy2() {
        return clone $this;
    }

    /**
     * 深拷贝
     */    
    function copy3() {
        $serialize_obj = serialize($this);  //序列化
        $clone_obj = unserialize($serialize_obj);   //反序列化
        return $clone_obj;
    }
}

/**
 * 测试深拷贝的类
 */
class Test {
    public $array;
}

/**
 * 客户端
 */
class Client {

    /**
     * 实现原型模式
     */
    public static function main() {
        $test = new Test();
        $test->array = array(1,2,3);
        $pro = new ConcretePrototype('浅拷贝a1',$test);
        $pro2 = $pro->copy1();
        $pro->name = "浅拷贝a2";
        $pro->obj->array = [4,5,6];
        $pro->output();
        $pro2->output();
        echo str_repeat(PHP_EOL,4);       
      
        $test = new Test();
        $test->array = array(1,2,3);
        $pro = new ConcretePrototype('普通属性深拷贝，对象属性浅拷贝a1',$test);        
        $pro2 = $pro->copy2();
        $pro->name = "普通属性深拷贝，对象属性浅拷贝a2";
        $pro->obj->array = [4,5,6];
        $pro->output();
        $pro2->output();
        echo str_repeat(PHP_EOL,4);    
        
        $test = new Test();
        $test->array = array(1,2,3);
        $pro = new ConcretePrototype('深拷贝a1',$test);        
        $pro2 = $pro->copy3();
        $pro->name = "深拷贝a2";
        $pro->obj->array = [4,5,6];
        $pro->output();
        $pro2->output();  
    }
}

Client::main();
