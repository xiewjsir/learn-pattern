<?php

/*
 * 命令模式
 * @author http://blog.samoay.me/post/view/15 * 
 * COMMAND—俺有一个MM家里管得特别严，没法见面，只好借助于她弟弟在我们俩之间传送信息，
 * 她对我有什么指示，就写一张纸条让她弟弟带给我。这不，她弟弟又传送过来一个COMMAND，
 * 为了感谢他，我请他吃了碗杂酱面，哪知道他说：“我同时给我姐姐三个男朋友送COMMAND，就数你最小气，才请我吃面。”
 * 命令模式把一个请求或者操作封装到一个对象中。命令模式把发出命令的责任和执行命令的责任分割开，委派给不同的对象。
 * 命令模式允许请求的一方和发送的一方独立开来，使得请求的一方不必知道接收请求的一方的接口，
 * 更不必知道请求是怎么被接收，以及操作是否执行，何时被执行以及是怎么被执行的。系统支持命令的撤消。
 */

 //一次请求往往对应用户的一次操作，因此我们称为Action，也就是模式中的Command Interface
interface ActionInterface{
    public function execute();
}

//具体Action的超类，在标准的Command模式中并没有这一层抽象，完全是根
//据具体业务需求来确定的，这里的超类复制处理所有具体Action的通用操作
abstract class Action implements ActionInterface{
    private $request;
    private $response;

    //这里将请求数据封装为MyRequest对象，返回封装为MyResponse对象
    //其实就是相当于模式中的命令接收者，只不过这里为了区分封装成两个对象了
    public function __construct(MyRequest $request, MyResponse $response){
        $this->request = $request;
        $this->response = $response;
    }

    //这个方法需要具体的Action去实现
    public abstract function execute();
}

//用户登录Action，也就是模式中的Concrete Command
class UserLogin extends Action{
    public function execute(){
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        //实际项目中这里肯定要读取数据库，这里简便处理
        if ($username=='admin' && $password=="111111"){
            $response->assign('status', true);
        }else{
            $response->assign('status', false);
        }
        $response->render("user/login.php");
    }
}

//发布贴子Action，这里省略具体代码，结构和UserLogin Action一致，只是具体逻辑不一样
class AddPost extends Action{
    public function execute(){
        //...
    }
}

//MyRequest和MyResponse对象，也就是模式中的命令接收者
//MyRequest对象负责处理数据输入，实际上的处理逻辑肯定比这里复杂，这里只做简单实现
class MyRequest{
    private $get;
    private $post;

    public function __construct(){
        $this->get = $_GET;
        $this->post = $_POST;
    }

    //获取GET参数
    public function get($name){
        return $this->get[$name];
    }

    //获取POST参数
    public function post($name){
        return $this->post[$name];
    }
}

//MyResponse负责处理数据输出，这里也只做简单实现
class MyResponse{
    private $data;

    //缓存需要输出的数据
    public function assign($name, $value){
        $this->data[$name] = $value;
    }

    //视图输出；实际项目中可能还有纯文本输出（text），JSON格式输出，XML格式输出等等
    public function render($view){
        //使用到缓存的$data数据进行输出，这里简单引用视图PHP文件，具体怎么输出这里不赘述了
        require($view);
    }
}

//命令调用者，实现了路由功能。经典范例中，调用者不负责具体命令的初始化，只负责执行
//已经记录执行的过程（方便做undo得操作），我们这里稍作调整，主要为了实现路由功能
//假设我们这里使用 index.php?action=user/login 的方式，不用rewrite就能测试
class Router{
    public static function route(){
        //初始化命令接收者
        $request = new MyRequest();
        $response = new MyResponse();

        //查询并初始化具体的命令，这里省略了错误处理，比如空action参数，文件不存在，类不存在等
        $action = $request->get('action');
        $actionClass = implode("_", array_walk(explode("/", $action), "ucfirst"));
        require($actionClass.".php");//实际项目中推荐使用SPL Autoloader方式载入
        $action = new $actionClass($request, $response);

        //执行命令
        $action->execute();
    }
}

//入口index.php
require("Router.php");
Router::route(); 

