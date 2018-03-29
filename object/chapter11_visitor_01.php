<?php

/**
 * 访问者模式
 */
abstract class Unit {

    protected $depth;

    function accept(ArmyVisitor $visitor) {
        $method = "visit" . get_class($this);
        $visitor->$method($this);
    }

    protected function setDepth($depth) {
        $this->depth = $depth;
    }

    function getDepth() {
        return $this->depth;
    }

    function getComposite() {
        return null;
    }

    abstract function bombardStrength();
}

abstract class CompositeUnit extends Unit {

    protected $unit = array();

    function getComposite() {
        return $this;
    }

    function removeUnit(Unit $unit) {
        $this->unit = array_udiff($this->unit, array($unit), function($a, $b) {
            return ($a === $b) ? 0 : 1;
        });
    }

    function addUnit(Unit $unit) {
        if (in_array($unit, $this->unit, true)) {
            return;
        }
        $unit->setDepth($this->depth + 1);
        $this->unit[] = $unit;
    }

    function accept(ArmyVisitor $visitor) {
        parent::accept($visitor);
        foreach ($this->unit as $thisunit) {
            $thisunit->accept($visitor);
        }
    }

}

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach ($this->unit as $unit) {
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

class LaserCannon extends Unit {

    function bombardStrength() {
        return 5;
    }

}

abstract class ArmyVisitor {

    abstract function visit(Unit $node);

    function visitArcher(Archer $node) {
        $this->visit($node);
    }

    function visitLaserCannon(LaserCannon $node) {
        $this->visit($node);
    }

    function visitTroopCarrierUnit(TroopCarrierUnit $node) {
        $this->visit($node);
    }

    function visitArmy(Army $node) {
        $this->visit($node);
    }

}

class TextDumpArmyVisitor extends ArmyVisitor {

    private $text = '';

    function visit(Unit $node) {
        $ret = '';
        $pad = 4 * $node->getDepth();
        $ret .= sprintf("%{$pad}s", '');
        $ret .= get_class($node) . ": ";
        $ret .= "bombard: " . $node->bombardStrength() . "\n";
        $this->text .= $ret;
    }

    function getText() {
        return $this->text;
    }

}

class TaxCollectionVisitor extends ArmyVisitor {

    private $due = 0;
    private $report = 0;

    function visit(Unit $node) {
        $this->levy($node, 1);
    }

    function visitArcher(Archer $node) {
        $this->levy($node, 2);
    }

    function visitTroopCarrierUnit(TroopCarrierUnit $node) {
        $this->levy($node, 2);
    }

    function visitLaserCannon(LaserCannon $node) {
        $this->levy($node, 2);
    }

    function levy(Unit $unit, $amout) {
        $this->report .= "Tax levied for " . get_class($unit);
        $this->report .= ": $amout\n";
        $this->due += $amout;
    }

    function getRepost() {
        return $this->report;
    }

    function getTax() {
        return $this->due;
    }

}

$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannon());

//$textdump = new TextDumpArmyVisitor();
$taxcollector = new TaxCollectionVisitor();
$main_army->accept($taxcollector);
//echo $textdump->getText();
echo "TOTAL: ";
echo $taxcollector->getTax() . "\n";
echo $taxcollector->getRepost();
