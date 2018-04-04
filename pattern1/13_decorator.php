<?php
/*
 * @装饰模式
 * @author http://www.cnblogs.com/baochuan/archive/2012/02/28/2371521.html
 * 
 * 装饰模式以对客户端透明的方式扩展对象的功能，是继承关系的一个替代方案。
 * 引言
 * 孙悟空有七十二般变化，他的每一种变化都给他带来一种附加的本领。他变成鱼儿时，就可以到水里游泳；他变成雀儿时，就可以在天上飞行。而不管悟空怎么变化，在二郎神眼里，他永远是那只猢狲。
 * 装饰模式以对客户透明的方式动态地给一个对象附加上更多的责任。换言之，客户端并不会觉得对象在装饰前和装饰后有什么不同。装饰模式可以在不使用创造更多子类的情况下，将对象的功能加以扩展。
 */

abstract class Beverage {

    public $_name;
    abstract public function Cost();
}

// 被装饰者类
class Coffee extends Beverage {

    public function __construct() {
        $this->_name = 'Coffee';
    }

    public function Cost() {
        return 1.00;
    }

}

// 以下三个类是装饰者相关类
class CondimentDecorator extends Beverage {

    public function __construct() {
        $this->_name = 'Condiment';
    }

    public function Cost() {
        return 0.1;
    }

}

class Milk extends CondimentDecorator {
 
    public $_beverage;

    public function __construct($beverage) {
        $this->_name = 'Milk';
        if ($beverage instanceof Beverage) {
            $this->_beverage = $beverage;
        }else
            exit('Failure');
    }

    public function Cost() {
        return $this->_beverage->Cost() + 0.2;
    }

}

class Sugar extends CondimentDecorator {
    public $_beverage;

    public function __construct($beverage) {
        $this->_name = 'Sugar';
        if ($beverage instanceof Beverage) {
            $this->_beverage = $beverage;
        } else {
            exit('Failure');
        }
    }

    public function Cost() {
        return $this->_beverage->Cost() + 0.2;
    }

}

// Test Case
//1.拿杯咖啡
$coffee = new Coffee();
//2.加点牛奶
$coffee = new Milk($coffee);
//3.加点糖
$coffee = new Sugar($coffee);
printf("Coffee Total:%0.2f元\n", $coffee->Cost());
