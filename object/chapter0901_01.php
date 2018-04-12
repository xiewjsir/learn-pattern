<?php
abstract class Employee { // 雇员
    protected $name;
    function __construct( $name ) {
        $this->name = $name;
    }
    abstract function fire();
}

class Minion extends Employee { // 奴隶 继承 雇员
    function fire() {
        print "{$this->name}: I'll clear my desk\n";
    }
}

class NastyBoss { // 坏老板
    private $employees = array();

    function addEmployee( $employeeName ) { // 添加员工
        $this->employees[] = new Minion( $employeeName ); // 代码灵活性受到限制
    }

    function projectFails() {
        if ( count( $this->employees ) > 0 ) {
            $emp = array_pop( $this->employees );
            $emp->fire(); // 炒鱿鱼
        }
    }
}

$boss = new NastyBoss();
$boss->addEmployee( "harry" );
$boss->addEmployee( "bob" );
$boss->addEmployee( "mary" );
$boss->projectFails();

// output:
// mary: I'll clear my desk
?>