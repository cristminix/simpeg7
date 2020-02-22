          <!--latest news-->
          <div class="wrapper" style="margin-top:<?=$margin_top;?>;">
              <div class="widget-title"><?=strtoupper(@$wrapper[0]->nama_wrapper);?></div>
              <div class="widget-box widget-news">
                 <ul>
	<?php
		foreach($daftar as $key=>$val){
	?>
                    <li>
                      <img src="<?=site_url();?>assets/media/file/artikel/<?=$val->thumb;?>" />
                      <small><?=$val->hari.", ".$val->tanggal;?></small>	
                      <h3><?=$val->judul;?></h3>
                      <?=$val->sub;?>
                     <br />
                     <a class="btn-more right" href="<?=site_url()."read/artikel/".$val->id_konten."/".$val->kat_seo."/".$val->seo?>">Selengkapnya</a>                        	
                    </li> 
	<?php
		}
	?>
                 </ul>
              </div>        	
          </div>
          <!--latest news-->
