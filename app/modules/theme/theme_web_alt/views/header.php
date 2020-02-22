	<div class="header" style="height:<?=$height;?>; margin-top:<?=$margin_top;?>; margin-bottom:<?=$margin_bottom;?>; padding-top:<?=$padding_top;?>; padding-bottom:<?=$padding_bottom;?>;">
    	<div class="logo" style="margin:0px;">
			<div style="margin:0px; float:left;">
				<img src="<?=base_url();?>assets/themes/<?=$theme;?>/images/logo_doang.png" />
			</div>
			<div style="margin-top:10px; float:left;">
				<div style="font-weight:normal;	font-size:32px;	text-shadow:1px 1px 1px #333; font-family:impact; font-weight:normal;"><?php if($jadal==""){echo $nama_app;} else {echo $jadal;} ?></div>
				<div style="font-weight:normal;	font-size:16px;	text-shadow:1px 1px 1px #333; font-family:impact; font-weight:normal;"><?php if($sub_jadal==""){echo $slogan_app;} else {echo $sub_jadal;} ?></div>
			</div>
        </div>
        <div class="search">
        	<form><input type="text" name="keyword" placeholder="Search" class="search-text" /><input type="submit" name="search" class="search-btn" value="" /></form>
        </div>        
    </div>    
