<?php
/**
 * 在不同空间之间不可以直接调用其它元素，需要使用命名空间的语法
 * @author xiewj
 */
namespace Article;

const PATH = '/article';

function getCommentTotal() {
    return 100;
}

class Comment { }


namespace MessageBoard;

const PATH = '/message_board<br>';

function getCommentTotal() {
    return 300;
}

class Comment { }

//调用当前空间的常量、函数和类
echo PATH; ///message_board
echo getCommentTotal(); //300
$comment = new Comment();

//调用Article空间的常量、函数和类
echo \Article\PATH; ///article
echo \Article\getCommentTotal(); //100
$article_comment = new \Article\Comment();
