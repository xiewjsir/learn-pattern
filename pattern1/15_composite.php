<?php
/*
 * 组合模式
 * @author http://blog.csdn.net/wmsjlihuan/article/details/20287969
 组合和聚合都描述了一个类长期持有其他类的一个或多个实例的情况。
 聚合：被包含对象是容器的核心部分，但是他们也可以被其他对象所包含。聚合关系用一条以空心菱形开头的线来说明。
 组合：被包含的对象只能被它的容器所引用。当容器被删除时，它也应该被删除。组合关系的菱形是实心的。
 */


/**
 * 单元抽象类
 */
abstract class Unit{
    /**
     * 作战能力
     */
    abstract function bombardStrength();
}


/**
 * 弓箭手
 */
class Archer extends Unit{
    /**
     * 作战能力
     */
    public function bombardStrength(){
        return '4';
    }
}

/**
 * 激光大炮单元
 */
class laserCannonUnit extends Unit{
     /**
      * 作战能力
      * @return type 
      */
     public function bombardStrength(){
        return '42';
    }
}

/**
 * 军队
 */
class Arm{
    /**
     *存储作战单元的数组
     */
    private $units = array();

    /**
     *添加单元
     */
    public function addUnit( Unit $unit ){
       array_push( $this->units, $unit );
    }

    /**
     *作战能力
     */
    public function bombardStrength(){
        $strength = 0;
        foreach( $this->units as $unit ){
            $strength += $unit->bombardStrength();
        }
        return $strength;
    }
}


$archer = new Archer();
$laserCannon = new laserCannonUnit();

$arm = new Arm();
$arm->addUnit( $archer );
$arm->addUnit( $laserCannon );

echo $arm->bombardStrength();