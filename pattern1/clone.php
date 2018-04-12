<?php

//普通对象赋值，深拷贝，完全值复制
$m = 1;
$n = $m;
$n = 2;
echo $m;//值复制，对新对象的改变不会对m作出改变，输出 1.深拷贝
echo PHP_EOL;

/*==================*/
 
//对象赋值，浅拷贝，引用赋值
class Test{
    public $a=1;
}
$m = new Test();
$n = $m;//引用赋值
$m->a = 2;//修改m，n也随之改变
echo $n->a;//输出2，浅拷贝
echo PHP_EOL;
echo PHP_EOL;



//clone函数存在这么一个问题，克隆对象时，原对象的普通属性能值复制，但是源对象的对象属性赋值时还是引用赋值，浅拷贝。
class Test2{
    public $a=1;
}
 
class TestOne2{
    public $b=1;
    public $obj;
    //包含了一个对象属性，clone时，它会是浅拷贝
    public function __construct(){
        $this->obj = new Test2();
    }
}
$m = new TestOne2();
$n = $m;//这是完全的浅拷贝，无论普通属性还是对象属性
 
$p = clone $m;//普通属性实现了深拷贝，改变普通属性b，不会对源对象有影响
$p->b = 2;
echo $m->b;//输出原来的1
echo PHP_EOL;
 
//对象属性是浅拷贝，改变对象属性中的a，源对象m中的对象属性中a也改变 
$p->obj->a = 3;
echo $m->obj->a;//输出3，随新对象改变
echo PHP_EOL;
echo PHP_EOL;


/**
 * 要想实现对象真正的深拷贝，有下面两种方法：
 * 写clone函数
 */
class Test3{
    public $a=1;
}
 
class TestOne3{
    public $b=1;
    public $obj;
    //包含了一个对象属性，clone时，它会是浅拷贝
    public function __construct(){
        $this->obj = new Test3();
    }
     
    //方法一：重写clone函数
    public function __clone(){
        $this->obj = clone $this->obj;
    }
}
 
$m = new TestOne3();
$n = clone $m;
 
$n->b = 2;
echo $m->b;//输出原来的1
echo PHP_EOL;
//可以看到，普通属性实现了深拷贝，改变普通属性b，不会对源对象有影响
 
//由于改写了clone函数，现在对象属性也实现了真正的深拷贝，对新对象的改变，不会影响源对象
$n->obj->a = 3;
echo $m->obj->a;//输出1，不随新对象改变，还是保持了原来的属性
echo PHP_EOL;
echo PHP_EOL;

/**
 * 改写__clone()函数不太方便，而且你得在每个类中把这个类里面的对象属性都在__clone()中 
 * 第二种方法，利用序列化反序列化实现,这种方法实现对象的深拷贝简单，不需要修改类
 */
class Test4{
    public $a=1;
}
 
class TestOne4{
    public $b=1;
    public $obj;
    //包含了一个对象属性，clone时，它会是浅拷贝
    public function __construct(){
        $this->obj = new Test4();
    }     
}
 
$m = new TestOne4();
//方法二，序列化反序列化实现对象深拷贝
$n = serialize($m);
$n = unserialize($n);
 
$n->b = 2;
echo $m->b;//输出原来的1
echo PHP_EOL;
//可以看到，普通属性实现了深拷贝，改变普通属性b，不会对源对象有影响
 
 
$n->obj->a = 3;
echo $m->obj->a;//输出1，不随新对象改变，还是保持了原来的属性,可以看到，序列化和反序列化可以实现对象的深拷贝
echo PHP_EOL;

//还有第三种方法，其实和第二种类似，json_encode之后再json_decode,实现赋值