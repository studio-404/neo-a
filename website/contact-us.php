<?php
@include('website/parts/header.php');
?>
<main class="content">
	<div class="leftside">
		<div class="title"><?=$this->page['sub_title']?></div>
		<div class="text">
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