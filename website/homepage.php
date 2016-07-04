<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="project-box">
		<?php
		if(count($projects)):
			if(count($projects)==1){ $st = ' single'; }
			else{ $st=''; }
			foreach ($projects as $value) {
				echo sprintf(
					'<div class="project-item %s">
					<a href="%sview/%s">
					<img src="%simg/projects/%s" alt="" />
					<p class="text">%s</p>
					<p class="year">%s</p>
					</a>
					</div>',
					$st,
					$c::WEBSITE,
					$value['p_id'],
					$c::PUBLIC_FOLDER,
					$value['p_photo'],
					$value['p_title'],
					date("Y", $value['p_date'])
				);
			}
		endif;
		?>		
	</div>
</main>
<?php
@include('website/parts/footer.php');
?>