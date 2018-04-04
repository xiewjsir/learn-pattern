<?php
/*
 * 组合模式
 * @author http://blog.csdn.net/wmsjlihuan/article/details/20287969
 * 合成模式有时又叫做部分－整体模式（Part-Whole）。合成模式将对象组织到树结构中，可以用来描述整体与部分的关系。合成模式可以使客户端将单纯元素与复合元素同等看待。
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