<?php
/**
 * 要注意的是，当前脚本文件的第一个命名空间前面不能有任何代码，下面的写法都是错误的：
 * 为什么要说第一个命名空间呢？因为同一脚本文件中可以创建多个命名空间。
 * 下面我创建了两个命名空间，顺便为这两个空间各自添加了一个Comment类元素： *
 * @author xiewj
 */
namespace Article;

class Comment {
    public function index(){
        echo 'this is namespace Article<br>';
    }
}

namespace MessageBoard;

class Comment {
    public function index(){
        echo 'this is namespace MessageBoard<br>';
    }    
}

//调用当前空间（MessageBoard）的Comment类
$comment = new Comment();
$comment->index();

//调用Article空间的Comment类
$article_comment = new \Article\Comment();
$article_comment->index();
