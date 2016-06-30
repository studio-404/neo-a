<?php
session_start();
session_name("studio404");

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

$page = new lib\functions\load\page();
$page->bootstap();
?>
