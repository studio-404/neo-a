$(document).ready(function(){
	Studio404.mobileDetect();
	Studio404.dragAndDrop();
	Studio404Slider.bootstap();
	Studio404Slider.dragSlideImage();
	$("#projectImageBox").sortable({
		tolerance: "pointer",
		start: function (event, ui) {
           $(ui.item).width(205);
        },
		stop: function(event,ui){ 
			var prid = "";
			info = [];
			info[0] = 'sortImages';
			var i = 1;
			$(".gallery-box").each(function(){
				info[i] = $(this).attr("data-prid");
				i++;
			});
			var json = JSON.stringify(info);
 			Studio404.ajaxUpdate(json);
		}
	});
}); 

$(document).on("click", '.copyright', function(e){
	Studio404.locationChange($(this).attr('data-gourl'), "_blank");
});

$(document).on("click", ".content .leftside .text form label", function(){
	Studio404.fomrInputAnimate($(this));
});

$(document).on("click","#updateProject", function(){
	Studio404.updateProject(event);
});

// $(document).on("blur", ".content .leftside .text form input[type='text']", function(){
	
// });

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

var Studio404Slider = {
	container: ".slider-container", 
	thumb: ".slider-thumbs",
	thumbPrev: ".topNav a",  
	thumbNext: ".bottomNav a",  
	main: ".slider-image", 
	speed: 5000,
	currentPosition: 1,
	bootstap: function(){
		this.mainWidthChange();
		$(this.thumb+" ul .item:eq(0)").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #000000"});
		$(this.thumb+" ul .item:eq(0) img").css({"height":"73px"});
		$(this.thumbNext).click(function(){
			Studio404Slider.next(Studio404Slider.currentPosition);
		});
		$(this.thumbPrev).click(function(){
			Studio404Slider.prev(Studio404Slider.currentPosition);
		});
		this.myInterval = setInterval(function(){
			$(Studio404Slider.thumbNext).click();
		}, Studio404Slider.speed);
		document.body.onkeydown = function(e){
		    Studio404Slider.arrowDetect(e);
		};
		if(this.mainItemCount()<5){
			$(".content .rightside .slider-container .slider-thumbs ul .topNav").hide();
			$(".content .rightside .slider-container .slider-thumbs ul .bottomNav").hide();
		}
	},
	resetInterval: function(){
		clearInterval(this.myInterval);
		this.myInterval = setInterval(function(){
			$(Studio404Slider.thumbNext).click();
		}, Studio404Slider.speed);
	},
	arrowDetect: function(e) {
	    var event = window.event ? window.event : e;
	    if(event.keyCode==39){
	    	this.next(this.currentPosition);
	    }else if(event.keyCode==37){
	    	this.prev(this.currentPosition);
	    }
	},
	next: function(p){
		if(p == 1){
			var t = "-"+this.thumbItemHeight()+"px";
			var t2 = "-"+this.mainWidth()+"px";
			$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
			this.currentPosition = 2;
		}else if(p == this.mainItemCount()){
			var t = "0px";
			var t2 = "0px";
			$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
			this.currentPosition = 1;
		}else{
			var a = this.thumbItemHeight() * this.currentPosition;
			var a2 = this.mainWidth() * this.currentPosition;
			var t = "-"+a+"px";
			var t2 = "-"+a2+"px";
			$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
			this.currentPosition = this.currentPosition + 1;
		}
		$(this.thumb+" ul .item").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #ffffff"});
		$(this.thumb+" ul .item:eq("+(this.currentPosition-1)+")").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #000000"});
		$(this.thumb+" ul .item:eq("+(this.currentPosition-1)+") img").css({"height":"73px"});
		this.resetInterval();
		this.changeThumbPosition();
	},
	prev: function(p){
		if(p <= 1){
			var a2 = this.mainWidth() * (this.mainItemCount()-1);			
			var t2 = "-"+a2+"px";
			
			$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
			this.currentPosition = this.mainItemCount();
		}else if(p == 2){
			var t2 = "0px";
			$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
			this.currentPosition = 1;
		}else{
			var a2 = this.mainWidth() * (this.currentPosition-2);			
			var t2 = "-"+a2+"px";			
			$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
			this.currentPosition = this.currentPosition - 1;
		}

		$(this.thumb+" ul .item").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #ffffff"});
		$(this.thumb+" ul .item:eq("+(this.currentPosition-1)+")").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #000000"});
		$(this.thumb+" ul .item:eq("+(this.currentPosition-1)+") img").css({"height":"73px"});
		this.resetInterval();
		this.changeThumbPosition();
	},
	goToPosition: function(p){
		var a2 = this.mainWidth() * (p - 1);
		var t2 = "-"+a2+"px";

		// $(this.thumb+" ul").animate({ 'marginTop': t }, 700);
		$(this.main+" ul").animate({ 'marginLeft': t2 }, 700);
		this.currentPosition = p;
		$(this.thumb+" ul .item").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #ffffff"});
		$(this.thumb+" ul .item:eq("+(p-1)+")").css({"width":"calc(100% - 4px)", "height":"73px", "border":"solid 2px #000000"});
		$(this.thumb+" ul .item:eq("+(p-1)+") img").css({"height":"73px"});
		this.resetInterval();
		this.changeThumbPosition();
	},
	changeThumbPosition: function(){
		if(this.currentPosition >=6 && this.mainItemCount() > 6){
			var a = this.thumbItemHeight() * (this.currentPosition-6);
			var t = "-"+a+"px";
			$(this.thumb+" ul").animate({ 'marginTop': t }, 700);
		}else if(this.currentPosition == 1){
			var t = "0px";
			$(this.thumb+" ul").animate({ 'marginTop': t }, 700);
		}
	},
	mainWidth: function(){
		var w = $(this.main).width();
		return w;
	},
	thumbHeight: function(){
		var h = $(this.thumb).height();
		return h;
	},
	thumbItemHeight: function(){
		if(!Studio404.mobileDetect()){
			return 88;
		}
		return 0;
	},
	mainItemCount: function(){
		var c = $(this.main+" ul .item").length;
		return c;
	},
	mainWidthChange: function(){
		var nl = parseInt(this.mainWidth()) * parseInt(this.mainItemCount());
		if(!Studio404.mobileDetect()){
			$(this.main+" ul").css("width", nl+"px");
		}else{
			$(this.main+" ul").css("width", nl+"px");
			$(this.main+" ul li").css("width", this.mainWidth()+"px");
		}
		
	},
	dragSlideImage: function(){
		// var prevX = -1;
		// $('.content .rightside .slider-container .slider-image ul .item').draggable({
		// 	axis: "x",
		//     drag: function(e) {
		//         //console.log(e.pageX);

		//         if(prevX == -1) {
		//             prevX = e.pageX;    
		//             return false;
		//         }
		//         // dragged left
		//         if(prevX > e.pageX) {
		//             console.log('dragged left');
		//             Studio404Slider.goToPosition(Studio404Slider.currentPosition-1);
		//             return false;

		//         }
		//         else if(prevX < e.pageX) { // dragged right
		//             console.log('dragged right');
		//             Studio404Slider.goToPosition(Studio404Slider.currentPosition+1);
		//             return false;
		//         }
		//         prevX = e.pageX;
		//     }
		// });
	}
};

