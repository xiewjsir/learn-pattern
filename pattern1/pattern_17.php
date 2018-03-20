<?php

/*
 * 责任链模式
 * @author http://developer.51cto.com/art/201004/192256.htm
 * 
 * CHAIN OF RESPONSIBLEITY—晚上去上英语课，为了好开溜坐到了最后一排，哇，前面坐了好几个漂亮的MM哎，
 * 找张纸条，写上“Hi,可以做我的女朋友吗？如果不愿意请向前传”，纸条就一个接一个的传上去了，糟糕，
 * 传到第一排的MM把纸条传给老师了，听说是个老处女呀，快跑!
 * 在责任链模式中，很多对象由每一个对象对其下家的引用而接起来形成一条链。
 * 请求在这个链上传递，直到链上的某一个对象决定处理此请求。
 * 客户并不知道链上的哪一个对象最终处理这个请求，
 * 系统可以在不影响客户端的情况下动态的重新组织链和分配责任。
 * 处理者有两个选择：承担责任或者把责任推给下家。一个请求可以最终不被任何接收端对象所接受。
 */

/** * The Handler abstraction. Objects that want to be a part of the   
 *  ChainOfResponsibility must implement this interface directly or via   
 *  inheritance from an AbstractHandler.
 */ 
interface KeyValueStore {
    /** 
     * Obtain a value.
     * @param string $key
     * @return mixed
    */
    public function get($key);
}

/**
 * Basic no-op implementation which ConcreteHandlers not interested in 
 * caching or in interfering with the retrieval inherit from.
 */

abstract class AbstractKeyValueStore implements KeyValueStore {

    protected $_nextHandler;

    public function get($key) {
        return $this->_nextHandler->get($key);
    }

}

/**
 Ideally the last ConcreteHandler in the chain. At least, if inserted in
 a Chain it will be the last node to be called.
 */

class SlowStore implements KeyValueStore { /** * This could be a somewhat slow store: a database or a flat file.       */

    protected $_values;

    public function __construct(array $values = array()) {
        $this->_values = $values;
    }

    public function get($key) {
        return $this->_values[$key];
    }

}

/**
 * A ConcreteHandler that handles the request for a key by looking for it in
 * its own cache. Forwards to the next handler in case of cache miss.
 */

class InMemoryKeyValueStore implements KeyValueStore {

    protected $_nextHandler;
    protected $_cached = array();

    public function __construct(KeyValueStore $nextHandler) {
        $this->_nextHandler = $nextHandler;
    }

    protected function _load($key) {
        if (!isset($this->_cached[$key])) {
            $this->_cached[$key] = $this->_nextHandler->get($key);
        }
    }

    public function get($key) {
        $this->_load($key);
        return $this->_cached[$key];
    }

}

/** * A ConcreteHandler that delegates the request without trying to
 * understand it at all. It may be easier to use in the user interface
 * because it can specialize itself by defining methods that generates
 * html, or by addressing similar user interface concerns.   
 * Some Clients see this object only as an instance of KeyValueStore   
 * and do not care how it satisfy their requests, while other ones   
 * may use it in its entirety (similar to a class-based adapter).   
 * No client knows that a chain of Handlers exists.
 */
class FrontEnd extends AbstractKeyValueStore {

    public function __construct(KeyValueStore $nextHandler) {
        $this->_nextHandler = $nextHandler;
    }

    public function getEscaped($key) {
        return htmlentities($this->get($key), ENT_NOQUOTES, 'UTF-8');
    }

}

// Client code  
$store = new SlowStore(
        array(
            'pd' => 'Philip K. Dick',
            'ia' => 'Isaac Asimov',
            'ac' => 'Arthur C. Clarke',
            'hh' => 'Helmut Heißenbüttel'
            )
        );  // in development, we skip cache and pass $store directly to FrontEnd  
$cache = new InMemoryKeyValueStore($store);
$frontEnd = new FrontEnd($cache);
echo $frontEnd->get('ia')."\n";
echo $frontEnd->getEscaped('hh')."\n"; 
