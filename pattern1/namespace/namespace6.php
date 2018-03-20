<?php

/**
 * 名别名和导入
 * 别名和导入可以看作是调用命名空间元素的一种快捷方式。PHP并不支持导入函数或常量。
 * 注意:如果导入元素的时候，当前空间有相同的名字元素将会怎样？显然结果会发生致命错误。
 * @author xiewj
 */

namespace Blog\Article;

class Comment {
    
}

//创建一个BBS空间（我有打算开个论坛）

namespace BBS;

//导入一个命名空间
use Blog\Article;

//导入命名空间后可使用限定名称调用元素
$article_comment = new Article\Comment();

//为命名空间使用别名
use Blog\Article as Arte;

//使用别名代替空间名
$article_comment = new Arte\Comment();

//导入一个类
use Blog\Article\Comment;

//导入类后可使用非限定名称调用元素
$article_comment = new Comment();

//为类使用别名
use Blog\Article\Comment as Comt;

//使用别名代替空间名
$article_comment = new Comt();
?>

<?php

//namespace Blog\Article;
//class Comment { }
//namespace BBS;
//class Comment { }
//Class Comt { }
//
////导入一个类
//use Blog\Article\Comment;
//$article_comment = new Comment(); //与当前空间的Comment发生冲突，程序产生致命错误
//
////为类使用别名
//use Blog\Article\Comment as Comt;
//$article_comment = new Comt(); //与当前空间的Comt发生冲突，程序产生致命错误
//?>