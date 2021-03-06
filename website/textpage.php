<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="leftside">
		<?php
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			?>
			<div class="text">
			<form action="javascript:void(0)" method="POST">
			<div class="messagex" style="color:#ff0000"></div>
			<label data-input="title">Title</label>
			<input type="text" id="studio_title" name="title" value="<?=$this->page["sub_title"]?>" style="height:25px" />
			<label data-input="content">Content</label>
			<textarea id="studio_content" name="content" style="height:120px"><?=$this->page['text']?></textarea>
			<input type="file" name="bgfile" id="bgfile" value="" />
			<input type="hidden" name="upfile" id="studio_upfile" value="" />
			<div class="dragableArea">Drag And Drop Or Click</div>
			<input type="submit" value="Save Changes" id="updateTheStudio" />
			</form>
			</div>
			<?php
		}else{
		?>
			<div class="title"><?=$this->page['sub_title']?></div>
			<div class="text">
				<?=nl2br($this->page['text'])?>
			</div>
		<?php
		}
		?>
	</div>
	<div class="rightside" id="img">
		<?php
		$image = new lib\functions\image\crop(); 
		$src = $image->dojob(
			$c::WEBSITE.$c::PUBLIC_FOLDER_NAME."/img/team/".$this->page['picture'], 
			858, 
			517, 
			0
		);
		?>
		<img src="<?=$src?>" width="100%" alt="team" />
	</div>
</main>
<?php
@include('website/parts/footer.php');
?>