<?php
/*
 * 迭代器模式
 * @author http://blog.samoay.me/post/view/17 
 */

//PHP5提供的Iterator接口，Traversable接口只是为了标识对象是否可以通过foreach迭代，不包含任何方法
//Iterator extends Traversable {
//    /* Methods */
//    abstract public mixed current ( void )
//    abstract public scalar key ( void )
//    abstract public void next ( void )
//    abstract public void rewind ( void )
//    abstract public boolean valid ( void )
//}

class RecordIterator implements Iterator{
    private $position = 0;

    //注意：被迭代对象属性是私有的
    private $records = array();  

    public function __construct(Array $records) {
        $this->position = 0;
        $this->records = $records;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->records[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->records[$this->position]);
    }
}

//容器
interface Aggregate{
    public function getIterator();
}

//具体容器
class RecordList implements Aggregate{
    private $iterator;

    public function __construct($data){
        $this->iterator = new RecordIterator($data);
    }

    public function getIterator(){
        return $this->iterator;
    }
}

/*
//假如我们从MongoDB中读取得到下列数据
$data = array(
    0 => array('field' => 'value'),
    1 => array('field' => 'value'),
    2 => array('field' => 'value'),
    3 => array('field' => 'value'),
);

//使用我们自己定义的迭代器
$records = new RecordIterator($data);
while($records->valid()){
    print_r($records->current());
    $records->next();
}
$records->rewind();
 */

//使用
//假如我们从MongoDB中读取得到下列数据
$data = array(
    0 => array('field' => 'value'),
    1 => array('field' => 'value'),
    2 => array('field' => 'value'),
    3 => array('field' => 'value'),
);
$recordList = new RecordList($data);
$iterator = $recordList->getIterator();
while($iterator->valid()){
    print_r($iterator->current());
    $iterator->next();
}



