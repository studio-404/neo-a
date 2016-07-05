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
	<div class="rightside" style="display:none;">
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
	
	<div class="rightside">
	
<link rel="stylesheet" href="http://neo-a.404.ge/public/css/flexslider.css" type="text/css"/>
<script defer src="http://neo-a.404.ge/public/js/jquery.flexslider.js"></script>



	<div class="left_carousel">
	
		<div class="slider slider-for">
			<div><h3>1</h3></div>
			<div><h3>2</h3></div>
			<div><h3>3</h3></div>
			<div><h3>4</h3></div>
			<div><h3>5</h3></div>
		</div>
		
	</div>
	
	<div class="right_carousel">

		<div class="slider slider-nav">
		<div><h3>1</h3></div>
		<div><h3>2</h3></div>
		<div><h3>3</h3></div>
		<div><h3>4</h3></div>
		<div><h3>5</h3></div>
		</div>
		
	</div>



<script>
   $('.slider-for').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
	  slidesToShow: 3,
	  slidesToScroll: 1,
	  asNavFor: '.slider-for',
	  dots: true,
	  centerMode: true,
	  focusOnSelect: true
	});
</script>


	</div>
		
	 
		
		
	
</main>
<?php
@include('website/parts/footer.php');
?>