<div class="wrapper" style="margin-top:<?=$margin_top;?>;">
    <div class="main-slider">        
        <div id="main-slider">		
<?php
	foreach($daftar as $key=>$val){
		echo "<a href=\"".site_url()."read/artikel/".$val->id_konten."/".$val->kat_seo."/".$val->seo."\">";
		echo "<img src=\"".site_url().$val->imgslider."\" alt='natural' />";
		echo "<span><b>".$val->judul."</b>";
		echo "</br>".$val->sub."</span></a>";
 }
 ?>
	 </div>
 </div>
</div>
<script type="text/javascript" src="<?=site_url();?>assets/js/coin-slider/coin-slider.js"></script>
<link rel="stylesheet" href="<?=site_url();?>assets/js/coin-slider/coin-slider-styles.css" type="text/css" />
<script>
	$('#main-slider').coinslider({width:1008,height:375});
</script>

           