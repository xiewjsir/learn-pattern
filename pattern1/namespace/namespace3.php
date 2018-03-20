<?php

/**
 * 命名空间的调用语法像文件路径一样是有道理的，它允许我们自定义子空间来描述各个空间之间的关系。
 * 抱歉我忘了说，article和message board这两个模块其实都是处于同一个blog项目内。如果用命名空间来表达它们的关系，是这样：
 * @author xiewj
 */
//我用这样的命名空间表示处于blog下的article模块

namespace Blog\Article;

class Comment {

    public function index() {
        echo 'this is namespace Article<br>';
    }

}

//我用这样的命名空间表示处于blog下的message board模块

namespace Blog\MessageBoard;

class Comment {

    public function index() {
        echo 'this is namespace MessageBoard<br>';
    }

}

//调用当前空间的类
$comment = new Comment();
$comment->index();
//调用Blog\Article空间的类
$article_comment = new \Blog\Article\Comment();
$article_comment->index();
