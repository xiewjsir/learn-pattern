<?php

class Preferences {
    private $props = array();
    private static $instance; // 私有的，静态属性

    private function __construct() { } // 无法实例化，私有的构造函数

    public static function getInstance() { // 返回对象 静态方法才可以被类访问，静态方法中要有静态属性
        if ( empty( self::$instance ) ) {
            self::$instance = new Preferences();
        }
        return self::$instance;
    }

    public function setProperty( $key, $val ) {
        $this->props[$key] = $val;
    }

    public function getProperty( $key ) {
        return $this->props[$key];
    }
}


$pref = Preferences::getInstance();
$pref->setProperty( "name", "matt" );

unset( $pref ); // remove the reference

$pref2 = Preferences::getInstance();
print $pref2->getProperty( "name" ) ."\n"; // demonstrate value is not lost