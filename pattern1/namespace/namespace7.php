<?php

/**
 * PHP提供了namespace关键字和__NAMESPACE__魔法常量动态的访问元素，__NAMESPACE__可以通过组合字符串的形式来动态访问：
 * @author xiewj
 */

namespace Blog\Article;

const PATH = '/Blog/article';

class Comment {
    
}

//namespace关键字表示当前空间
echo namespace\PATH; ///Blog/article
echo '<br>';
$comment = new namespace\Comment();

//魔法常量__NAMESPACE__的值是当前空间名称
echo __NAMESPACE__; //Blog\Article
echo '<br>';
//可以组合成字符串并调用
$comment_class_name = __NAMESPACE__ . '\Comment';
$comment = new $comment_class_name();
?>



<?php

//上面的动态调用的例子中，我们看到了字符串形式的动态调用方式，如果要使用这种方式要注意两个问题。
// 使用双引号的时候特殊字符可能被转义 

namespace Blog\Article;

class name {
    
}

//我是想调用Blog\Article\name
$class_name = __NAMESPACE__ . "\name"; //但是\n将被转义为换行符

$name = new $class_name(); //发生致命错误
?>

