<?php
abstract class Unit {
    abstract function bombardStrength();
}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
}

class LaserCannonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}


class Army { // 军队
    private $units = array(); // 定义私有属性 个体集

    function addUnit( Unit $unit ) { // 添加成员
        array_push( $this->units, $unit );
    }

    function bombardStrength() { // 火力
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

$unit1 = new Archer(); 
$unit2 = new LaserCannonUnit(); 
$army = new Army();
$army->addUnit( $unit1 ); 
$army->addUnit( $unit2 ); 
print $army->bombardStrength(); // 输出火力