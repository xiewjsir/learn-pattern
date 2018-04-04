<?php
/*
 * 模板方法模式
 * @author http://blog.samoay.me/post/view/24
 * 
 * TEMPLATE METHOD——看过《如何说服女生上床》这部经典文章吗?女生从认识到上床的不变的步骤分为巧遇、打破僵局、展开追求、接吻、前戏、动手、爱抚、进去八大步骤(Template method)，
 * 但每个步骤针对不同的情况，都有不一样的做法，这就要看你随机应变啦(具体实现);
 * 模板方法模式准备一个抽象类，将部分逻辑以具体方法以及具体构造子的形式实现，然后声明一些抽象方法来迫使子类实现剩余的逻辑。
 * 不同的子类可以以不同的方式实现这些抽象方法，从而对剩余的逻辑有不同的实现。先制定一个顶级逻辑框架，而将逻辑的细节留给具体的子类去实现。
 * 
 * 准备一个抽象类，将部分逻辑以具体方法以及具体构造子的形式实现，然后声明一些抽象方法来迫使子类实现剩余的逻辑。
 * 不同的子类可以以不同的方式实现这些抽象方法，从而对剩余的逻辑有不同的实现。这就是模版方法模式的用意。
 * 
 * template method 是继承关系，父类规定函数调用顺序，子类对各函数进行实现
 * facade 是组合关系，facede 清楚组合进来的类函数调用顺序，这些类不需要继承 facade
 */
//父类，抽象类
abstract class Controller{
    //封装了输入输出
    protected $request;
    protected $response;

    //返回数据
    protected $data;

    public function __construct($request, $response){
        $this->request = $request;
        $this->response = $response;
    }

    //执行请求函数，定义总体算法（template method），final防止被复写（不允许子类改变总体算法）
    public final function execute(){
        $this->before();
        if ($this->valid()){
            $this->handleRequest();
        }
        $this->after();
    }

    //定义hook method before，做一些具体请求的前置处理
    //非abstract方法，子类可以选择覆盖或不覆盖，默认什么都不做
    protected function before(){

    }

    //定义hook method valid，做请求的数据验证
    //非abstract方法，子类可以选择覆盖或不覆盖，默认返回验证通过
    protected function valid(){
        return true;
    }

    //定义hook method handleRequest，处理请求
    //定义为abstract方法，子类必须实现或也声明为抽象方法(由子类的子类负责实现)
    abstract function handleRequest();

    //定义hook method after，做一些请求的后置处理
    //非abstract方法，子类可以选择覆盖或不覆盖，默认直接输出数据
    protected function after(){
        $this->response->render($this->data);
    }
}

//子类1，实现父类开放的具体算法
class User extends Controller{
    //覆盖before方法，实现具体算法，这是一个处理用户数据操作的控制器
    //因此，我们选择在before里面判断用户是否已经登录了，这里简单判断下session数据
    function before(){
        if (empty($_SESSION['auth'])){
            //没登录就直接跳转了，不再执行后续的操作
            $this->response->redirect("user/login.php");
        }
    }

    //覆盖valid方法，这里我们验证用户提交数据中有没有带验证token
    function valid(){
        if (isset($this->request->token)){
            return true;
        }
        return false;
    }

    //覆盖handleRequest方法，必选，以为父类中声明了abstract了
    function handleRequest(){
        //做具体处理，一般根据参数执行不同的业务逻辑
    }

    //这个类我们选择不覆盖after方法，使用默认处理方式
}

//子类2，实现父类开放的具体算法
class Post extends Controller{
    //这个类我们选择不覆盖before方法，使用默认处理方式

    //这个类我们选择不覆盖valid方法，使用默认处理方式

    //覆盖handleRequest方法，必选，以为父类中声明了abstract了
    function handleRequest(){
        //做具体处理，一般根据参数执行不同的业务逻辑
        $this->data = $some_data;
    }

    //覆盖after方法，使用json格式输出数据
    function after(){
        $this->response->json($this->data);
    }
}

//最终调用
$user = new User();
$user->execute($request, $response);

