<?php
abstract class Unit {
    function getComposite() {
        return null;
    }

    abstract function bombardStrength();
}


abstract class CompositeUnit extends Unit { // 抽象类继承抽象类
    private $units = array();

    function getComposite() {
        return $this;
    }

    protected function units() {
        return $this->units;
    }

    function removeUnit( Unit $unit ) {
        $this->units = array_udiff($this->units, array($unit), function( $a, $b ) { return ($a === $b) ? 0 : ($a>$b ? 1 : -1); });
    }

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        $this->units[] = $unit;
    }
}

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }

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

class UnitScript {
    static function joinExisting( Unit $newUnit,Unit $occupyingUnit ) { // 静态方法，直接通过类名来使用 $comp;

        if ( ! is_null( $comp = $occupyingUnit->getComposite() ) ) { // 军队合并处理
            $comp->addUnit( $newUnit ); 
        } else { // 士兵合并处理
            $comp = new Army(); 
            $comp->addUnit( $occupyingUnit );
            $comp->addUnit( $newUnit );
        }
        return $comp;
    }
}

$army1 = new Army();
$army1->addUnit( new Archer() );
$army1->addUnit( new Archer() );

$army2 = new Army();
$army2->addUnit( new Archer() );
$army2->addUnit( new Archer() );
$army2->addUnit( new LaserCannonUnit() );

$composite = UnitScript::joinExisting( $army2, $army1 );
print_r( $composite );