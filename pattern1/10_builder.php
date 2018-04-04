<?php
/*
 * 建造者模式
 * @author http://blog.sina.com.cn/s/blog_6dbbafe001018vpa.html
 * 
 * 建造者模式可以将一个产品的内部表象与产品的生成过程分割开来，从而可以使一个建造过程生成具有不同的内部表象的产品对象。
 * 目的是为了消除其他对象复杂的创建过程
 */

//产品,包含产品类型、价钱、颜色属性
class Product {
    
    public $_type = null;
    public $_price = null;
    public $_color = null;
    
    public function setType($type) {
        echo 'set the type of the product,';
        $this->_type = $type;
    }

    public function setPrice($price) {
        echo 'set the price of the product,';
        $this->_price = $price;
    }

    public function setColor($color) {
        echo 'set the color of the product,';
        $this->_color = $color;
    }
}

$config = array(
    'type' => 'shirt',
    'price' => 100,
    'color' => 'red',
);

//不使用builder模式
$product = new Product();
$product->setType($config['type']);
$product->setPrice($config['price']);
$product->setColor($config['color']);

//使用builder模式
//builder类
class ProductBuilder {
    public $_config = null;
    public $_object = null;
    public function ProductBuilder($config) {
        $this->_object = new Product();
        $this->_config = $config;
    }

    public function build() {
        echo '<br />Using builder pattern:<br />';
        $this->_object->setType($this->_config['type']);
        $this->_object->setPrice($this->_config['price']);
        $this->_object->setColor($this->_config['color']);
    }

    public function getProduct() {
        return $this->_object;
    }

}

$objBuilder = new ProductBuilder($config);
$objBuilder->build();
$objProduct = $objBuilder->getProduct();
echo '<br />';
var_dump($objProduct);

