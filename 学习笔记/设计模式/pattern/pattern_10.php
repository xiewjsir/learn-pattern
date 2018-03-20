<?php
/*
 * 建造者模式
 * @author http://blog.sina.com.cn/s/blog_6dbbafe001018vpa.html
 * 将一个复杂对象的构造与它的表示分离,是同样的构建过程可以创建不同的表示;
 * 目的是为了消除其他对象复杂的创建过程
 * 
 * BUILDER—MM最爱听的就是“我爱你”这句话了，见到不同地方的MM,要能够用她们的方言跟她说这句话哦，我有一个多种语言翻译机，上面每种语言都有一个按键，
 * 见到MM我只要按对应的键，它就能够用相应的语言说出“我爱你”这句话了，国外的MM也可以轻松搞掂，这就是我的“我爱你”builder。（这一定比美军在伊拉克用的翻译机好卖）
 * 将产品的内部表象和产品的生成过程分割开来，从而使一个建造过程生成具有不同的内部表象的产品对象。建造模式使得产品内部表象可以独立的变化，
 * 客户不必知道产品内部组成的细节。建造模式可以强制实行一种分步骤进行的建造过程。
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

