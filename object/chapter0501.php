<?php
/**
 * 类函数
 */
//function __autoload($classname){
//    
//}

namespace tasks;

class Task{
    function doSpeak(){
        print "hello\n";
    }
}

$classname = "Task";
if(!file_exists("tasks/{$classname}.php")){    
    throw new \Exception("no such file as tasks/{$classname}.php");
}

require_once "tasks/{$classname}.php";

$classname = "tasks\\".$classname;
if(!class_exists($classname)){
    throw new \Exception("no such class as {$classname}");
}

$myObj = new $classname();
$myObj->doSpeak();