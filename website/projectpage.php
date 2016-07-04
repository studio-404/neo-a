<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="leftside">
		<div class="title"><?=$this->projectDesc[0]["row3"]?></div>
		<div class="text">
			<?=$this->projectDesc[0]["row4"]?>
		</div>
	</div>
	<div class="rightside">
		<?php
			if(is_array($this->projectPhotos) && count($this->projectPhotos)){
				foreach ($this->projectPhotos as $v) {
					echo sprintf(
						"%simg/projects/%s<br />",
						$c::PUBLIC_FOLDER,
						$v['row3']
					);
				}
			}
		?>
	</div>
</main>
<?php
@include('website/parts/footer.php');
?>