<?php
/*
 * 观察者模式
 * @author 
 * 观察者模式又叫做发布-订阅（Publish/Subscribe）模式、模型-视图（Model/View）模式、源-监听器（Source/Listener）模式或从属者（Dependents）模式。
 * 观察者模式定义了一种一对多的依赖关系，让多个观察者对象同时监听某一个主题对象。这个主题对象在状态上发生变化时，会通知所有观察者对象，使它们能够自动更新自己。
 */
class Order{
    //订单号
    private $id;

    //用户ID
    private $userId;

    //用户名
    private $userName;

    //价格
    private $price;

    //下单时间
    private $orderTime;

    //订单数据填充简单模拟，实际应用中可能会读取用户表单输入并处理
    public function __set($name, $value){
        if (isset($this->$name)){
            $this->$name = $value;
        }
    }

    //获取订单属性
    public function __get($name){
        if (isset($this->$name)){
            return $this->$name;
        }
        return "";
    }
}

//被观察者, 负责维护观察者并在变化发生是通知观察者
class OrderSubject implements SplSubject {
    private $observers;
    private $order;

    public function __construct(Order $order) {
        $this->observers = new SplObjectStorage();
        $this->order = $order;
    }

    //增加一个观察者
    public function attach(SplObserver $observer) {
        $this->observers->attach($observer);
    }

    //移除一个观察者
    public function detach(SplObserver $observer) {
        $this->observers->detach($observer);
    }

    //通知所有观察者
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    //返回主体对象的具体实现，供观察者调用
    public function getOrder() {
        return $this->order;
    }
}

//记录业务数据日志 (ActionLogObserver)，实际可能还要抽象一层以处理不同的Action(业务操作)，这里省略
class ActionLogObserver implements SplObserver{
    public function update(SplSubject $subject) {
         $order = $subject->getOrder();
         //实际应用可能会写到日志文件中，这里直接输出
         echo "[OrderId:{$order->id}] [UseId:{$order->userId}] [Price:{$order->price}]";
    }
}

//给用户发送订单确认邮件 (UserMailObserver)
class UserMailObserver implements SplObserver{
    public function update(SplSubject $subject) {
         $order = $subject->getOrder();
         //实际应用会调用邮件发送服务如sendmail，这里直接输出
         echo "Dear {$order->userName}: Your order {$order->id} was confirmed!";
    }
}

//给管理人员发订单处理通知邮件 (AdminMailObserver)
class AdminMailObserver implements SplObserver{
    public function update(SplSubject $subject) {
         $order = $subject->getOrder();
         //实际应用会调用邮件发送服务如sendmail，这里直接输出
         echo "Dear Manager: User {$order->userName}(ID:{$order->userId}) submitted a new order {$order->id}, please handle it ASAP!";
    }
}

//假设的DB类，便于测试，实际会存入真实数据库
class FakeDB{
    public function save($data){
        return true;
    }
}

//初始化一个订单数据
$order = new Order();
$order->id = 1001;
$order->useId = 9527;
$order->userName = "God";
$order->price = 20.0;
$order->orderTime = time();
//绑定观察者
$subject = new OrderSubject($order);
$actionLogObserver = new ActionLogObserver();
$userMailObserver = new UserMailObserver();
$adminMailObserver = new AdminMailObserver();
$subject->attach($actionLogObserver);
$subject->attach($userMailObserver);
$subject->attach($adminMailObserver);
//向数据库保存订单
$db = new FakeDB();
$result = $db->save($order);
if ($result){
    //通知观察者
    $subject->notify();
}
