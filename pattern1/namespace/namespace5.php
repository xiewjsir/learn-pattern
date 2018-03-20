<?php

/**
 * 名称术语
 * 在说别名和导入之前，需要知道关于空间三种名称的术语，以及PHP是怎样解析它们的。官方文档说得非常好，我就直接拿来套了。
 * 1.非限定名称，或不包含前缀的类名称，例如 $comment = new Comment();。如果当前命名空间是Blog\Article，
 * Comment将被解析为Blog\Article\Comment。如果使用Comment的代码不包含在任何命名空间中的代码（全局空间中），则Comment会被解析为Comment。
 * 2.限定名称，或包含前缀的名称，例如 $comment = new Article\Comment();。如果当前的命名空间是Blog，
 * 则Comment会被解析为Blog\Article\Comment。如果使用Comment的代码不包含在任何命名空间中的代码（全局空间中），则Comment会被解析为Comment。
 * 3.完全限定名称，或包含了全局前缀操作符的名称，例如 $comment = new \Article\Comment();。
 * 在这种情况下，Comment总是被解析为代码中的文字名(literal name)Article\Comment。 
 * 其实可以把这三种名称类比为文件名（例如 comment.php）、相对路径名（例如 ./article/comment.php）、绝对路径名（例如 /blog/article/comment.php），这样可能会更容易理解。
 * @author xiewj
 */
//创建空间Blog

namespace Blog;

class Comment {
    
}

//非限定名称，表示当前Blog空间
//这个调用将被解析成 Blog\Comment();
$blog_comment = new Comment();

//限定名称，表示相对于Blog空间
//这个调用将被解析成 Blog\Article\Comment();
$article_comment = new Article\Comment(); //类前面没有反斜杆\
//完全限定名称，表示绝对于Blog空间
//这个调用将被解析成 Blog\Comment();
$article_comment = new \Blog\Comment(); //类前面有反斜杆\
//完全限定名称，表示绝对于Blog空间
//这个调用将被解析成 Blog\Article\Comment();
$article_comment = new \Blog\Article\Comment(); //类前面有反斜杆\
//创建Blog的子空间Article

namespace Blog\Article;

class Comment {
    
}
