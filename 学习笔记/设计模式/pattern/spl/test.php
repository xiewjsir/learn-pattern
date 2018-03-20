<?php
//echo __DIR__;
//echo dirname(__file__);exit;
//设置可加载类的文件扩展名
//spl_autoload_extensions(".php,.inc.php,.class.php,.lib.php");
////设置include_path,autoload会在这些path中去寻找类文件,可通过PATH_SEPARATOR添加多个path
//set_include_path(__DIR__.'\tmp');//set_include_path(get_include_path() . PATH_SEPARATOR . 'libs/');
////spl_autoload_register();//不提供参数，默认实现函数是spl_autoload() 8 == 9+10
//spl_autoload('test1');
//spl_autoload('test2');
////spl_autoload()它是__autoload()的默认实现，它会去include_path中加载文件(.php/.inc)
//$test1 = new Test1();
//$test2 = new Test2();
//$test1->getFilename();
//echo '<br>';
//$test2->getFilename();
//echo '<br>';

function loader($classname) {
    if ($classname == 'Test1') {
        require __DIR__ . '\tmp\test1.php';
    }
    if ($classname == 'Test2') {
        require __DIR__ . '\tmp\test2.lib.php';
    }
}

spl_autoload_register('loader');
spl_autoload_call('Test2');
//
$test = new Test2();
//$test->getFilename(); //test2.lib.php
//
//var_dump(spl_classes());