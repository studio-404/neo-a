<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="leftside">
		<?php
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			$slug = new lib\functions\url\slug();
			$i = $slug->params();
			?>
			<div class="text">
			<form action="javascript:void(0)" method="POST">
			<div class="messagex" style="color:#ff0000"></div>
			<label data-input="date">date</label>
			<input type="text" id="project_date" name="date" value="<?=date("m-d-Y", $this->projectDesc[0]["row2"])?>" style="height:25px" />
			<label data-input="title">Title</label>
			<input type="text" id="project_title" name="title" value="<?=$this->projectDesc[0]["row3"]?>" style="height:25px" />
			<label data-input="content">Content</label>
			<textarea id="project_content" name="content" style="height:120px"><?=$this->projectDesc[0]["row4"]?></textarea>
			<input type="submit" value="Save Changes" id="updateProject" data-prid="<?=$i[1]?>" />
			<input type="button" value="Delete Project" onclick="Studio404.deleteProject(<?=$i[1]?>)" style="margin:0; padding:0; border:0; outline:0; width:100%; height:25px; background-color:red; color:white; text-align:center; float:left; clear:both; cursor:pointer;" />
			</form>
			</div>
			<?php
		}else{
		?>
		<div class="title"><?=$this->projectDesc[0]["row3"]?></div>
		<div class="text">
			<?=$this->projectDesc[0]["row4"]?>
		</div>
		<?php
		}
		?>
	</div>
	<div class="rightside">
	<?php
		$image = new lib\functions\image\crop(); 
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			if(is_array($this->projectPhotos) && count($this->projectPhotos)){
				echo "<div id=\"projectImageBox\">";
				foreach ($this->projectPhotos as $v) {
					$src = $image->dojob(
						$c::WEBSITE.$c::PUBLIC_FOLDER_NAME."/img/projects/".$v['row3'], 
						233, 
						166, 
						0
					);
					echo sprintf(
						"<div class=\"gallery-box i_%s\" id=\"gallery-box\" style=\"width:120px; float:left; margin:5px 5px 5px 0\" data-prid=\"%s\">
							<img src=\"%s\" width=\"%s\" alt=\"\" style=\"float:left\" />
							<a href=\"javascript:void(0)\" style=\"width:%s; line-height:25px; background-color:#000000; color:white; text-align:center; float:left; display:block; text-decoration:none\" onclick=\"Studio404.removeProjectPhoto('".$v['row1']."', '".$v['row4']."')\">Delete Item</a>
						</div>
						",
						$v['row1'], 
						$v['row1'], 
						$src,
						"100%",
						"100%"
					);
				}
				echo "</div>"; 
				echo "<div style=\"clear:both\"></div><form action=\"\" method=\"post\" id=\"projectimagesForm\" enctype=\"multipart/form-data\" style=\"margin-top:20px\">";
				echo "<input type=\"hidden\" name=\"postrequest\" value=\"projectimagesForm\">";
				echo "<input type=\"hidden\" name=\"proid\" value=\"".$i[1]."\">";
				echo "<input type=\"file\" name=\"projectimages[]\" value=\"\" style=\"margin:5px 0; width:100%\" /></form><div style=\"clear:both\">";
				echo "<a href=\"javascript:void(0)\" style=\"color:red; float:left; margin-top: 20px;\" onclick=\"Studio404.addMoreProjectPhotoes()\">Add More Photoes</a>
				<input type=\"button\" value=\"Upload\" id=\"uploadProjectPhotos\" onclick=\"$('#projectimagesForm').submit()\" />
				";
				
			}
		}else{
			if(is_array($this->projectPhotos) && count($this->projectPhotos)){
				foreach ($this->projectPhotos as $v) {
					echo sprintf(
						"%simg/projects/%s<br />",
						$c::PUBLIC_FOLDER,
						$v['row3']
					);
				}
			}
		}
		?>
	</div>	
	

	</div>
		
	 
		
		
	
</main>
<?php
@include('website/parts/footer.php');
?>