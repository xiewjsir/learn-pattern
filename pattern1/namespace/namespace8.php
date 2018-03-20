<?php

/**
 * PHP在编译脚本的时候就确定了元素所在的空间，以及导入的情况。而在解析脚本时字符串形式调用只能认为是非限定名称和完全限定名称，而永远不可能是限定名称。
 * @author xiewj
 */

namespace Blog;

//导入Common类
use Blog\Article\Common;

//我想使用非限定名称调用Blog\Article\Common
$common_class_name = 'Common';
//实际会被当作非限定名称，也就表示当前空间的Common类，但我当前类没有创建Common类
$common = new $common_class_name(); //发生致命错误：Common类不存在
//我想使用限定名称调用Blog\Article\Common
$common_class_name = 'Article\Common';
//实际会被当作完全限定名称，也就表示Article空间下的Common类，但我下面只定义了Blog\Article空间而不是Article空间
$common = new $common_class_name(); //发生致命错误：Article\Common类不存在

namespace Blog\Article;

class Common {
    
}
