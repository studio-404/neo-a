$(document).ready(function(){
	Studio404.mobileDetect();
}); 

$(document).on("click", '.copyright', function(e){
	Studio404.locationChange($(this).attr('data-gourl'), "_blank");
});
 
$(window).scroll(function(){
	Studio404.windowScroll();
});

var Studio404 = {
	name: "Studio 404",
	home: "http://neo-a.404.ge",
	ajax: "http://neo-a.404.ge/index.php",
	mobileDetect: function(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 	// Studio404.mobileSlideDown();
		}
	},
	selectMenuItems: function(){
		var ins = '<li>';
		ins += '<form action="javascript:void(0)" method="post">';
		ins += '<input type="text" name="search" value="" autocomplete="off" />';
		ins += '<input type="submit" value="" />';
		ins += '</form><div class="clearer"></div>';
		ins += '</li>'; 
		var subm = "";
		$(".navigation .mainMenu li").each(function(){
			if(!$(this).hasClass("icon")){
				subm = $(this).attr("data-subm");
				ins += '<li>'+$(this).html();
				console.log($(subm).length);
				if(subm!="" && $(subm).length){
					ins += "<ul class='submenu'>"+$(subm).html()+"</ul>";
				}
				ins += '</li>';

			}
		});
		return ins;
	},
	mobileSlideDown: function(){
		var icon = $(".icon");
		if(icon.hasClass("close")){
			// opend
			icon.removeClass("close");
			$(".mobileNav ul").html(this.selectMenuItems());
			$(".mobileNav").slideUp("slow");
		}else{
			// closed
			icon.addClass("close");
			$(".mobileNav ul").html(this.selectMenuItems());
			$(".mobileNav").slideDown("slow");
		}

	},
	locationChange: function(go, target){
		window.open(go, target);
	},
	isAjaxCalled: false,
	windowScroll: function(){
		if (($(window).scrollTop() >= ($(document).height() - $(window).height())*0.2) && !this.isAjaxCalled){
			this.isAjaxCalled= true; 
		    console.log("scrolled");
		    this.ajaxRequestOnScroll();
		}
	},
	ajaxRequestOnScroll: function(){
		console.log("ajax request done");
	}
};