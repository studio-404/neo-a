<?php
if($this->request->method("GET","admin")){
	$admin = new \lib\template\admin();
	echo $admin->module();
}
?>
<div class="mask" onclick="Studio404.closePopup()"></div>
<div class="popup">
	<form action="" method="post">
		<h4>Manage Catalog</h4>
		<div class="recivedData">
			<div class="formbox">
				<input type="text" name="title" value="title" />
				<input type="text" name="slug" value="slug" />
				<a href="">x</a>
			</div><div class="clearer"></div>
			
			<div class="formbox">
				<input type="text" name="title" value="title" />
				<input type="text" name="slug" value="slug" />
				<a href="">x</a>
			</div><div class="clearer"></div>
			
			<div class="formbox">
				<input type="text" name="title" value="title" />
				<input type="text" name="slug" value="slug" />
				<a href="">x</a>
			</div><div class="clearer"></div>
		</div>

		<input type="button" value="Add Item" onclick="Studio404.appendCatalog()" />
		<input type="button" value="Save Changes" id="ChangeCatalog" />
	</form>
</div>
<header class="container">
	<div class="logo">
		<?php
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			$logoLink = $c::WEBSITE."?admin=true";
		}else{
			$logoLink = $c::WEBSITE;
		}
		?>
		<a href="<?=$logoLink?>">
			<img src="<?=$c::PUBLIC_FOLDER?>/img/logo.svg" alt="logo" />
		</a>
	</div>
	<div class="search">
		<form action="javascript:void(0)" method="post">
			<input type="text" name="search" value="" autocomplete="off" />
			<input type="submit" value="" />
		</form>
	</div>
	<nav class="navigation">
		<ul class="mainMenu">
			<?php
			foreach ($this->nav as $n) {
				if(empty($this->params[0]) && $n['slug']=="projects"){
					$active = "active";
				}else if($this->params[0]==$n['slug']){
					$active = "active";
				}else{
					$active = "";
				}
				if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
					$s = $n['slug']."?admin=true";
					echo sprintf(
						'<li data-subm=".sub-%s">
						<a href="/%s" class="%s">%s</a>
						</li>',
						$n['id'],
						$s,
						$active,
						$n['title']
					);
				}else{
					echo sprintf(
						'<li data-subm=".sub-%s">
						<a href="/%s" class="%s">%s</a>
						</li>',
						$n['id'],
						$n['slug'],
						$active,
						$n['title']
					);
				}
			}
			?>
			<li class="icon">
				<a href="javascript:void(0)" onclick="Studio404.mobileSlideDown()"></a>
			</li>
		</ul>
		<?php if(count($this->cat)): 
			$x=1;
			foreach ($this->cat as $n) {
				if($x==1){
					echo '<ul class="sub sub-'.$n['sub'].'">';
				}
				if(empty($this->params[1]) && $n['slug']=="all"){
					$active = "active";
				}else if($this->params[1]==$n['slug']){
					$active = "active";
				}else{
					$active = "";
				}

				if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
					$s = $n['slug']."?admin=true";
					echo sprintf(
						'<li>
						<a href="/projects/%s" class="%s">%s</a>
						</li>',
						$s,
						$active,
						$n['title']
					);
				}else{
					echo sprintf(
						'<li>
						<a href="/projects/%s" class="%s">%s</a>
						</li>',
						$n['slug'],
						$active,
						$n['title']
					);
				}
				
				$x++;
			}
			if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
				echo sprintf(
						'<li>
						<a href="javascript:void(0)" style="color:red" onclick="Studio404.showPopup(this, \'ManageCatalog\')">Manage Catalog</a>
						</li>'
				);
			}
			endif; 			
			echo '</ul>';
		?>
	</nav>
	<div class="mobileNav" style="display:none">
		<ul></ul>
	</div>
</header>