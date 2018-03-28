<?php
abstract class Tile {
    abstract function getWealthFactor();
}

class Plains extends Tile {
    private $wealthfactor = 2;
    function getWealthFactor() {
        return $this->wealthfactor;
    }
}

abstract class TileDecorator extends Tile { // 装饰
    protected $tile;
    function __construct( Tile $tile ) {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator { // 钻石装饰
    function getWealthFactor() {
        return $this->tile->getWealthFactor()+2;
    }
}

class PollutionDecorator extends TileDecorator { // 污染装饰
    function getWealthFactor() {
        return $this->tile->getWealthFactor()-4;
    }
}

$tile = new Plains();
print $tile->getWealthFactor(); // 2
print "\n";

$tile = new DiamondDecorator( new Plains() );
print $tile->getWealthFactor(); // 4
print "\n";

$tile = new PollutionDecorator(new DiamondDecorator( new Plains() ));
print $tile->getWealthFactor(); // 0
print "\n";