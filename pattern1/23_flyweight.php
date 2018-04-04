<?php

/*
 * 亨元模式
 * @author http://www.phppan.com/2010/08/php-design-pattern-13-flyweight/
 * 享元模式以共享的方式高效地支持大量的细粒度对象。享元对象能做到共享的关键是区分内蕴状态（Internal State）和外蕴状态（External State）。
 * 内蕴状态是存储在享元对象内部并且不会随环境改变而改变。因此内蕴状态并可以共享。
 * 外蕴状态是随环境改变而改变的、不可以共享的状态。享元对象的外蕴状态必须由客户端保存，
 * 并在享元对象被创建之后，在需要使用的时候再传入到享元对象内部。外蕴状态与内蕴状态是相互独立的。
 * 享元模式，就是给工厂加了个缓存池
 */

/**
 * 抽象享元角色
 */
abstract class Flyweight {

    /**
     * 示意性方法
     * @param string $state 外部状态
     */
    abstract public function operation($state);
}

/**
 * 具体享元角色
 */
class ConcreteFlyweight extends Flyweight {

    private $_intrinsicState = null;

    /**
     * 构造方法
     * @param string $state  内部状态
     */
    public function __construct($state) {
        $this->_intrinsicState = $state;
    }

    public function operation($state) {
        echo 'ConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState
        . ' Extrinsic State = ' . $state . '<br />';
    }

}

/**
 * 不共享的具体享元，客户端直接调用
 */
class UnsharedConcreteFlyweight extends Flyweight {

    private $_intrinsicState = null;

    /**
     * 构造方法
     * @param string $state  内部状态
     */
    public function __construct($state) {
        $this->_intrinsicState = $state;
    }

    public function operation($state) {
        echo 'UnsharedConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState
        . ' Extrinsic State = ' . $state . '<br />';
    }

}

/**
 * 享元工厂角色
 */
class FlyweightFactory {

    private $_flyweights;

    public function __construct() {
        $this->_flyweights = array();
    }

    public function getFlyweigth($state) {
        if (isset($this->_flyweights[$state])) {
            return $this->_flyweights[$state];
        } else {
            return $this->_flyweights[$state] = new ConcreteFlyweight($state);
        }
    }

}

/**
 * 客户端
 */
class Client {

    /**
     * Main program.
     */
    public static function main() {
        $flyweightFactory = new FlyweightFactory();
        $flyweight = $flyweightFactory->getFlyweigth('state A');
        $flyweight->operation('other state A');

        $flyweight = $flyweightFactory->getFlyweigth('state B');
        $flyweight->operation('other state B');

        /* 不共享的对象，单独调用 */
        $uflyweight = new UnsharedConcreteFlyweight('state A');
        $uflyweight->operation('other state A');
    }

}

Client::main();
