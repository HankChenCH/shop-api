<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $file_contents;
}

function curl_post($url, $params = array())
{
    $data_string = json_encode($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json;charset=UTF-8'
    ));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getRandChars($length)
{
	$str = null;
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
	$max = strlen($strPol) - 1;

	for ($i=0; $i < $length; $i++) { 
		$str .= $strPol[rand(0,$max)];
	}

	return $str;
}

function getClientIP()  
{  
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"])  
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];  
    else if (@$_SERVER["HTTP_CLIENT_IP"])  
    $ip = $_SERVER["HTTP_CLIENT_IP"];  
    else if (@$_SERVER["REMOTE_ADDR"])  
    $ip = $_SERVER["REMOTE_ADDR"];  
    else if (@getenv("HTTP_X_FORWARDED_FOR"))  
    $ip = getenv("HTTP_X_FORWARDED_FOR");  
    else if (@getenv("HTTP_CLIENT_IP"))  
    $ip = getenv("HTTP_CLIENT_IP");  
    else if (@getenv("REMOTE_ADDR"))  
    $ip = getenv("REMOTE_ADDR");  
    else  
    $ip = "Unknown";  
    return $ip;  
}  