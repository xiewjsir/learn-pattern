<?php

/*
  =
  =
  !=
 */
$str1 = null;
$str2 = false;
echo $str1 == $str2 ? '=' : '!=';
echo '<br>';
$str3 = '';
$str4 = 0;
echo $str3 == $str4 ? '=' : '!=';
echo '<br>';
$str5 = 0;
$str6 = '0';
echo $str5 === $str6 ? '=' : '!=';
echo '<br>';

/**
  true
  true
  true
  true
  true
  false
  true
 */
$a1 = null;
$a2 = false;
$a3 = 0;
$a4 = '';
$a5 = '0';
$a6 = 'null';
$a7 = array();
$a8 = array(array());
echo empty($a1) ? 'true' : 'false';
echo '<br>';
echo empty($a2) ? 'true' : 'false';
echo '<br>';
echo empty($a3) ? 'true' : 'false';
echo '<br>';
echo empty($a4) ? 'true' : 'false';
echo '<br>';
echo empty($a5) ? 'true' : 'false';
echo '<br>';
echo empty($a6) ? 'true' : 'false';
echo '<br>';
echo empty($a7) ? 'true' : 'false';
echo '<br>';

/*
  5
  0
  1
 */
$count = 5;

function get_count() {
    static $count = 0;
    return $count++;
}

echo $count;
echo '<br>';
++$count;
echo get_count();
echo '<br>';
echo get_count();
echo '<br>';


$GLOBALS['var1'] = 5;
$var2 = 1;

function get_() {
    global $var2;
    $var1 = 0;
    return $var2++;
}

get_();
echo $var1;
echo '<br>';
echo $var2;
echo '<br>';

$a = '6';
$b = &$a;
echo $a.':'.$b;
echo '<br>';
unset($a);
echo $b;
echo '<br>';

function get_arr($arr) {//传地址时 allow_call_time_pass_reference = Off会警告，正确写法get_arr(& $arr)
    unset($arr[0]);
}

$arr1 = array(1, 2);
$arr2 = array(1, 2);
get_arr(&$arr1);
get_arr($arr2);
echo count($arr1);
echo '<br>';
echo count($arr2);
echo '<br>';

function get_ext1($file_name) {
    return strrchr($file_name, '.');
}

function get_ext2($file_name) {
    return substr($file_name, strrpos($file_name, '.'));
}

function get_ext3($file_name) {
    return array_pop(explode('.', $file_name));
}

function get_ext4($file_name) {
    $p = pathinfo($file_name);
    return $p['extension'];
}

function get_ext5($file_name) {
    return strrev(substr(strrev($file_name), 0, strpos(strrev($file_name), '.')));
}

//冒泡排序（数组排序）
function bubble_sort($array) {
    $count = count($array);
    if ($count <= 0)
        return false;

    for ($i = 0; $i < $count; $i++) {
        for ($j = $count - 1; $j > $i; $j--) {
            if ($array[$j] < $array[$j - 1]) {
                $tmp = $array[$j];
                $array[$j] = $array[$j - 1];
                $array[$j - 1] = $tmp;
            }
        }
    }
    return $array;
}

//快速排序（数组排序）
function quick_sort($array) {
    if (count($array) <= 1)
        return $array;
    $key = $array[0];
    $left_arr = array();
    $right_arr = array();
    for ($i = 1; $i < count($array); $i++) {
        if ($array[$i] <= $key)
            $left_arr[] = $array[$i];
        else
            $right_arr[] = $array[$i];
    }
    $left_arr = quick_sort($left_arr);
    $right_arr = quick_sort($right_arr);
    return array_merge($left_arr, array($key), $right_arr);
}

//二分查找（数组里查找某个元素）
function bin_sch($array, $low, $high, $k) {
    if ($low <= $high) {
        $mid = intval(($low + $high) / 2);
        if ($array[$mid] == $k) {
            return $mid;
        } elseif ($k < $array[$mid]) {
            return bin_sch($array, $low, $mid - 1, $k);
        } else {
            return bin_sch($array, $mid + 1, $high, $k);
        }
    }
    return -1;
}

//顺序查找（数组里查找某个元素）
function seq_sch($array, $n, $k) {
    $array[$n] = $k;
    for ($i = 0; $i < $n; $i++) {
        if ($array[$i] == $k) {
            break;
        }
    }
    if ($i < $n) {
        return $i;
    } else {
        return -1;
    }
}

//二维数组排序， $arr是数据，$keys是排序的健值，$order是排序规则，1是升序，0是降序
function array_sort($arr, $keys, $order = 0) {
    if (!is_array($arr)) {
        return false;
    }

    $keysvalue = array();
    foreach ($arr as $key => $val) {
        $keysvalue[$key] = $val[$keys];
    }
    if ($order == 0) {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $key => $vals) {
        $keysort[$key] = $key;
    }
    $new_array = array();
    foreach ($keysort as $key => $val) {
        $new_array[$key] = $arr[$val];
    }
    return $new_array;
}

//输出数组中的当前元素和下一个元素的值，然后把数组的内部指针重置到数组中的第一个元素：
$people = array("Bill", "Steve", "Mark", "David");
echo current($people) . "<br>";
echo next($people) . "<br>";
echo reset($people);

