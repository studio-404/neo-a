<?php
// echo "<pre>";
// print_r($select);
// echo "</pre>";
$image = new lib\functions\image\crop(); 
$src = $image->dojob(
	$c::WEBSITE.$c::PUBLIC_FOLDER_NAME."/img/welcome/".$select['main_image'], 
	1300, 
	785, 
	1
);
?>
<div style="background-image: url(<?=$src?>); background-repeat: no-repeat; background-size: cover; width:100%; height:100%; position:absolute; cursor: pointer" onclick="Studio404.goToProjectPage()">
</div>