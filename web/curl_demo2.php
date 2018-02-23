<?php
$url = 'https://www.baidu.com';  

$curl = curl_init();  

curl_setopt($curl, CURLOPT_URL, $url);  

curl_setopt($curl, CURLOPT_HEADER, 1);  

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// 这个是主要参数  

$data = curl_exec($curl);  

curl_close($curl);

$data=mb_convert_encoding($data ,'GBK', 'UTF-8');//使用该函数对结果进行转码
echo $data;