/* 一个表中的Id有多个记录，把所有这个id的记录查出来，并显示共有多少条记录数，用SQL语句及视图、存储过程分别实现。
  存储过程：
  DELIMITER
  create procedure proc_countNum(in columnId int,out rowsNo int)
  begin
  select count(*) into rowsNo from member where member_id=columnId;
  end
  call proc_countNum(1,@no);
  select @no;
  视图：
  create view v_countNum as select member_id,count(*) as countNum from member group by member_id
  select countNum from v_countNum where member_id=1
 */

//写一个函数，能够遍历一个文件夹下的所有文件和子文件夹。
function my_scandir($dir) {
    $files = array();
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false) {
            if ($file != ".." && $file != ".") {
                if (is_dir($dir . "/" . $file)) {
                    $files[$file] = scandir($dir . "/" . $file);
                } else {
                    $files[] = $file;
                }
            }
        }
        closedir($handle);
        return $files;
    }
}

//写一个函数，算出两个文件的相对路径
function getRelativePath($a, $b) {
    $returnPath = array(dirname($b));
    $arrA = explode('/', $a);
    $arrB = explode('/', $returnPath[0]);
    for ($n = 1, $len = count($arrB); $n < $len; $n++) {
        if ($arrA[$n] != $arrB[$n]) {
            break;
        }
    }
    if ($len - $n > 0) {
        $returnPath = array_merge($returnPath, array_fill(1, $len - $n, '..'));
    }

    $returnPath = array_merge($returnPath, array_slice($arrA, $n));
    return implode('/', $returnPath);
}

//echo getRelativePath($a, $b);


/*
 高可用（HA）
 Keepalived使用的vrrp协议方式，虚拟路由冗余协议 (Virtual Router Redundancy Protocol，简称VRRP)；
而Heartbeat是基于主机或网络的服务的高可用方式；

LVS工作模式原理、以及优缺点比较
 * 
一、NAT模式（VS-NAT）
原理：就是把客户端发来的数据包的IP头的目的地址，在负载均衡器上换成其中一台RS的IP地址，并发至此RS来处理,RS处理完成后把数据交给经过负载均衡器,负载均衡器再把数据包的原IP地址改为自己的IP，将目的地址改为客户端IP地址即可｡期间,无论是进来的流量,还是出去的流量,都必须经过负载均衡器｡
优点：集群中的物理服务器可以使用任何支持TCP/IP操作系统，只有负载均衡器需要一个合法的IP地址。
缺点：扩展性有限。当服务器节点（普通PC服务器）增长过多时,负载均衡器将成为整个系统的瓶颈，因为所有的请求包和应答包的流向都经过负载均衡器。当服务器节点过多时，大量的数据包都交汇在负载均衡器那，速度就会变慢！

 二、IP隧道模式（VS-TUN）
原理：首先要知道，互联网上的大多Internet服务的请求包很短小，而应答包通常很大。那么隧道模式就是，把客户端发来的数据包，封装一个新的IP头标记(仅目的IP)发给RS,RS收到后,先把数据包的头解开,还原数据包,处理后,直接返回给客户端,不需要再经过负载均衡器｡注意,由于RS需要对负载均衡器发过来的数据包进行还原,所以说必须支持IPTUNNEL协议｡所以,在RS的内核中,必须编译支持IPTUNNEL这个选项
优点：负载均衡器只负责将请求包分发给后端节点服务器，而RS将应答包直接发给用户。所以，减少了负载均衡器的大量数据流动，负载均衡器不再是系统的瓶颈，就能处理很巨大的请求量，这种方式，一台负载均衡器能够为很多RS进行分发。而且跑在公网上就能进行不同地域的分发。
缺点：隧道模式的RS节点需要合法IP，这种方式需要所有的服务器支持”IP Tunneling”(IP Encapsulation)协议，服务器可能只局限在部分Linux系统上。

三、直接路由模式（VS-DR）
原理：负载均衡器和RS都使用同一个IP对外服务｡但只有DR对ARP请求进行响应,所有RS对本身这个IP的ARP请求保持静默｡也就是说,网关会把对这个服务IP的请求全部定向给DR,而DR收到数据包后根据调度算法,找出对应的RS,把目的MAC地址改为RS的MAC（因为IP一致）并将请求分发给这台RS｡这时RS收到这个数据包,处理完成之后，由于IP一致，可以直接将数据返给客户，则等于直接从客户端收到这个数据包无异,处理后直接返回给客户端｡由于负载均衡器要对二层包头进行改换,所以负载均衡器和RS之间必须在一个广播域,也可以简单的理解为在同一台交换机上｡
优点：和TUN（隧道模式）一样，负载均衡器也只是分发请求，应答包通过单独的路由方法返回给客户端。与VS-TUN相比，VS-DR这种实现方式不需要隧道结构，因此可以使用大多数操作系统做为物理服务器。
缺点：（不能说缺点，只能说是不足）要求负载均衡器的网卡必须与物理网卡在一个物理段上。
 */ 

//MySQL的高可用架构(很多同学也爱说成是MySQL集群)了，目前可行的方案有：
//MySQL Cluster

//DRBD磁盘网络镜像方案 Distributed Replicated Block Device
//单主模式：典型的高可靠性集群方案。
//复主模式：需要采用共享cluster文件系统，如GFS和OCFS2。用于需要从2个节点并发访问数据的场合，需要特别配置。
//复制模式：3种模式：

//MySQL Replication