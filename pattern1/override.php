<?php

/* * *  
  ====笔记部分====
  重写/覆盖  override
  指:子类重写了父类的同名方法
  重载: overload
  重载是指:存在多个同名方法,但参数类型/个数不同.
  传不同的参数,调用不同的方法
  但是在PHP中,不允许存在多个同名方法.
  因此,不能够完成java,c++中的这种重载
  但是,PHP的灵活,能达到类似的效果
 * * */
/* * **  
  代码部分
 * ** */

class human {

    public function say($name) {
        echo $name, " 吃了吗?\n";
    }

}

class stu extends human {

    public function say() {
        echo "切克闹,卡猫百比\n";
    }

    /*
      public function say($a,$b,$c){
      echo "哥仨好";
      }
      报错:
      Fatal error: Cannot redeclare stu::say() in D:\wamp\www\php\61.php on line 28
      在PHP中,不允许存在多个同名方法,没有重载概念这一说。
     */
}

$li = new stu();
$li->say();
$li->say("binghui"); // 上面这个过程叫重写override!   
/*
  结果:
  切克闹,卡猫百比
  切克闹,卡猫百比
 */

//在PHP中模拟重载的方法  
class Calc {

    public function area() {
        // 判断一个调用area时,得到的参数个数   
        $args = func_get_args();
        if (count($args) == 1) {
            return 3.14 * $args[0] * $args[0];
        } else if (count($args) == 2) {
            return $args[0] * $args[1];
        } else {
            return "未知图形";
        }
    }

}

$calc = new Calc();
// 计算圆的页面   
echo $calc->area(10), "\n";
// 计算矩形的面积   
echo $calc->area(5, 8);
?>  