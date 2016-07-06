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
	info[3] = $("#studio_upfile").val();
	var json = JSON.stringify(info);
 	Studio404.ajaxUpdate(json);
});

$(document).on("click", "#updateContactInfo", function(){
	info = [];
	info[0] = 'updateContactInfo';
	info[1] = $("#studio_address").val();
	info[2] = $("#studio_phone").val();
	info[3] = $("#studio_email").val();
	info[4] = $("#studio_map").val();
	var json = JSON.stringify(info);
 	Studio404.ajaxUpdate(json);
});

$(document).on("click", "#ChangeCatalog", function(){
	info = [];
	info[0] = 'updateCatalogList';
	var x=0;
	inp = [];
	$(".recivedData .formbox input").each(function(){
		inp[x] = [$(this).attr("data-type"),$(this).val()];
		x++;
	});
	info[1] = inp;
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
					$('#studio_upfile').val(obj.image_filename);
				}
			}
		}
	},
	ajaxUpdate: function(r){
		$(".messagex").html("Please wait...");
		$.post(this.ajax, { ajax:"true", r:r }, function(d){
			var obj = $.parseJSON(d);
			$(".messagex").html(obj.message);
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
	},
	showPopup: function(e, t){
		$(e).html('Please Wait...');
		if(t=="ManageCatalog"){
			info = [];
			info[0] = 'selectCatalog';
			var json = JSON.stringify(info);
			$.post(this.ajax, { ajax:"true", r:json }, function(d){
				var obj = $.parseJSON(d);
				$(e).html('Manage Catalog');
				$("#popup_title").html("Manage Catalog");
				$("#popup_body").html('<div class="recivedData"></div><input type="button" value="Add Item" onclick="Studio404.appendCatalog()" /><input type="button" value="Save Changes" id="ChangeCatalog" />');
				$(".mask, .popup").css("display","block"); 
				var catalogList = obj.catalogList;
				var out = '';
				for (var i = 0; i <= catalogList.length - 1; i++) {
					out += '<div class="formbox" id="i'+catalogList[i].id+'">'; 
					out += '<input type="hidden" name="item" data-type="item" value="'+catalogList[i].id+'" />';
					out += '<input type="text" name="title" data-type="title" value="'+catalogList[i].title+'" />';
					out += '<input type="text" name="slug" data-type="slug" value="'+catalogList[i].slug+'" />';
					out += '<a href="javascript:void(0)" onclick="Studio404.removeCatalogItem(\''+catalogList[i].id+'\')">x</a>';
					out += '</div><div class="clearer"></div>';
				}
				$(".recivedData").html(out); 
				$(".recivedData").sortable();
			});
		}else if(t=="addCatalogItem"){
			$(e).html('Add Catalog Item');
			info = [];
			info[0] = 'selectCatalog';
			var json = JSON.stringify(info);
			$.post(this.ajax, { ajax:"true", r:json }, function(d){
				var obj = $.parseJSON(d);
				$("#popup_title").html("Add Catalog Item");
				var ins = '<input type="hidden" name="postrequest" value="addcatalogitem" />';
				ins += '<div class="formbox">';
				ins += '<input type="text" name="item_title" value="" placeholder="Title" style="width:49%" />';
				ins += '<input type="text" name="item_date" value="" placeholder="Date Format: mm-dd-YYYY" style="width:49%" />';
				ins += '<textarea name="item_description" class="textarea" style="margin:10px 0; height:120px" placeholder="Describe..."></textarea>';
				
				ins += '<select name="item_catalogList" class="catalogList">';
				ins += '<option value="">Choose Catalog</option>';
				var catalogList = obj.catalogList;
				var slug = $(e).attr("data-slug");
				for (var i = 0; i <= catalogList.length - 1; i++) {
					if(catalogList[i].slug==slug){
						ins += '<option value="'+catalogList[i].id+'" selected="selected">'+catalogList[i].title+'</option>';
					}else{
						ins += '<option value="'+catalogList[i].id+'">'+catalogList[i].title+'</option>';
					}
				}
				ins += '</select>';

				ins += '<div class="pimages" style="margin:15px 0 0 0">';
				ins += '<input type="file" name="item_file[]" value="" style="width:100%" />';
				ins += '</div>';
				ins += '</div>';
				ins += '<input type="button" value="Add More image" onclick="Studio404.appendMoreImage()" />';
				ins += '<input type="button" value="Insert Project" onclick="$(\'#popup_form\').submit()" />';
				$("#popup_body").html(ins);
				$(".mask, .popup").css("display","block");
			});
		}
	},
	appendMoreImage: function(){
		var ins = '<input type="file" name="item_file[]" value="" style="width:100%; margin-top:10px" />';
		$(".pimages").append(ins);
	},
	removeCatalogItem: function(i){
		if(confirm("whould you like to delete item ?") == true){
			$(".messagex").html('Please Wait...');
			info = [];
			info[0] = 'deleteCatalogItem';
			info[1] = i;
			var json = JSON.stringify(info);
		 	$.post(this.ajax, { ajax:"true", r:json }, function(d){
		 		var obj = $.parseJSON(d);
		 		if(obj.status=="true"){
		 			$("#i"+i).fadeOut();
		 		}
		 		$(".messagex").html(obj.message);
		 	});
		}
	},
	appendCatalog: function(){
		var out = '<div class="formbox">';
		out += '<input type="hidden" name="item" data-type="item" value="new" />';
		out += '<input type="text" data-type="title" name="title" value="" />';
		out += '<input type="text" data-type="slug" name="slug" value="" />';
		out += '</div><div class="clearer"></div>';
		$(".recivedData").append(out);
	},
	closePopup: function(){
		$(".mask, .popup").fadeOut(); 
	}
};