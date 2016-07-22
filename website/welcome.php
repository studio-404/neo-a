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
	<div style="margin:0; padding:0; width: 300px; height:178px; position: absolute; left: calc(50% - 151px); top: calc(50% - 90px); background-image: url('<?=$c::WEBSITE.$c::PUBLIC_FOLDER_NAME?>/img/welcomeLogo.png'); background-repeat: no-repeat; background-size: cover; border:solid 2px #ffffff"></div>
</div>