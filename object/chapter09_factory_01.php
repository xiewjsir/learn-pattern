<?php
abstract class ApptEncoder {
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder {
    function encode() {
        return "Appointment data encoded in BloggsCal format\n";
    }
}

class MegaApptEncoder extends ApptEncoder {
    function encode() {
        return "Appointment data encoded in MegaCal format\n";
    }
}

class CommsManager { // 负责生产Bloggs对象
    function getApptEncoder() {
        return new BloggsApptEncoder();
    }
}

$obj = new CommsManager();
$bloggs = $obj->getApptEncoder(); // 获取对象
print $bloggs->encode();
