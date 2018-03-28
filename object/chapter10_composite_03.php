<?php
abstract class Unit {

    abstract function addUnit(Unit $unit);

    abstract function removeUnit(Unit $unit);

    abstract function bombardStrength();
}

class Army extends Unit { // 军队

    private $units = array();

    function addUnit(Unit $unit) {
        if (in_array($unit, $this->units, true)) { // $this用于调用正常的属性或方法，self调用静态的方法，属性或者常量
            return;
        }

        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit) {
        // >= php 5.3
        $this->units = array_udiff($this->units, array($unit), function( $a, $b ) { return ($a === $b) ? 0 : ($a>$b ? 1 : -1); });
        // < php 5.3
        // $this->units = array_udiff( $this->units, array( $unit ), 
        //                create_function( '$a,$b', 'return ($a === $b)?0:1;' ) ); 
        // 对象数组，create_function,创建函数
    }

    function bombardStrength() {
        $ret = 0;
        foreach ($this->units as $unit) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }

}

// quick example classes
class Tank extends Unit {  // 坦克

    function addUnit(Unit $unit) {
        
    }

    function removeUnit(Unit $unit) {
        
    }

    function bombardStrength() {
        return 4;
    }

}

class Soldier extends Unit {  // 士兵

    function addUnit(Unit $unit) {
        
    }

    function removeUnit(Unit $unit) {
        
    }

    function bombardStrength() {
        return 8;
    }

}

$tank = new Tank();
$tank2 = new Tank();
$soldier = new Soldier();

$army = new Army();
$army->addUnit($soldier);
$army->addUnit($tank);
$army->addUnit($tank2);

print_r($army);
print $army->bombardStrength() . "\n";

$army->removeUnit($soldier);

print_r($army);
print $army->bombardStrength() . "\n";

