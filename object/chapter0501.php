<?php
/**
 * 类函数
 */
//function __autoload($classname){
//    
//}

namespace tasks;

class Task{
    public $ch = '中文';
    
    function doSpeak(){
        print "hello\n";
    }
}

$classname = "Task";
//if(!file_exists("tasks/{$classname}.php")){    
//    throw new \Exception("no such file as tasks/{$classname}.php");
//}
//
//require_once "tasks/{$classname}.php";

$classname = "tasks\\".$classname;
if(!class_exists($classname)){
    throw new \Exception("no such class as {$classname}");
}

//print_r(get_declared_classes());

$myObj = new $classname();
$myObj->doSpeak();

print_r(get_class($myObj));

if($myObj instanceOf Task){
    print " {$product} is a Task object\n";
}

print_r(get_class_methods($myObj));
print_r(get_class_vars('Task'));