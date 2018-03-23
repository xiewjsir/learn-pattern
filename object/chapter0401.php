<?php

/**
 * 延迟静态绑定
 */

namespace test;

abstract class DomainObject {

    private $group;

    public function __construct() {
        $this->group = static::getGroup();
    }

    public static function create() {
        return new static(); //return new self();
    }
    
    public static function getGroup(){
        return 'default';
    }
    
    abstract public function execute();
}

class User extends DomainObject {

    public function execute() {
        echo __CLASS__ . PHP_EOL;
    }

}

class Document extends DomainObject {

    public function execute() {
        echo __CLASS__ . PHP_EOL;
    }
    
    static function getGroup(){
        return "document";
    }

}

class SpreadSheet extends Document{
    
}

$object = Document::create();
$object->execute();

print_r(User::create());
print_r(SpreadSheet::create());
