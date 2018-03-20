<?php
echo 29067489%128+1;exit;
//PHP关于数据的舍入归类:round.ceil.floor.number_format
//round -- 对浮点数进行四舍五入
echo round(3.4). "<br />"; // 3
echo round(3.6). "<br />"; // 4
echo round(3.6, 0). "<br />"; // 4
echo round(1.95583, 2). "<br />"; // 1.96
echo round(1241757, -3). "<br />"; // 1242000
echo round(5.055, 2). "<br />"; // 5.06
//ceil -- 进一法取整
echo ceil(4.3). "<br />"; // 5
echo ceil(9.999). "<br />"; // 10
//floor -- 舍去法取整，跟ceil刚刚相反
echo floor(4.3). "<br />"; // 4
echo floor(9.999). "<br />"; // 9


//number_format -- 格式化数字为千分位
$number = 1234;

// english notation (default)
$english_format_number = number_format($number);
echo "First:" . $english_format_number . "<br />";//First:1,234

// French notation
$nombre_format_francais = number_format($number, 2, ',', ' ');
echo "Second:" . $nombre_format_francais . "<br />";//Second:1 234,00

// French notation
$number = 1234.564;
$nombre_format_francais = number_format($number, 2, ',', ' ');
echo "Third:" . $nombre_format_francais . "<br />";//Third:1 234,56

$number = 1234.5678;

// english notation without thousands seperator
$english_format_number = number_format($number, 2, '.', '');
echo "Forth:" . $english_format_number . "<br />";//Forth:1234.57

//SELECT bid_company_name,bid_name,CASE bid_type WHEN 1 THEN '个人' WHEN 2 THEN '企业' END AS `type` FROM `js_business_identity` WHERE bid_uid IN(111036,115017,123661,123872)
