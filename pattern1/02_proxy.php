<?php
/**
代理模式
什么是代理模式呢？我很忙，忙的没空理你，那你要找我呢就先找我的代理人吧，那代理人总要知道被代理人能做哪些事情不能做哪些事情吧，那就是两个人具备同一个接口，代理人虽然不能干活，但是被代理的人能干活呀。 
比如西门庆找潘金莲，那潘金莲不好意思答复呀，咋办，找那个王婆做代理，表现在程序上时这样的：
 */


//定义一种类型的女人，王婆和潘金莲都属于这个类型的女人 
interface KindWomen 
{  
  //这种类型的女人能做什么事情呢？ 
  public function makeEyesWithMan();//抛媚眼 
  public function happyWithMan();//happy what? You know that! 
}
 
//定一个潘金莲是什么样的人 
class PanJinLian implements KindWomen 
{
        public function happyWithMan() {                 
                echo "潘金莲在和男人做那个.....";
        }
        public function makeEyesWithMan() { 
                echo "潘金莲抛媚眼";
        } 
}

//王婆这个人老聪明了，她太老了，是个男人都看不上， 
//但是她有智慧有经验呀，她作为一类女人的代理！ 
class WangPo implements KindWomen { 
        var $kindWomen; 
  
        //她可以是KindWomen的任何一个女人的代理，只要你是这一类型
        public function WangPo($kindWomen = null){ 
                if (empty($kindWomen)) {
                        $this->kindWomen = new PanJinLian();//默认的话，是潘金莲的代理  
                }else{
                        $this->kindWomen = $kindWomen; 
                }
        } 
        //自己老了，干不了，可以让年轻的代替 
        public function happyWithMan() { 
                $this->kindWomen->happyWithMan();  
        }
         //王婆这么大年龄了，谁看她抛媚眼？！ 
        public function makeEyesWithMan() { 
                $this->kindWomen->makeEyesWithMan();  
        }  
}

//定义一个西门庆，这人色中饿鬼 
class XiMenQing 
{ 
  /* 
  * 水浒里是这样写的：西门庆被潘金莲用竹竿敲了一下难道，痴迷了， 
  * 被王婆看到了,  就开始撮合两人好事，王婆作为潘金莲的代理人 
  * 收了不少好处费，那我们假设一下： 
  * 如果没有王婆在中间牵线，这两个不要脸的能成吗？难说的很！ 
  */ 
  public function __construct() { 
        //把王婆叫出来 
        $wangPo = new WangPo();    
        //然后西门庆就说，我要和潘金莲happy，然后王婆就安排了西门庆丢筷子的那出戏: 
          $wangPo->makeEyesWithMan();  //看到没，虽然表面上时王婆在做，实际上爽的是潘金莲 
          $wangPo->happyWithMan(); 
  } 
}

//开搞了
$XiMengQing = new XiMenQing();