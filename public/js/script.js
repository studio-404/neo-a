$(document).ready(function(){
	Studio404.mobileDetect();
	Studio404.dragAndDrop();
}); 

$(document).on("click", '.copyright', function(e){
	Studio404.locationChange($(this).attr('data-gourl'), "_blank");
});

$(document).on("click", ".content .leftside .text form label", function(){
	Studio404.fomrInputAnimate($(this));
});

$(document).on("click", "#updateTheStudio", function(){
	info = [];
	info[0] = 'updateTheStudio';
	info[1] = $("#studio_title").val();
	info[2] = $("#studio_content").val();
	var json = JSON.stringify(info);
 	Studio404.ajaxUpdate(json);
});
 
$(window).scroll(function(){
	Studio404.windowScroll();
});

var Studio404 = {
	name: "Studio 404",
	home: "http://neo-a.404.ge",
	ajax: "http://neo-a.404.ge/index.php",
	ajaxUpload: "http://neo-a.404.ge/index.php?ajax=true&uploadFile=true",
	mobileDetect: function(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 	// Studio404.mobileSlideDown();
		}
	},
	fomrInputAnimate: function(th){
		var dat = th.attr("data-input");
		th.css({"font-size":"12px", "line-height":"14px"}); 
		if(dat=="message"){
			$("#"+dat).animate({height:80},400).focus();
		}else{
			$("#"+dat).animate({height:25},200).focus();
		}
	},
	tabKeyChecker: function(e, clickIt, focusIt) {
        var TABKEY = 9;
        if(e.keyCode == TABKEY) {
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
	dragAndDrop: function(){
		var obj = $(".dragableArea");
		var hidden_input = $('#bgfile');

		obj.on('click', function(e){
			hidden_input.click();
		});

		hidden_input.on('change',function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css({"border":"none"});
			var files = e.target.files;
			if(files.length >= 2){ alert("Multiple file not allowed!"); }
			else{
				var file = files[0];
				$('#img').html('<p>Loading...</p>'); 
				Studio404.uploadFile(file);
			}
		});

		obj.on('dragover', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css({"border":"solid 1px #ef4836"});
		});

		obj.on('dragleave', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css({"border":"none"});
		});

		obj.on('drop', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).css({"border":"none"});


			var files = e.originalEvent.dataTransfer.files;
			if(files.length >= 2){ alert("Multiple file not allowed!"); }
			else{
				var file = files[0];
				$('#img').html('<p>Loading...</p>'); 
				Studio404.uploadFile(file);
			}
		});
	},
	uploadFile: function(file){
		var fileName = file.name;
		var ex = fileName.split(".");
		var extLast = ex[ex.length - 1].toLowerCase();

		xhr = new XMLHttpRequest();
		xhr.open('post', this.ajaxUpload, true);
		//set header

		var rforeign = /[^\u0000-\u007f]/;
		if (rforeign.test(file.name)) {
		  alert("File name error !");
		  return false;
		}
		
		xhr.setRequestHeader('Content-Type','multipart/form-data');
		xhr.setRequestHeader('X-File-Name',file.name);
		xhr.setRequestHeader('X-File-Size',file.size);
		xhr.setRequestHeader('X-File-Type',file.type);
		if(extLast!="jpg"){
			alert("Please drop jpg file !");
			$('#img').html('<p>No Image</p>');
			return false;
		}
		xhr.send(file);

		xhr.onreadystatechange = function(e){
			if(xhr.readyState == 4){
				if(xhr.status == 200){
					var res = xhr.responseText;
					var obj = $.parseJSON(res);
					$('#img').html(obj.image_tag);
					$('#upfile').val(obj.image_filename);
				}
			}
		}
	},
	ajaxUpdate: function(r){
		$.post(this.ajax, { ajax:"true", r:r }, function(d){
			console.log(d); 
		});
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