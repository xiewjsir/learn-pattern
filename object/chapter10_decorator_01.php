<?php
/**
 * 装饰器模式
 */
abstract class Tile { // 砖瓦
    abstract function getWealthFactor(); // 获取财富
}

class Plains extends Tile { // 平原
    private $wealthfactor = 2;
    function getWealthFactor() {
        return $this->wealthfactor;
    }
}

class DiamondPlains extends Plains { // 钻石地段
    function getWealthFactor() {
        return parent::getWealthFactor() + 2;
    }
}

class PollutedPlains extends Plains { // 污染地段
    function getWealthFactor() {
        return parent::getWealthFactor() - 4;
    }
}
$tile = new PollutedPlains();
print $tile->getWealthFactor();
print "\n";