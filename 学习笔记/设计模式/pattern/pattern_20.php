<?php

/*
 * 原型模式
 * @author http://blog.sina.com.cn/s/blog_6dbbafe001018vcy.html
 */

/**
 * 原型模式
 * 用原型实例指定创建对象的种类.并且通过拷贝这个原型来创建新的对象
 */

/**
 * 声明一个克隆自身的接口,即抽象原型角色
 */
interface Prototype {
    public function copy();
}

/**
 * 实现克隆自身的操作,具体原型角色
 */
class ConcretePrototype implements Prototype {
    private $name;
    function __construct($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    //克隆
    function copy() {

        /**
         * 浅拷贝
         */
        //return clone $this;

        /**
         * 深拷贝
         */
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

        /**
         * 浅拷贝
         */
        
        //  $pro  = new ConcretePrototype('prototype');
        //  $pro2 = $pro->copy();
        //  echo ':'.$pro->getName().'<br />2:'.$pro2->getName();

        /**
         * 深拷贝
         */
        $test = new Test();
        $test->array = array('', '2', '3');
        $pro = new ConcretePrototype($test);
        $pro2 = $pro->copy();
        print_r($pro->getName());
        echo '<br />';
        print_r($pro2->getName());
    }
}

Client::main();
