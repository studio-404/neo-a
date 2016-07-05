<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="leftside">
		<div class="title"><?=$this->page['sub_title']?></div>
		<div class="text">
		<?php
		if($this->request->method("GET","admin")=="true" && isset($_SESSION[$c::SESSION_PREFIX."username"])){
			?>
			<form action="javascript:void(0)" method="POST">
			<div class="messagex" style="color:#ff0000"></div>
			<label data-input="address">Address:</label>
			<input type="text" id="studio_address" name="address" value="<?=$this->contactinfo['address']?>" style="height:25px" />
			<label data-input="phone">Phone:</label>
			<input type="text" id="studio_phone" name="phone" value="<?=$this->contactinfo['phone']?>" style="height:25px" />
			<label data-input="email">Email:</label>
			<input type="text" id="studio_email" name="email" value="<?=$this->contactinfo['email']?>" style="height:25px" />
			<label data-input="map">Map:</label>
			<input type="text" id="studio_map" name="map" value="<?=$this->contactinfo['map']?>" style="height:25px" />

			<input type="submit" value="Save Changes" id="updateContactInfo" />
			</form>
		<?php
		}else{
		?>
			<ul>
				<li>
					<img src="<?=$c::PUBLIC_FOLDER?>img/mappinwitharrow.svg" alt="icon" /> <p><?=$this->contactinfo['address']?></p>
				</li>
				<li>
					<img src="<?=$c::PUBLIC_FOLDER?>img/phoneicon.svg" alt="icon" />
					<p> <?=$this->contactinfo['phone']?></p>
				</li>
				<li>
					<img src="<?=$c::PUBLIC_FOLDER?>img/messageicon.svg" alt="icon" />
					<p> <?=$this->contactinfo['email']?></p>
				</li>
			</ul>
			<div class="title">Get in Touch</div>
			<form action="" method="POST">
				<label data-input="name">Name</label>
				<input type="text" id="name" name="name" value="" />
				<label data-input="email">Email</label>
				<input type="text" id="email" name="email" value="" />
				<label data-input="message">Message</label>
				<textarea id="message" name="message"></textarea>
				<input type="submit" value="Send" />
			</form>
		
		<?php
		}
		?>
		</div>
	</div>
	<div class="rightside">
		<div id="map"></div>
		<script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      var map;
      function initMap() {
        var myLatLng = { <?=$this->contactinfo['map']?> };
        map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          zoom: 19
        });
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: "<?=$c::PUBLIC_FOLDER?>img/mappinwitharrow.svg"
        });
      }
      initMap();
    </script>
    
	</div>
</main>
<?php
@include('website/parts/footer.php');
?>