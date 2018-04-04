<?php

/*
 * 桥梁模式
 * @author http://blog.csdn.net/hguisu/article/details/7529194

 * 将抽象化与实现化脱耦，使得二者可以独立的变化，也就是说将他们之间的强关联变成弱关联，
 * 也就是指在一个软件系统的抽象化和实现化之间使用组合/聚合关系而不是继承关系，从而使两者可以独立的变化。
 */

/**
 * Abstraction抽象类的接口 
 */
abstract class BrushPenAbstraction {

    protected $_implementorColor = null;

    /**
     * Enter description here ... 
     * @param Color $color 
     */
    public function setImplementorColor(ImplementorColor $color) {
        $this->_implementorColor = $color;
    }

    /**
     * Enter description here ... 
     */
    public abstract function operationDraw();
}

/**
 * 扩充由Abstraction;大毛笔 
 */
class BigBrushPenRefinedAbstraction extends BrushPenAbstraction {

    public function operationDraw() {
        echo 'Big and ', $this->_implementorColor->bepaint(), ' drawing';
    }

}

/**
 * 扩充由Abstraction;中毛笔 
 */
class MiddleBrushPenRefinedAbstraction extends BrushPenAbstraction {

    public function operationDraw() {
        echo 'Middle and ', $this->_implementorColor->bepaint(), ' drawing';
    }

}

/**
 * 扩充由Abstraction;小毛笔 
 */
class SmallBrushPenRefinedAbstraction extends BrushPenAbstraction {

    public function operationDraw() {
        echo 'Small and ', $this->_implementorColor->bepaint(), ' drawing';
    }

}

/**
 * 实现类接口(Implementor)  
 */
class ImplementorColor {

    protected $value;

    /**
     * 着色 
     */
    public function bepaint() {
        echo $this->value;
    }

}

class oncreteImplementorRed extends ImplementorColor {

    public function __construct() {
        $this->value = "red";
    }

    /**
     * 可以覆盖 
     */
    public function bepaint() {
        echo $this->value;
    }

}

class oncreteImplementorBlue extends ImplementorColor {

    public function __construct() {
        $this->value = "blue";
    }

}

class oncreteImplementorGreen extends ImplementorColor {

    public function __construct() {
        $this->value = "green";
    }

}

/**
 * 客户端程序 
 */
class Client {

    public static function Main() {
        //小笔画红色  
        $objRAbstraction = new SmallBrushPenRefinedAbstraction();
        $objRAbstraction->setImplementorColor(new oncreteImplementorRed());
        $objRAbstraction->operationDraw();
    }

}

Client::Main();


