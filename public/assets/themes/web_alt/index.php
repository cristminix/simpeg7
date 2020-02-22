<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$nama_app;?> | <?=$slogan_app;?></title>
<link rel="stylesheet" href="<?=site_url();?>public/assets/themes/<?=$theme;?>/styles/load.style.css" />
<link rel="shortcut icon" href="<?=site_url();?>public/assets/themes/<?=$theme;?>/images/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="<?=site_url();?>public/assets/js/jquery/jquery-1.11.0.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">
</head>
<body>
<!--layout-->
<div class="layout">
<?php
echo Modules::run("theme_web_alt/header/index");
echo Modules::run("theme_web_alt/panel_kanal/index","0");
?>
<?=$cTop;?>
    <!--main-page-->
    <div class="main-page">
        <!--content-->
        <div class="content">
		<?=$cMain;?>
        </div>
        <!--content-->
        <!--sidebar-->
        <div class="sidebar">
		<?=$cSide;?>
        </div>
        <!--sidebar-->
    </div>
	<!--main-page-->
<?php
echo Modules::run("theme_web/footer/index");
?>  
<div style="clear:both">
Page rendered in <strong>{elapsed_time}</strong> seconds
</div>

</div>
<!--layout-->
</body>
</html>
