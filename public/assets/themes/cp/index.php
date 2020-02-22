<?php
		date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Informasi Kepegawaian | PDAM Tirta Kerta Raharja</title>
<link rel="shortcut icon" href="<?=base_url();?>public/assets/images/fav_logo.gif" type="image/x-icon" />
<link rel='stylesheet'  type="text/css" href="<?=base_url();?>public/assets/themes/cp/css/load.style.css" />
<link rel='stylesheet' type='text/css' media='all' href='<?=base_url();?>public/assets/css/ui-themes/lightness/jquery-ui-1.8.16.custom.css' />
<link rel="stylesheet"  type="text/css" href="<?=base_url();?>public/assets/css/ui-themes/ui.multiselect.css" />
<style>
ul#menu li ul li a {cursor:pointer;}
</style>
<style>
.ui-datepicker{z-index:999}
</style>
<script type="text/javascript" src="<?=base_url();?>public/assets/js/jquery/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/assets/js/jquery-ui-1.10.1.custom/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/assets/js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="<?=base_url();?>public/assets/js/menu-collapsed.js"></script>
<!--tambahan timer idle>>>>-->
<script type="text/javascript" src="<?=base_url().'public/assets/js/jquery/jquery.idletimeout.js';?>"></script>
<script type="text/javascript" src="<?=base_url().'public/assets/js/jquery/jquery.idletimer.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/assets/js/jquery/jqColorPicker.min.js" ></script>
<!--tambahan timer idle<<<<-->
<script src="<?=base_url();?>public/assets/js/prettyGalery/jquery.prettyGallery.js" type="text/javascript" language="JavaScript"></script>


<script src="<?=base_url();?>public/assets/js/tiny_mce/tiny_mce.js" type="text/javascript" language="JavaScript"></script>
<script type="text/javascript">
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",		
		
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
		// Theme options
		theme_advanced_buttons1 : "undo,redo,cut,copy,paste,pastetext,pasteword,|,image,|,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,code,|,forecolor,backcolor",
		theme_advanced_buttons2 : "",

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",
	
	});	
</script>
<script language="JavaScript" type="text/javascript" src="<?=base_url();?>public/assets/js/ajaxupload.3.5.js"></script>
<script type="text/javascript">



////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
	function loadDialogBuka(){
		$("<div id='dialog-loadX'  style=\"text-align:center\"></div>").appendTo("body");
		$('#dialog-loadX').html("<br><br><img src='<?=base_url();?>public/assets/images/loading1.gif'>");
		$("#dialog-loadX").dialog({	autoOpen: false, height: 100, width: 250, modal: true, });
		$(".ui-dialog-titlebar").hide();
		$(".ui-resizable-se").remove();
		$('#dialog-loadX').dialog('open');	
	}
	function loadDialogTutup(){ 
		$( "#dialog-loadX" ).remove();
		$( "#dialog-loadX" ).dialog( "close" );
	}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function loadFragment(elmContainer,url,postData){
	if(url == '<?=site_url();?>cp'){
		jQuery(elmContainer).load('<?=site_url('cmshome');?>');
	}else{
		jQuery(elmContainer).html('');
		jQuery(elmContainer).load(url,postData,function(){
		

			var hsidebar = $(window).height() - 150;
			$('.side-menu').height(hsidebar);
		
			if($(window).width() >= 1280){
				var hcontent = $(window).height() - 105;
				$('.content').height(hcontent);	
			
			}else if($(window).width() >= 1024){
				var hcontent = $(window).height() - 105;
				$('.content').height(hcontent);	
			
			}else if($(window).width() >= 800){
				var hcontent = $(window).height() - 105;
				$('.content').height(hcontent);								
			}	
				
			tinyMCE.execCommand('mceRemoveControl',false,'isi_berita');
			
		});
	}
}

function getActiveNav(id){
	$("#top-menu ul li div").removeClass("active");
	$("#top-menu ul li div").addClass("pasive");
	$("#m"+id).addClass("active");
}

function getActiveSidebar(id){
	$("#menu li ul a").removeClass("active");
	$("#m"+id).addClass("active");
}		

function loadsidebar(idmenu){
	jQuery('#menu').html('');
	jQuery('#menu').load('<?=site_url();?>cp/sidebar/'+idmenu, function(){
		initMenu();
		$("#menu li ul a:first").addClass("active");
	});		
}		

