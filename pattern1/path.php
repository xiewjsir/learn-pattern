<?php

$path = "/var/www/page.php";
//显示带有文件扩展名的文件名，输出page.php
echo basename($path)."\n";
//显示不带有文件扩展名的文件名，输出page
echo basename($path,".php")."\n";

echo dirname($path)."\n";

print_r(pathinfo($path));

/*
  =
  =
  !=
 */
$str1 = null;
$str2 = false;
echo $str1 == $str2 ? '=' : '!=';
echo "\n";
$str3 = '';
$str4 = 0;
echo $str3 == $str4 ? '=' : '!=';
echo "\n";
$str5 = 0;
$str6 = '0';
echo $str5 === $str6 ? '=' : '!=';
echo "\n";

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
echo "\n";
echo empty($a2) ? 'true' : 'false';
echo "\n";
echo empty($a3) ? 'true' : 'false';
echo "\n";
echo empty($a4) ? 'true' : 'false';
echo "\n";
echo empty($a5) ? 'true' : 'false';
echo "\n";
echo empty($a6) ? 'true' : 'false';
echo "\n";
echo empty($a7) ? 'true' : 'false';
echo "\n";
echo empty($a8) ? 'true' : 'false';
echo "\n\n\n\n\n";

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

echo $count;//5
echo "\n";
++$count;
echo get_count();//0
echo "\n";
echo get_count();//1
echo "\n\n\n\n\n";


$GLOBALS['var1'] = 5;
$var2 = 1;
function get_() {
    global $var2;
    $var1 = 0;
    return $var2++;
}

get_();
echo $var1;
echo "\n";
echo $var2;
echo "\n\n\n\n\n";

$a = '6';
$b = &$a;
echo $a.':'.$b;
echo "\n";
unset($a);
echo $b;
echo "\n\n\n\n\n";

function get_arr($arr) {//传地址时 allow_call_time_pass_reference = Off会警告，正确写法get_arr(& $arr)
    unset($arr[0]);
}

$arr1 = array(1, 2);
$arr2 = array(1, 2);
get_arr($arr1);
get_arr($arr2);
echo count($arr1);
echo "\n";
echo count($arr2);
echo "\n\n\n\n\n";

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

/**
 * 冒泡排序
 * 它重复地走访过要排序的数列，一次比较两个元素，如果他们的顺序错误就把他们交换过来。走访数列的工作是重复地进行直到没有再需要交换，也就是说该数列已经排序完成。
 * @param type $array
 * @return boolean
 */
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

/**
 * 快速排序（数组排序）
 * 通过一趟排序将要排序的数据分割成独立的两部分，其中一部分的所有数据都比另外一部分的所有数据都要小，
 * 然后再按此方法对这两部分数据分别进行快速排序，整个排序过程可以递归进行，以此达到整个数据变成有序序列
 * @param type $array
 * @return type
 */
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
function bin_sch($x,$a){
    $c=count($a);
    $lower=0;
    $high=$c-1;
    while($lower<=$high){
        $middle=intval(($lower+$high)/2);
        if($a[$middle]>$x){
            $high=$middle-1;
        } elseif($a[$middle]<$x){
            $lower=$middle+1;
        } else{
            return $middle;
        }
    }
    return -1;
}

/**
 * 顺序查找（数组里查找某个元素）
 * @param array $array
 * @param type $n 数组长充
 * @param type $k 查找的元素
 * @return int
 */
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


//输出数组中的当前元素和下一个元素的值，然后把数组的内部指针重置到数组中的第一个元素：
$people = array("Bill", "Steve", "Mark", "David");
echo current($people) . "\n";
echo next($people) . "\n";
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

function getRelativePath2($a,$b){
    $return_path = array(dirname($b));
    $arr_a = explode('/', $a);
    $arr_b = explode('/',$return_path[0]);
    foreach ($arr_a as $n=>$val){
        if($val != $arr_b[$n]){
            ++$n;
            break;
        }
    }
    
    $len = count($arr_a);
    if($len - $n > 0){
        $return_path = array_merge($return_path, array_fill(1, $len-$n,'..'));
    }
    
    $return_path = array_merge($return_path, array_slice($arr_a, $n));
    return implode('/', $return_path);
}