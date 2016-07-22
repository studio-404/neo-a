<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="project-box">
		<?php
		$image = new lib\functions\image\crop(); 
		if(count($projects)):
			foreach ($projects as $value) {
				$adminSlug = "";
				if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
					$adminSlug = "?admin=true";
				}
				$src = $image->dojob(
					$c::WEBSITE.$c::PUBLIC_FOLDER_NAME."/img/projects/".$value['p_photo'], 
					233, 
					166, 
					1
				);
				echo sprintf(
					'<div class="project-item">
					<a href="%sview/%s%s">
					<img src="%s" alt="" />
					<p class="text">%s</p>
					<p class="year">%s</p>
					</a>
					</div>',
					$c::WEBSITE,
					$value['p_id'],
					$adminSlug,
					$src,
					$value['p_title'],
					date("Y", $value['p_date'])
				);
			}
		endif;
		?>		
	</div>
	<div class="loaderButton" data-called="false" data-slug="<?=$this->params[1]?>" data-loaded="12" style="margin:0; padding:0; width:100%; height:1px; float:left; opacity:0;"></div>
		<?php
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			echo '<a href="javascript:void(0)" style="color:red; width:1000px; clear:both; display:block; margin:10px 1%" onclick="Studio404.showPopup(this, \'addCatalogItem\')" data-slug="'.$this->params[1].'">Add Catalog Item</a>';
		}
		?>
</main>
<?php
@include('website/parts/footer.php');
?>