function loadDialog(url,postData,settings){
	jQuery("#dialogArea").length || jQuery('<div id="dialogArea" />').appendTo('body').css('display','none');
	var dialog = jQuery("#dialogArea");
	dialog.dialog('destroy').html('');
	
	dialog.load(url,postData);

	if(settings){
		settings.modal = true;
		dialog.dialog(settings);
	}else{
		dialog.dialog({
			modal:true
			,title: 'title'
			,width: 500
			,height: 300
		});
	}
	dialog.dialog('open');
	return false;
}
function loadDialogLink(elem,postDat,settingsa){
	jQuery("#dialogArea").length || jQuery('<div id="dialogArea" />').appendTo('body').css('display','none');
	var dialog = jQuery("#dialogArea");
	settings.modal = true;
	dialog.dialog('destroy').html('');

	var goTo = elem.href;
		
	if(settings){
		settings.modal = true;
		dialog.dialog(settings);
	}else{
		dialog
			.load(goTo,postData)
			.dialog({
				title: 'title',
				width: 500,
				height: 300
		});
	}
	dialog.dialog('open');
	return false;
}
jQuery(document).ready(function(){
	loadsidebar(100);
	loadFragment('#main_panel_container', '<?=site_url('cmshome');?>');
	
	$("#top-menu > ul li div:first").addClass("active");

	var menu = 13;
	if($(window).width() >= 1280){
		menu = 13;
		$('.prettyGallery').width('100%');
	}else if($(window).width() >= 1024){
		menu = 10;
		$('.prettyGallery').width('97%');
	}else if($(window).width() >= 800){
		menu = 8;
		$('.prettyGallery').width('99%');
	}else if($(window).width() < 800){
		menu = 5;
		$('.prettyGallery').width('100%');
	}		
	
	// slider navigation
	$('.prettyGallery:last').prettyGallery({
		'navigation':'bottom',
		'itemsPerPage':menu
	});		
	
	if($(window).width() >= 1280){
		$('.prettyGallery').width('99%');
	}else if($(window).width() >= 1024){
		$('.prettyGallery').width('95%');
	}else if($(window).width() >= 800){
		$('.prettyGallery').width('99%');
	}else if($(window).width() < 800){
		$('.prettyGallery').width('100%');
	}				
	
	$('.pg_paging').width('100%');
	$('.pg_paging').css("color","#5a5a5a");	
	
	if ($('.pg_paging').length) {
		var hcontent = $(window).height()-170;
		$('.content').height(hcontent);				
	}	
});

	
window.setTimeout("waktu()",1000);  
function waktu() {   
	var waktu = new Date();
	var jam = waktu.getHours();
	var menit = waktu.getMinutes();
	var detik = waktu.getSeconds();
	var teksjam = new String();
	if ( menit <= 9 )
		menit = "0" + menit;
	if ( detik <= 9 )
		detik = "0" + detik;
	teksjam = jam + ":" + menit + ":" + detik;
	setTimeout("waktu()",1000);  
	document.getElementById("output").innerHTML = teksjam;
}
</script>

</head>
<body onLoad="waktu()"  >
<!-- dialog window markup -->
<div id="dialog" title="Sesion akan segera berakhir!">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
		Anda akan dilogout dalam <span id="dialog-countdown" style="font-weight:bold"></span> detik.
	</p>

	<p>Apakah ingin dilanjutkan?</p>
</div>
<!-- end dialog window markup -->

<div class="body">
  <div class="page">
    <div class="header">
      <div class="header-title"> Sistem Informasi Kepegawaian | PDAM Tirta Kerta Raharja </div>
      <div class="header-status"> <a href="#">Login sebagai :
        <?=$ssn['nama_user'];?>
        | Group Akses :
        <?=ucfirst($ssn['group_name']);?>
        </a> |
        <?=date('d-m-Y');?>
        / <strong id="output"></strong> </div>
       </div>
    </div>
    <!--e:header-->
    <?php echo $menu_list;	?>
    <!--e:navigation-->
<div class="main-content">
<div class="sidebar">
  <h3>Pengaturan</h3>
  <div class="side-menu">
    <ul id="menu">
    </ul>
  </div>
</div>
      <!--e:sidebar-->
      <div class="content-box">
          <div id="main_panel_container" class="content"> </div>
      </div>
      <!--e:content-box-->
    </div>
    <!--e:main-content-->
    <!--content-->
  </div>
  <!--e:page-->
</div>
<!--e:body-->
    <!--e:footer-->
</body>
</html>

<script type="text/javascript">
// setup the dialog
$("#dialog").dialog({
	dialogClass: 'my-extra-class',
	autoOpen: false,
	modal: true,
	width: 400,
	height: 200,
	closeOnEscape: false,
	draggable: false,
	resizable: false,
	buttons: {
		'Ya': function(){
			$(this).dialog('close');
		},
		'Tidak': function(){
			// fire whatever the configured onTimeout callback is.
			// using .call(this) keeps the default behavior of "this" being the warning
			// element (the dialog in this case) inside the callback.
			$.idleTimeout.options.onTimeout.call(this);
		}
	}
});

$('.my-extra-class').find('.ui-dialog-titlebar-close').css('display','none');

// cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
var $countdown = $("#dialog-countdown");

// start the idle timer plugin
$.idleTimeout('#dialog', 'div.ui-dialog-buttonpane button:first', {
	idleAfter: 300,
	pollingInterval: 250,
	keepAliveURL: '<?=site_url('login/keepalive');?>',
	serverResponseEquals: 'OK',
	onTimeout: function(){
		window.location = "<?=site_url('login/out');?>";
	},
	onIdle: function(){
		$(this).dialog("open");
	},
	onCountdown: function(counter){
		$countdown.html(counter); // update the counter
	}
});

</script>
