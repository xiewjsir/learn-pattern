<?php

/**
 * 在一个命名空间里引入这个脚本，脚本里的元素不会归属到这个命名空间。
 * 如果这个脚本里没有定义其它命名空间，它的元素就始终处于公共空间中：
 * @author xiewj
 */

//引入脚本文件
include './common_inc.php';

$filter_XSS = new FilterXSS(); //出现致命错误：找不到Blog\Article\FilterXSS类

$filter_XSS = new \FilterXSS(); //正确
