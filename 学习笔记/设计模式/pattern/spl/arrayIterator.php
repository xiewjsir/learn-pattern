<?php
/*
 * 
 * ArrayIterator会把对象或数组封装为一个可以通过foreach来操作的类 
 */
$arr = array(
    'a' => 'A',
    'b' => 'B',
    'c' => 'C'
);

$obj = new ArrayIterator($arr);

foreach ($obj as $key => $val){
    echo $obj[$key]."<br>";
}

class my_class{
    public $a = 'A';
    public $b = 'B';
    public $c = 'C';
    public function index(){
        echo 'test';
    }
}

$obj = new ArrayIterator(new my_class());

foreach ($obj as $key => $val){
    echo $obj[$key]."<br>";
}

/**
* 其它SPL 函数介绍:
* class_implements — 返回指定的类实现的所有接口。
* class_parents — 返回指定类的父类。
* class_uses — Return the traits used by the given class
* iterator_apply — 为迭代器中每个元素调用一个用户自定义函数
* iterator_count — 计算迭代器中元素的个数
* iterator_to_array — 将迭代器中的元素拷贝到数组
* spl_autoload_functions — 返回所有已注册的__autoload()函数
* spl_autoload_unregister — 注销已注册的__autoload()函数
* spl_classes — 返回所有可用的SPL类
* spl_object_hash — 返回指定对象的hash id
* 如iterator相关函数使用：
* 复制代码 代码如下:
 */
$iterator = new ArrayIterator(array('recipe' => 'pancakes', 'egg', 'milk', 'flour'));
print_r(iterator_to_array($iterator)); //将迭代器元素转化为数组
echo '<br>';
echo iterator_count($iterator); //计算迭代器元素的个数
echo '<br>';
print_r(iterator_apply($iterator, 'print_item', array($iterator))); //为迭代器每个元素调用自定义函数
echo '<br>';
function print_item(Iterator $iterator) {
    echo strtoupper($iterator->current()) . "\n";
    return TRUE;
}
echo 'test<br>';

$queue = new SplQueue();

/**
 * 可见队列和双链表的区别就是IteratorMode改变了而已，栈的IteratorMode只能为：
 * （1）SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_KEEP  （默认值,迭代后数据保存）
 * （2）SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_DELETE （迭代后数据删除）
 */
$queue->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_DELETE);

//SplQueue::enqueue()其实就是 SplDoublyLinkedList::push()
$queue->enqueue('a');
$queue->enqueue('b');
$queue->enqueue('c');

//SplQueue::dequeue()其实就是 SplDoublyLinkedList::shift()
print_r($queue->dequeue());
echo '<br>';
foreach($queue as $item) {
    echo $item . PHP_EOL;
}
echo '<br>';
print_r($queue);
echo '<br>';