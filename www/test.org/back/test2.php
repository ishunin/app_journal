<?php
/*
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
$hostame     = $_SERVER['HTTP_HOST'];
$script   = $_SERVER['SCRIPT_NAME'];
$params   = $_SERVER['QUERY_STRING'];
$currentUrl = $protocol . '://' . $hostame . $script . '?' . $params;
#echo $currentUrl;

echo 'http://'.$_SERVER['HTTP_HOST'].'/test.org/index.php';
*/

echo $_SERVER['HTTP_REFERER'];
?>