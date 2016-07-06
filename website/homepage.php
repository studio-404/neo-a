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
				$adminSlug = "";
				if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
					$adminSlug = "?admin=true";
				}
				echo sprintf(
					'<div class="project-item %s">
					<a href="%sview/%s%s">
					<img src="%simg/projects/%s" alt="" />
					<p class="text">%s</p>
					<p class="year">%s</p>
					</a>
					</div>',
					$st,
					$c::WEBSITE,
					$value['p_id'],
					$adminSlug,
					$c::PUBLIC_FOLDER,
					$value['p_photo'],
					$value['p_title'],
					date("Y", $value['p_date'])
				);
			}
		endif;

		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			echo '<a href="javascript:void(0)" style="color:red; width:1000px; clear:both; display:block; margin:10px 1%" onclick="Studio404.showPopup(this, \'addCatalogItem\')" data-slug="'.$this->params[1].'">Add Catalog Item</a>';
		}
		?>		
	</div>
</main>
<?php
@include('website/parts/footer.php');
?>