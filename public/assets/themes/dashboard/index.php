<!DOCTYPE html>
<html style="background-color:#c8ecf8;" lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title><?=$nama_app;?> | <?=$slogan_app;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('public/assets/css/bootstrap.min.css');?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=base_url('public/assets/css/plugins/metisMenu/metisMenu.min.css');?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=base_url('public/assets/css/font-awesome/4.2.0/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("public/assets/css/tile.css");?>" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?php echo base_url("public/assets/js/jquery/jquery-1.11.0.min.js");?>"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
	$( document ).ready(function() {
		$(".tile").height($("#tile0").parent().width()-40);
		$(".carousel").height($("#tile0").parent().width()-40);
		$(".item").height($("#tile0").parent().width()-40);
		$(window).resize(function() {
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function() {
			$(this).trigger('resizeEnd');
		}, 10);
		});
		
		$(window).bind('resizeEnd', function() {
			$(".tile").height($("#tile0").parent().width());
			$(".carousel").height($("#tile0").parent().width());
			$(".item").height($("#tile0").parent().width());
		});

	});
</script>

<style type="text/css">
<!--
body {
	/*background-image: url(logopdamtkr.jpg);*/
}
-->
</style></head>


<body style="background-color:#00a8df;">
<div  style="background-color:#c8ecf8;" class="headertt">

	<div class="container" style="width:100%;">
		<div class=row>
				<div class="col-lg-8">
					<div style="float:left;padding:10px 10px 10px 0px;"><img src="<?=base_url('public/assets/images/logo_in.png');?>"  style='width:80px; vertical-align:middle;'></div>
					<div style="float:left;display:table;padding-top:20px; width:64%;">
						<div><h3 style="margin:0px;padding:0px;">SISTEM INFORMASI PEGAWAI</h3></div>
						<div>Perusahaan Daerah Air Minum Tirta Kerta Raharja - Kabupaten Tangerang</div>
					</div>
				</div>  <!--col-lg-8--->
				<div class="col-lg-4" style="margin-bottom:0px;padding:20px 15px 0px 0px;vertical-align:bottom; display:none;">
					<div class="input-group" style="width:240px; float:right; padding: 10px 15px 10px 0px;">
						<input id="caripaging" onChange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="">
						<span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
					</div>
				</div>  <!--col-lg-4--->
		</div> <!--row--->
	</div> <!--container--->

    <div class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0px;border-bottom:4px solid rgb(12, 93, 197); background-color:#00a8df;">
      <div class="container" style="width:100%;">
        <div class="navbar-header"  style="clear:both;">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div style="padding:15px 0px 0px 15px; color:white;"> <?php
		  date_default_timezone_set('Asia/Jakarta');
		$hh = array(); $hh['Sun']="Minggu"; $hh['Mon']="Senin"; $hh['Tue']="Selasa"; $hh['Wed']="Rabu"; $hh['Thu']="Kamis"; $hh['Fri']="Jum'at"; $hh['Sat']="Sabtu";
		  ?> 
		  <?=$hh[date('D')];?>, <?=date('d-m-Y');?></div>
   

	   </div>
       
      </div>
    </div>
</div>



</div>
<!--//header-->


    <div class="container" style = "width:100%" >
        <!-- <div class="row" style="background-image: url(public/assets/images/BACKGROUND.jpg);" > -->
        <div class="row" style="background-color:#CCC; padding-left:35px;padding-right:35px;" > 
            <?php echo modules::run('appbkpp/dashboard/getPanel');?>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
	<script type="text/javascript" src="<?=base_url();?>public/assets/js/jquery/jquery-1.11.0.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
	<script type="text/javascript" src="<?=base_url();?>public/assets/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
	<script type="text/javascript" src="<?=base_url();?>public/assets/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="<?=base_url();?>public/assets/js/sb-admin-2.js"></script>


	<script type="text/javascript" src="<?=site_url();?>public/assets/js/jquery/jquery.form.js"></script>

<noscript>
<meta http-equiv="refresh" content="0; url=<?=site_url('enable_javascript');?>" />
</noscript>


<div>
      <footer>
		 <div style="padding:15px 0px 0px 15px; color:white;">
		   <div align="center">&copy; PDAM TKR Kabupaten Tangerang <?=date('Y');?></div>
		 </div>
		 <div style="padding:15px 0px 0px 15px; color:white;"></div>
      </footer>
    </div>
</body>
</html>
<script type='text/javascript'>   
userpage =  {
	form:{
		// tambahan 26-04-2012
		ajaxError : function(request,type,errorThrown){
			var message = "There was an error with the AJAX request.\n";
			switch(type){
				case 'timeout':
						message += "The request timed out.";
						break;
				case 'notmodified':
						message += "The request was not modified but was not retrieved from the cache.";
						break;
				case 'parseerror':
						message += "XML/Json format is bad.";
						break;
				default:
						message += "HTTP Error (" + request.status + " " + request.statusText + ").";
			}
						message += "\n";
						alert(message);		
		},
		init: function(settings){
			var options = {
				async: false,
				dataType: 'json',
				type:      'POST',
				success : function(content) {
					var msg;
					if(content.result == 'succes'){
						location.href = '<?=site_url();?>' + content.section;
						msg = '<div id="notification">';
					    msg += '<div class="error">'+content.message+'</div></div>';
					}else{
					    msg = '<div id="notification">';
					    msg += '<div class="error"><strong>Pesan Kesalahan</strong><ol><li>Pastikan username, password dan captcha anda benar-benar valid</li><li>'+content.message+'</li></ol></div></div>';
					}
					jQuery('#responceArea').html(msg);
				},
				// error:userpage.form.ajaxError
			}
			jQuery.extend(options,settings);
			jQuery('#loginForm').ajaxForm(options); 
		}
	},
	auth:{
		init:function(){
			 if("<?=$sesi;?>"){
					location.href = '<?=site_url();?>' + '<?=$sesi;?>';
					jQuery('#button').hide();
			 }else{
			 	userpage.form.init(); 	
			 }
		}
	}
}

$(document).ready(function() {  
	userpage.auth.init(); 	
});



</script>
<script type='text/javascript'>   
function ref(){
	// alert("a");
	// function restoreDB(){
	// alert("<?=site_url($com_url);?>login/refresh");
	// jQuery("#content_restore").load("<?=site_url($com_url);?>login/refresh");
	
     // $.ajax({
		// type:"POST",
		// url:"<?=site_url();?>login/refresh",
		// data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd},
		
		// success:function(data){
			// $('#form-wrapper').html(data);
		// }, // end success
	// dataType:"html"}); // end ajax
}
</script>

