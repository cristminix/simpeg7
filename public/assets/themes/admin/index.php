<!DOCTYPE html>
<html lang="en">

<style>

a:hover, a:hover .fa {
  color: RGBA(15,15,15,0.2);
  // background-color: yellow;
  text-decoration:none !important;
}

// .menu a.main-nav-item:hover { color: red;}

	
	 li:hover a {
	background: e2eff3;
	// color:yellow;
	} 

</style>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Informasi Kepegawaian</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('public/assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?=base_url('public/assets/css/plugins/metisMenu/metisMenu.min.css');?>" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="<?=base_url('public/assets/css/plugins/timeline.css');?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url('public/assets/css/sb-admin-2.css');?>" rel="stylesheet">
    <link href="<?=base_url('public/assets/css/sbadmin2-sidebar-toggle.css');?>" rel="stylesheet">
    <link href="<?=base_url('public/assets/css/main.css');?>" rel="stylesheet">
    <!-- dataTables CSS -->
    <link href="<?=base_url('public/assets/css/plugins/dataTables.bootstrap.css');?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?=base_url('public/assets/css/font-awesome/latest/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url('public/assets/css/tile.css');?>" rel="stylesheet" type="text/css">
    <!-- bootstrapValidator -->
    <link href="<?=base_url('public/assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css">
    <!-- bootstrapValidator -->
    <link href="<?=base_url('public/assets/css/plugins/bootstrapValidator/0.5.2/bootstrapValidator.css');?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <link href="<?=base_url('public/assets/js/html5shiv/3.7.2/html5shiv.min.js');?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url('public/assets/js/respond/1.4.2/respond.min.js');?>" rel="stylesheet" type="text/css">
    <!-- jQuery Version 1.11.0 -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/jquery/jquery-1.11.0.min.js');?>"></script>
    <!-- Bootstrap Core JavaScript -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/bootstrap.min.js');?>"></script>
    <!-- Metis Menu Plugin JavaScript -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/plugins/metisMenu/metisMenu.min.js');?>"></script>
    <!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/sb-admin-2.js');?>"></script>
    <!-- bootstrap-datetimepicker -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/plugins/bootstrap-datetimepicker/moment.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('public/assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');?>"></script>
    <!-- bootstrapValidator -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/plugins/bootstrapValidator/0.5.2/bootstrapValidator.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('public/assets/js/plugins/bootstrapValidator/0.5.2/language/id_ID.js');?>"></script>
    <!-- bootstrapForm -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/jquery/jqueryform/3.51.0/jquery.form.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('public/assets/js/jquery/maskmoney/3.0.2/jquery.maskMoney.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('public/assets/js/jquery/jquery.cookie.js');?>"></script>

    <style type="text/css">
<!--
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {color: #0000FF}
-->
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color:rgb(12, 93, 197); border-bottom:solid #00c0ef;">
            <div class="navbar-header" >
				<div style="float:left;padding:2px 0px 0px 15px;"><img src="<?=base_url('public/assets/images/logo_in.png');?>" style='width:55px; vertical-align:middle; '></div>
				<div style="float:left;display:table;padding-top:7px; padding-left:15px;">
					<div>
					  <h5 style="margin:0px;padding:0px; color:#ffffff;"><strong>Perusahaan Daerah Air Minum Tirta Kerta Raharja (PDAM TKR)</strong></h5>
					</div>
					<div style="color:#ffffff";>Sistem Informasi Kepegawaian</div>
				</div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right" >
				<li>
					<!--menu toggle button -->
					<button id="menu-toggle" type="button" data-toggle="button" class="btn btn-default btn-xs">
						<i class="fa fa-exchange fa-fw"></i>
					</button>
				</li>
                <li class="dropdown">
                    <a  class="dropdown-toggle" data-toggle="dropdown" href="#"><i  class="fa fa-user fa-fw" style="color:white;"></i>  <i class="fa fa-caret-down" style="color:white;"></i></a>
                    <ul  style="background-color:#e2eff3;" class="dropdown-menu dropdown-user">
						
                        <li><a href="<?=site_url('login/out');?>"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
                         
                    </ul>
                    <!-- dropdown-user -->
                </li>
                <!-- dropdown -->
            </ul>
            <!-- navbar-top-links -->
			<div id="sidebar-wrapper">
				<div style="background-color:#e2eff3;" class="navbar-default sidebar" role="navigation">
					<div style="background-color:#e2eff3;" class="sidebar-nav navbar-collapse">
						<ul  style="background-color:#fafafa;" class="nav in" id="side-menu"><?=$menu_side;?></ul>
					</div>
					<!-- /.sidebar-collapse -->
				</div>
			</div>
            <!-- /.navbar-static-side -->
        </nav>


        <div id="page-wrapper">
		<?=$konten;?>
        </div>
        <!-- /#page-wrapper -->


<script type="text/javascript">
	$(document).ready(function() {
		if($.cookie('toogle')){
			$("#wrapper").toggleClass("toggled",true);
		}
		
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
			if($.cookie('toogle')){
				$.removeCookie('toogle',{path: '/' });
			}else{
				$.cookie('toogle', true, {path: '/' });
			}
			$("#wrapper").toggleClass("toggled");

            $('#wrapper.toggled').find("#sidebar-wrapper").find(".collapse").collapse('hide');

        });
    });
	
function pindah_keluar(){
			$.ajax({
				type:"POST",
				url:"http://localhost/cmsopik/masuk",
				success:function(data){	
					location.href = 'http://localhost/cmsopik/cp';
				}, // end success
	        dataType:"html"});
}
function loadSegment(segmen,page){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>"+page,
				beforeSend:function(){	$('#'+segmen).html('').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');	},
				success:function(data){	$('#'+segmen).html(data);	}, // end success
	        dataType:"html"});
}
function loadFragment(elmContainer,url){
	$.ajax({
		type:"POST",	url:url,
		beforeSend:function(){	$(elmContainer).html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');	},
		success:function(data){	$(elmContainer).html(data);	},
	dataType:"html"});
}
</script>
</body>

</html>
