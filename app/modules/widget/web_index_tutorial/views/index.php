<div class='wrapper' style="margin-top:<?=$margin_top;?>;">
              <div class="widget-title"><?=strtoupper(@$wrapper[0]->nama_wrapper);?></div>
	<div class='artikeljudul'>
	<?php
		foreach($daftar as $key=>$val){
	?>
		<div style="float:left; width:293px; height:250px; overflow:hidden; border:1px solid #eeeeee; margin:5px; padding:5px 5px 5px 5px;">
		<div style="background-color:#333333; color:#FFFFFF; padding:3px 5px 3px 5px; margin-bottom:5px;"><b><?=strtoupper($val->nama_kategori);?></b></div>
	<?php
		foreach($val->isi as $key2=>$val2){
	?>
			<a href="<?=base_url();?>read/artikel/<?=$val2->id_konten;?>/<?=$val->kat_seo;?>/<?=$val2->seo;?>"><div><?=$val2->judul;?></div></a>
	<?php
			}
	?>
						</div>
	<?php
			}
	?>
	</div>
</div>