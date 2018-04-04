<?php

// 简单工厂模式
class CommsManager {

    const BLOGGS = 1;
    const MEGA = 2;

    private = $mode;

    public function __construct($mode) {
        $this->mode = $mode;
    }

    // 生成解码器对应的页眉
    public function getHeaderText() {
        switch ($this->mode) {
            case ( self::MEGA ):
                return "MegaCal header\n";
            default:
                return "BloggsCal header\n";
        }
    }

    // 生成解码器
    public function getApptEncoder() {
        switch ($this->mode) {
            case ( self::MEGA ):
                return new MegaApptEncoder();
            default:
                return new BloggsApptEncoder();
                ;
        }
    }

}
