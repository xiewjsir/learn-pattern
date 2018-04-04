<?php

/*
 * 访问者模式
 * @author http://www.wmhfly.com/php/php-design-patterns-visitor.html
 * 
 *
 * 访问者模式的目的是封装一些施加于某种数据结构元素之上的操作。一旦这些操作需要修改的话，接受这个操作的数据结构可以保持不变。
 * 访问者模式适用于数据结构相对未定的系统，它把数据结构和作用于结构上的操作之间的耦合解脱开，使得操作集合可以相对自由的演化。
 * 访问者模式使得增加新的操作变的很容易，就是增加一个新的访问者类。
 * 访问者模式将有关的行为集中到一个访问者对象中，而不是分散到一个个的节点类中。当使用访问者模式时，要将尽可能多的对象浏览逻辑放在访问者类中，
 * 而不是放到它的子类中。访问者模式可以跨过几个类的等级结构访问属于不同的等级结构的成员类。
 */

abstract class Browser {

    /**
     * 浏览器名称
     * @var string
     */
    public $name;

    /**
     * 接受访问者的访问
     * @param Object $visitor
     */
    public abstract function accept($visitor);
}

/**
 * 具体元素类实现
 * 浏览设备：电脑
 */
class PCBrowser extends Browser {

    /**
     * 实现抽象类的抽象方法
     * @see Browser::accept()
     */
    public function accept($visitor) {
        $visitor->visitPCBrowser($this);
    }

}

/**
 * 具体元素类实现
 * 浏览设备：手机
 */
class MBBrowser extends Browser {

    /**
     * 实现抽象类的抽象方法
     * @see Browser::accept()
     */
    public function accept($visitor) {
        $visitor->visitMBBrowser($this);
    }

}

/**
 * 访问者层次结构
 */

/**
 * 访问者抽象接口
 */
interface IVisitor {

    /**
     * 电脑设备访问者类型访问，作用于具体元素的操作
     * @param PCBrowser $pc
     */
    public function visitPCBrowser($pc);

    /**
     * 手机设备访问者类型访问，作用于具体元素的操作
     * @param MBBrowser $mb
     */
    public function visitMBBrowser($mb);
}

/**
 * 具体访问者类实现
 * 设备来源分析
 */
class EquipmentAnalyze implements IVisitor {

    /**
     * 电脑设备来源
     * @see IVisitor::visitPCBrowser()
     */
    public function visitPCBrowser($pc) {
        //do ...
        echo '电脑访问,浏览器是' . $pc->name;
    }

    /**
     * 手机设备来源
     * @see IVisitor::visitMBBrowser()
     */
    public function visitMBBrowser($mb) {
        //do ...
        echo '<br />手机访问,浏览器是' . $mb->name;
    }

}

/**
 * 结构对象
 * 作用：管理访问者,提供访问元素接口
 */
class ObjectStructure {

    private $visitor = array();

    /**
     * 新增访问者
     * @param Object $vis
     */
    public function addVisitor($vis) {
        if (is_object($vis)) {
            $this->visitor[spl_object_hash($vis)] = $vis;
        }
    }

    /**
     * 删除访问者
     * @param Object $vis
     */
    public function delVisitor($vis) {
        if (is_object($vis)) {
            unset($this->visitor[spl_object_hash($vis)]);
        }
    }

    /**
     * 访问者访问元素接口
     * @param Object $vistor
     */
    public function handler($vistor) {
        foreach ($this->visitor as $obj) {
            $obj->accept($vistor);
        }
    }

}

/**
 * 访问者模式demo
 */
///创建访问者管理对象
$os = new ObjectStructure();

///创建具体元素
$pc = new PCBrowser();
$pc->name = '360';
$os->addVisitor($pc);

///创建具体元素
$mb = new MBBrowser();
$mb->name = 'uc';
$os->addVisitor($mb);

///创建访问者
$vistor = new EquipmentAnalyze();

///作用于$os->visitor集合的各个元素
$os->handler($vistor);


