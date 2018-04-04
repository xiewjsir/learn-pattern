<?php

/**
  策略模式
  策略模式的用意是针对一组算法，将每一个算法封装到具有共同接口的独立的类中，从而使得它们可以相互替换。策略模式使得算法可以在不影响到客户端的情况下发生变化
 * 
  刘备要到江东娶老婆了，走之前诸葛亮给赵云（伴郎）三个锦囊妙计，说是按天机拆开解决棘手问题，嘿，还别说，真是解决了大问题，搞到最后是周瑜陪了夫人又折兵呀，那咱们先看看这个场景是什么样子
  的。
  先说这个场景中的要素：三个妙计，一个锦囊，一个赵云，妙计是小亮同志给的，妙计是放置在锦囊里，俗称就是锦囊妙计嘛，那赵云就是一个干活的人，从锦囊中取出妙计，执行，然后获胜，用 PHP 程序
  怎么表现这个呢
 */
//首先定一个策略接口，这是诸葛亮老人家给赵云的三个锦囊妙计的接口
interface IStrategy {

    function operate();
}

//找乔国老帮忙，使孙权不能杀刘备
class BackDoor implements IStrategy {

    public function operate() {
        echo "找乔国老帮忙，让吴国太给孙权施加压力<br>";
    }

}

//求吴国太开个绿灯
class GivenGreenLight implements IStrategy {

    public function operate() {
        echo "求吴国太开个绿灯,放行！<br>";
    }

}

//孙夫人断后，挡住追兵
class BlockEnemy implements IStrategy {

    public function operate() {
        echo "孙夫人断后，挡住追兵<br>";
    }

}

//计谋有了，那还要有锦囊，其实是容器
class Context {

    var $straegy;

    //构造函数，你要使用那个妙计
    public function __construct($strategy) {
        $this->straegy = $strategy;
    }

    //使用计谋了，看我出招了
    public function operate() {
        $this->straegy->operate();
    }

}

//刚刚到吴国的时候拆第一个
$context = new Context(new BackDoor()); //拿到妙计
$context->operate(); //拆开执行
//刘备乐不思蜀了，拆第二个了
$context = new Context(new GivenGreenLight()); //拿到妙计
$context->operate(); ///执行了第二个锦囊了
//孙权的小兵追了，咋办？拆第三个
$context = new Context(new BlockEnemy()); //拿到妙计
$context->operate(); //夫人退兵