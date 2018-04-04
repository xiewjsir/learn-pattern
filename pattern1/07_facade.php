<?php

/*
 * 门面模式（外观模式）
 * @author http://www.phppan.com/2010/06/php-design-pattern-7-facade/
 * 
  外部与一个子系统的通信必须通过一个统一的门面(Facade)对象进行，这就是门面模式。
  医院的例子
  用一个例子进行说明，如果把医院作为一个子系统，按照部门职能，这个系统可以划分为挂号、门诊、划价、化验、收费、取药等。看病的病人要与这些部门打交道，就如同一个子系统的客户端与一个子系统的各个类打交道一样，不是一件容易的事情。
  首先病人必须先挂号，然后门诊。如果医生要求化验，病人必须首先划价，然后缴款，才能到化验部门做化验。化验后，再回到门诊室。
  解决这种不便的方法便是引进门面模式。可以设置一个接待员的位置，由接待员负责代为挂号、划价、缴费、取药等。这个接待员就是门面模式的体现，病人只接触接待员，由接待员负责与医院的各个部门打交道。

 * template method 是继承关系，父类规定函数调用顺序，子类对各函数进行实现
 * facade 是组合关系，facede 清楚组合进来的类函数调用顺序，这些类不需要继承 facade
 */

class Camera {

    /**
     * 打开录像机
     */
    public function turnOn() {
        echo 'Turning on the camera.<br />';
    }

    /**
     * 关闭录像机
     */
    public function turnOff() {
        echo 'Turning off the camera.<br />';
    }

    /**
     * 转到录像机
     * @param <type> $degrees
     */
    public function rotate($degrees) {
        echo 'rotating the camera by ', $degrees, ' degrees.<br />';
    }

}

class Light {

    /**
     * 开灯
     */
    public function turnOn() {
        echo 'Turning on the light.<br />';
    }

    /**
     * 关灯
     */
    public function turnOff() {
        echo 'Turning off the light.<br />';
    }

    /**
     * 换灯泡
     */
    public function changeBulb() {
        echo 'changing the light-bulb.<br />';
    }

}

class Sensor {

    /**
     * 启动感应器
     */
    public function activate() {
        echo 'Activating the sensor.<br />';
    }

    /**
     * 关闭感应器
     */
    public function deactivate() {
        echo 'Deactivating the sensor.<br />';
    }

    /**
     * 触发感应器
     */
    public function trigger() {
        echo 'The sensor has been trigged.<br />';
    }

}

class Alarm {

    /**
     * 启动警报器
     */
    public function activate() {
        echo 'Activating the alarm.<br />';
    }

    /**
     * 关闭警报器
     */
    public function deactivate() {
        echo 'Deactivating the alarm.<br />';
    }

    /**
     * 拉响警报器
     */
    public function ring() {
        echo 'Ring the alarm.<br />';
    }

    /**
     * 停掉警报器
     */
    public function stopRing() {
        echo 'Stop the alarm.<br />';
    }

}

/**
 * 门面类
 */
class SecurityFacade {
    /* 录像机 */

    private $_camera1, $_camera2;
    /* 灯 */
    private $_light1, $_light2, $_light3;
    /* 感应器 */
    private $_sensor;
    /* 警报器 */
    private $_alarm;

    public function __construct() {
        $this->_camera1 = new Camera();
        $this->_camera2 = new Camera();

        $this->_light1 = new Light();
        $this->_light2 = new Light();
        $this->_light3 = new Light();

        $this->_sensor = new Sensor();
        $this->_alarm = new Alarm();
    }

    public function activate() {
        $this->_camera1->turnOn();
        $this->_camera2->turnOn();

        $this->_light1->turnOn();
        $this->_light2->turnOn();
        $this->_light3->turnOn();

        $this->_sensor->activate();
        $this->_alarm->activate();
    }

    public function deactivate() {
        $this->_camera1->turnOff();
        $this->_camera2->turnOff();

        $this->_light1->turnOff();
        $this->_light2->turnOff();
        $this->_light3->turnOff();

        $this->_sensor->deactivate();
        $this->_alarm->deactivate();
    }

}

/**
 * 客户端
 */
class Client {

    private static $_security;

    /**
     * Main program.
     */
    public static function main() {
        self::$_security = new SecurityFacade();
        self::$_security->activate();
    }

}

Client::main();
?>
