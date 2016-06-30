$(document).ready(function(){
	Studio404.mobileDetect();
}); 

var Studio404 = {
	name: "Studio 404",
	home: "http://neo-a.404.ge",
	ajax: "http://neo-a.404.ge/index.php",
	mobileDetect: function(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 	// ** its a mobile
		}
	}
};