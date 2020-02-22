<div class="wrapper" style="margin-top:<?=$margin_top;?>;">
<div id="banner_slider<?=$idd;?>" class="webwidget_slideshow_common side">
	<ul>
	<?php
		foreach($daftar as $key=>$val){
			if($val->foto_thumbs!="-") {
				echo "<li><a href='".$val->foto_thumbs."' target=_blank border=0><img src='".base_url()."assets/media/file/banner/".$val->foto."'></a></li>";	
			} else {
				echo "<li><img src='".base_url()."assets/media/file/banner/".$val->foto."'></li>";	
			}
		}
	?>
	</ul>
</div>
</div>
<script type="text/javascript" src="<?=site_url();?>assets/js/webwidget_slideshow_common.js"></script>
<script language="javascript" type="text/javascript">
            $(function() {
                $("#banner_slider<?=$idd;?>").webwidget_slideshow_common({
                    slideshow_transition_effect: 'slide_left',//slide_left slide_down fade_in
                    slideshow_time_interval: '3000',
                    slideshow_window_width: '300',
                    slideshow_window_height: '180',
                    slideshow_border_style: 'none',//dashed dotted double groove hidden inset none outset ridge solid
                    slideshow_border_size: '1',
                    slideshow_border_color: '#000',
                    slideshow_border_radius: '0',
                    slideshow_padding_size: '0'
                });
            });
</script>
