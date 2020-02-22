<div style="clear:both; width:100%;"></div>
<div calss="wrapper" style="margin-top:<?=$margin_top;?>;">
<div id="lofslidecontent" class="lof-slidecontent">
	<div style="display: none;" class="preload"><div>
</div>
</div>


 <!-- MAIN CONTENT --> 
  <div class="lof-main-outer" style="clear:both; ">
  	<ul style="left: -747.701px; width: 200px;" class="lof-main-wapper">
<?php
	foreach($daftar as $key=>$val){
?>

              <li>
                          <img src="<?=site_url().$val->imgslider;?>">
                          <div class='lof-main-item-desc'>
                          <h4><a href="<?=site_url();?>read/artikel/<?=$val->id_konten;?>/<?=$val->kat_seo;?>/<?=$val->seo;?>"><?=$val->judul;?></a></h4>
                          <p><font-size=2><?=$val->sub;?><br /></font></p>
                          </div>
               </li>
<?php
 }
?>
				 </ul>
            </div>          
            <div class="lof-navigator-outer">
  		      <ul class="lof-navigator">
<?php
	foreach($daftar as $key=>$val){
?>
              			<li>
                          <div><img src="<?=site_url().$val->imgthumbs;?>">
                          <span class=tanggal>Sabtu, <?=$val->tanggal;?></span>
                          <h3><?=$val->judul;?></h3>
                          </div>
                        </li>
<?php
 }
?>
 					</ul>
           </div> 
</div></div>

<script type="text/javascript"> 
$(document).ready( function(){	
	$('#lofslidecontent').lofJSidernews( { interval:4000, easing:'easeInOutQuad', duration:1200, auto:true } );						
});
</script>	
<link rel="stylesheet" href="<?=site_url();?>assets/js/hl_slider/headslideshow.css" type="text/css" />
<script src="<?=site_url();?>assets/js/hl_slider/easing.js" type="text/javascript"></script>
<script src="<?=site_url();?>assets/js/hl_slider/lof_slideshow.js" type="text/javascript"></script>