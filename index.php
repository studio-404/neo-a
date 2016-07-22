<?php
session_start();
session_name("studio404");
error_reporting(E_ALL);
ini_set('memory_limit', '256M');
ini_set('display_errors', 1);

date_default_timezone_set("Asia/Tbilisi");

function __autoload($className) { 
	$parts = explode('\\', $className);
	$last = array_pop($parts);
	$pop = implode("/",$parts);
	$path = $pop.'/'.$last.'.php';
	if(file_exists($path)){
    	require $path;
	}else{
		echo "We Could not find $className !";
	}
} 	

$validate = new lib\functions\validate\phpversion();
if(!$validate->check()){
	echo "PHP Version Should be higher then ".$validate->mpv;
	exit();
}
$page = new lib\functions\load\page();
$page->bootstap();
?>