var Studio404 = {
	name: "Studio 404",
	home: "http://neo-a.404.ge",
	publicFolder: "http://neo-a.404.ge/public/",
	ajax: "http://neo-a.404.ge/index.php",
	ajaxUpload: "http://neo-a.404.ge/index.php?ajax=true&uploadFile=true",
	mobileDetect: function(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 	return true;
		}
		return false;
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
		ins += '<form action="'+Studio404.home+'" method="get">';
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
	windowScroll: function(){
		// if (($(window).scrollTop() >= ($(document).height() - $(window).height())*0.2)){
		// 	this.ajaxRequestOnScroll();
		// }
	},
	ajaxRequestOnScroll: function(){
		var called = $(".loaderButton").attr("data-called");
		var slug = $(".loaderButton").attr("data-slug");
		var loaded = $(".loaderButton").attr("data-loaded");
		var par = Studio404.urlParamiters();
		if(called=="false"){
			$(".loaderButton").attr("data-called","true"); 
			info = [];
			info[0] = 'scrollCatalog';
			info[1] = slug;
			info[2] = loaded;
			info[3] = par["search"];
			var admin_slug = (par["admin"]=="true") ? "?admin=true" : "";		
			var json = JSON.stringify(info);
			$.post(this.ajax, { ajax:"true", r:json }, function(d){
				var obj = $.parseJSON(d);				
				var out = '';
				var catalogList = obj.selected;
				var date = "";
				var year = "";
				if(catalogList!="false"){
					for (var i = 0; i <= catalogList.length - 1; i++) {
						out += '<div class="project-item">';
						out += '<a href="'+Studio404.home+'/view/'+catalogList[i].id+admin_slug+'">';
						out += '<img src="'+Studio404.home+'/?crop=true&f='+Studio404.publicFolder+'img/projects/'+catalogList[i].photo+'&w=233&h=166" width="100%" alt="">';
						out += '<p class="text">'+catalogList[i].title+'</p>';
						date = new Date(catalogList[i].date*1000);
						year = date.getFullYear();
						out += '<p class="year">'+year+'</p>';
						out += '</a>';
						out += '</div>';
					}
				}
				var limit = obj.limit;
				$(".loaderButton").attr("data-loaded", limit);
				$(".project-box").append(out);
				out = '';
				$(".loaderButton").attr("data-called","false"); 
			});
			console.log(slug + " " + loaded); 

		}
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
				ins += '<input type="text" name="item_date" value="" placeholder="Date Format: dd-mm-YYYY" style="width:49%" />';
				ins += '<textarea name="item_description" class="textarea" style="margin:10px 0; height:120px" placeholder="Describe..."></textarea>';
				
				ins += '<select name="item_catalogList" class="catalogList">';
				// ins += '<option value="">Choose Catalog</option>';
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
		this.scrollTopAction();
	},
	scrollTopAction: function(){
		var body = $("html, body");
		body.stop().animate({
			scrollTop:0
		}, 
		'500', 
		'swing', 
		function() {
			console.log("Scroll Top Finished !"); 
		});
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
		out += '<input type="text" data-type="title" name="title" value="" placeholder="Title" />';
		out += '<input type="text" data-type="slug" name="slug" value="" placeholder="Slug" />';
		out += '</div><div class="clearer"></div>';
		$(".recivedData").append(out);
	},
	closePopup: function(){
		$(".mask, .popup").fadeOut(); 
	},
	updateProject: function(){
		var project_date = $("#project_date").val();
		var project_id = $("#updateProject").attr("data-prid");
		var project_title = $("#project_title").val();
		var project_content = $("#project_content").val();
		$(".messagex").html('Please Wait...');
		info = [];
		info[0] = 'updateProject';
		info[1] = project_date;
		info[2] = project_id;
		info[3] = project_title;
		info[4] = project_content;
		var json = JSON.stringify(info);
	 	$.post(this.ajax, { ajax:"true", r:json }, function(d){
	 		var obj = $.parseJSON(d);
	 		$(".messagex").html(obj.message);
	 	});
	}, 
	addMoreProjectPhotoes: function(){
		var fi = "<input type=\"file\" name=\"projectimages[]\" value=\"\" style=\"margin:5px 0; width:100%\" />";
		$("#projectimagesForm").append(fi);
	},
	removeProjectPhoto: function(i,p){
		if(confirm("Would you like to remove photo ?")){
			$(".messagex").html('Please Wait...');
			info = [];
			info[0] = 'removeProjectPhoto';
			info[1] = i;
			info[2] = p;
			var json = JSON.stringify(info);

		 	$.post(this.ajax, { ajax:"true", r:json }, function(d){
		 		var obj = $.parseJSON(d);
		 		if(obj.status=="true"){
		 			$(".i_"+i).fadeOut();
		 		}
		 		$(".messagex").html(obj.message);
		 	});
		}
	},
	deleteProject: function(i){
		if(confirm("Would you like to remove project ?")){
			$(".messagex").html('Please Wait...');
			info = [];
			info[0] = 'removeProject';
			info[1] = i;
			var json = JSON.stringify(info);

		 	$.post(this.ajax, { ajax:"true", r:json }, function(d){
		 		var obj = $.parseJSON(d);
		 		if(obj.status=="true"){
		 			location.href = Studio404.home+"?admin=true";
		 		}
		 		$(".messagex").html(obj.message);
		 	});
		}
	}, 
	urlParamiters: function(){
		var query_string = new Array();
		var query = window.location.search.substring(1);
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if (typeof query_string[pair[0]] === "undefined") {
			  query_string[pair[0]] = pair[1];
			} else if (typeof query_string[pair[0]] === "string") {
			  var arr = [ query_string[pair[0]], pair[1] ];
			  query_string[pair[0]] = arr;
			} else {
				if(query_string.length){
			  		query_string[pair[0]].push(pair[1]);
				}else{
					query_string[pair[0]] = '';
				}
			}
		} 
		return query_string;		
	},
	searchBoxAnimate: function(ev){
		if(ev=="click"){
			$(".container .search .leftline").animate({
				width: '50%'
			}, { duration: 400, queue: false });
			$(".container .search .rightline").animate({
				width: '50%'
			}, { duration: 400, queue: false });
			// $('.container .search form input[type="submit"]').css({"width":"20px","height":"20px"}); 
		}else{
			$(".container .search .leftline").animate({
				width: '0'
			}, { duration: 400, queue: false });
			$(".container .search .rightline").animate({
				width: '0'
			}, { duration: 400, queue: false });
			// $('.container .search form input[type="submit"]').css({"width":"30px","height":"30px"});
		}
	},
	contactInputBlur: function(lab,inp){
		if($(inp).val()==""){
			$(lab).css({"font-size":"11px", "line-height":"18px"});
			$(inp).css({"height":"1px"});
		}
	},
	sendEmail: function(){
		var name = $("#name").val();
		var email = $("#email").val();
		var message = $("#message").val();
		if(name=="" || email=="" || message==""){
			$(".messagex").text("All Fields are required !").fadeIn("slow");	
		}else{
			$(".messagex").text("Please Wait...").fadeIn("slow");
			info = [];
			info[0] = 'sendEmail';
			info[1] = name;
			info[2] = email;
			info[3] = message;
			var json = JSON.stringify(info);

		 	$.post(this.ajax, { ajax:"true", r:json }, function(d){
		 		var obj = $.parseJSON(d);
		 		$(".messagex").html(obj.message);
		 		if(obj.status=="true"){
		 			$("#name").val('');
					$("#email").val('');
					$("#message").val('');
		 		}
		 	});
		}
	},
	goToProjectPage: function(){
		location.href = this.home + "/projects";
	}
};