<?php
/**
 * 抽象工厂模式
 * @author https://www.cnblogs.com/lovecucu/p/6069943.html
 */
abstract class CommsManager {

    abstract function getHeaderText();

    abstract function getApptEncoder();

    abstract function getTtdEncoder();

    abstract function getContactEncoder();

    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager {

    function getHeaderText() {
        return "BloggsCal Header\n";
    }

    function getApptEncoder() {
        return new BloggsApptEncoder();
    }

    function getTtdEncoder() {
        return new BloggsTtdEncoder();
    }

    function getContactEncoder() {
        return new BloggsContactEncoder();
    }

    function getFooterText() {
        return "BloggsCal Footer\n";
    }

}

class MegaCommsManager extends CommsManager {

    function getHeaderText() {
        return "MegaCal Header\n";
    }

    function getApptEncoder() {
        return new MegaApptEncoder();
    }

    function getTtdEncoder() {
        return new MegaTtdEncoder();
    }

    function getContactEncoder() {
        return new MegaContactEncoder();
    }

    function getFooterText() {
        return "MegaCal Footer\n";
    }

}


/**
优化版

abstract class CommsManager {
    const APPT = 1;
    const TTD = 2;
    const CONTACT = 3;

    abstract function getHeaderText();
    abstract function make ( $flag_init  );
    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager {
    function getHeaderText()
   {
       return "BloggsCal Header\n";
   }

    function make( $flag_init )
   {
       switch ($flag_init) {
           case self::APPT:
               return new BloggsApptEncoder();
           case self::TTD:
               return new BloggsTtdEncoder();
           case self::CONTACT:
               return new BloggsContactEncoder();
       }
   }

    function getFooterText()
   {
       return "BloggsCal Header\n";
   }
}
 */