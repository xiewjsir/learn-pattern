<?php
/**
 * 原型模式
 */
class Sea {} // 大海
class EarthSea extends Sea {}
class MarsSea extends Sea {}

class Plains {} // 平原
class EarthPlains extends Plains {}
class MarsPlains extends Plains {}

class Forest {} // 森林
class EarthForest extends Forest {}
class MarsForest extends Forest {}

class TerrainFactory { // 地域工厂
    private $sea;
    private $forest;
    private $plains;

    function __construct( Sea $sea, Plains $plains, Forest $forest ) { // 定义变量为类对象
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }

    function getSea( ) {
        return clone $this->sea; // 克隆
    }

    function getPlains( ) {
        return clone $this->plains;
    }

    function getForest( ) {
        return clone $this->forest;
    }
}

$factory = new TerrainFactory( new EarthSea(),
    new EarthPlains(),
    new EarthForest() );
print_r( $factory->getSea() );
print_r( $factory->getPlains() );
print_r( $factory->getForest() );