<?php

//php利用缓冲实现动态输出(flush,ob_flush)
//php利用缓冲实现动态输出通过 flush,ob_flush实现

/*
深入理解ob_flush和flush的区别
本文地址: http://www.laruence.com/2010/04/15/1414.html

ob_flush/flush在手册中的描述, 都是刷新输出缓冲区, 并且还需要配套使用, 所以会导致很多人迷惑…

其实, 他们俩的操作对象不同, 有些情况下, flush根本不做什么事情..

ob_*系列函数, 是操作PHP本身的输出缓冲区.

所以, ob_flush是刷新PHP自身的缓冲区.

而flush, 严格来讲, 这个只有在PHP做为apache的Module(handler或者filter)安装的时候, 才有实际作用. 它是刷新WebServer(可以认为特指apache)的缓冲区.

在apache module的sapi下, flush会通过调用sapi_module的flush成员函数指针, 间接的调用apache的api: ap_rflush刷新apache的输出缓冲区, 当然手册中也说了, 有一些apache的其他模块, 可能会改变这个动作的结果..

有些Apache的模块，比如mod_gzip，可能自己进行输出缓存，
这将导致flush()函数产生的结果不会立即被发送到客户端浏览器。 
 
甚至浏览器也会在显示之前，缓存接收到的内容。例如 Netscape
浏览器会在接受到换行或 html 标记的开头之前缓存内容，并且在
接受到 </table> 标记之前，不会显示出整个表格。 
 
一些版本的 Microsoft Internet Explorer 只有当接受到的256个
字节以后才开始显示该页面，所以必须发送一些额外的空格来让这
些浏览器显示页面内容。
所以, 正确使用俩者的顺序是. 先ob_flush, 然后flush,

当然, 在其他sapi下, 不调用flush也可以, 只不过为了保证你代码的可移植性, 建议配套使用.
 */

//复制代码
print str_repeat(" ", 4096);//php.ini output_buffering默认是4069字符或者更大，即输出内容必须达到4069字符服务器才会flush刷新输出缓冲
for ($i=10; $i>0; $i--)
{
    echo $i;
    ob_flush();
    flush();
    sleep(1);
}

//ob_flush()和flush()的区别。前者是把数据从PHP的缓冲中释放出来,后者是把不在缓冲中的或者说是被释放出来的数据发送到浏览器。所以当缓冲存在的时候，我们必须ob_flush()和flush()同时使用。
//复制代码
//复制代码
//附上一段非常有趣的代码,作者为PuTTYshell。在一个脚本周期里，每次输出，都会把前一次的输出覆盖掉。

header('Content-type: multipart/x-mixed-replace;boundary=endofsection');
  print "\n--endofsection\n";

  $pmt = array("-", "\\", "|", "/" );
  for( $i = 0; $i <10; $i ++ ){
     sleep(1);
     print "Content-type: text/plain\n\n";
     print "Part $i\t".$pmt[$i % 4];
     print "--endofsection\n";
     ob_flush();
     flush();
  }
  print "Content-type: text/plain\n\n";
  print "The end\n";
  print "--endofsection--\n";
