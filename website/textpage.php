<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="leftside">
		<?php
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			?>
			<div class="text">
			<form action="" method="POST">
			<label data-input="title">Title</label>
			<input type="text" id="title" name="title" value="<?=$this->page["sub_title"]?>" style="height:25px" />
			<label data-input="content">Content</label>
			<textarea id="content" name="content" style="height:120px"><?=$this->page['text']?></textarea>
			<input type="submit" value="Send" id="updateTheStudio" />
			</form>
			</div>
			<?php
		}else{
		?>
			<div class="title"><?=$this->page['sub_title']?></div>
			<div class="text">
				<?=$this->page['text']?>
			</div>
		<?php
		}
		?>
	</div>
	<div class="rightside">
		<img src="<?=$c::PUBLIC_FOLDER?>img/<?=$this->page['picture']?>" width="100%" />
	</div>
</main>
<?php
@include('website/parts/footer.php');
?>