<?php

/**
 * @author:xiaojiang 20140222
 * 一致性哈希php 实现
 */
class MyHash {
    //虚拟节点集合
    private $_circleItems = array();    
    //虚拟节点数
    private $_virtualCounts = 2;
    
    //实际节点
    private $_items = array();
    //实际节点数
    private $_itemsCount = 0;
    //是否需要排序
    private $_itemRelKey = array();
    private $needSort = false;
    private $algo;

    public function __construct(hash_algo $algo = null) {
        if (!$algo) {
            $this->algo = new algo_md5();
        }
    }

    public function addItem($_item) {

        if (isset($this->_items[$_item])) {
            throw new Exception("item exists");
        }
        $this->_items[$_item] = array();
        for ($i = 0; $i < $this->_virtualCounts; $i++) {
            $_virturalKey = $this->algo->run($_item . $i);
            $this->_circleItems[$_virturalKey] = $_item;
            $this->_itemRelKey[$_item][] = $_virturalKey;
        }
        $this->needSort = true;
        $this->_itemsCount++;
    }

    public function removeItem($_item) {
        if (!isset($this->_items[$_item])) {
            throw new Exception("item is not exists");
        }
        foreach ($this->_itemRelKey[$_item] as $key) {
            unset($this->_circleItems[$key]);
        }
        unset($this->_items[$_item]);
        $this->_itemsCount--;
    }

    public function getKey($str) {
        if ($this->needSort) {
            $this->sortItems();
        }

        $_sk = $this->algo->run($str);
        //echo $_sk.'<br>';
        foreach ($this->_circleItems as $key => $_item) {
            if ($key > $_sk) {
                return $_item;
            }
        }
        $ret = array_values(array_slice($this->_circleItems, 0, 1));
        return $ret[0];
    }

    private function sortItems() {
        ksort($this->_circleItems, SORT_STRING);
        $this->needSort = false;
    }

    public function _t() {
        print_r($this->_circleItems);
    }

}

Interface hash_algo {
    function run();
}

class algo_md5 {
    function run($_str) {
        return MD5($_str);
    }

}

$_tstr = "B8aaaaa";
$thash = new MyHash();
$thash->addItem("10.100.200.3");
$thash->addItem("10.100.200.4");

$a = $thash->getKey($_tstr);
echo $a;
$thash->_t();

//$thash->removeItem("10.100.200.4");
//$thash->_t();
?>

