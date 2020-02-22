<div class="main-page" style="margin-top:10px;">
        <!--content-->
        <div class="content">
		    <ol class="breadcrumb">
              <?=$jkanal;?>
            </ol>
          <!--latest news-->
          <div class="wrapper">
			<div class='widget-title'><?=strtoupper($rubrik);?></div>
              <div class="widget-box widget-news">
                 <ul>
	<?php
		foreach($isi as $key=>$val){
	?>
                    <li>
                      <img src="<?=base_url();?>assets/media/file/galeri/<?=$val->id_konten;?>/<?=$val->foto_thumbs;?>" />
                      <small><?=$val->hari.", ".$val->tanggal;?></small>	
                      <h3><?=$val->judul;?></h3>
                      <?=$val->isi_artikel;?>
                     <br />
                     <a class="btn-more right" href="<?=site_url()."read/galeri/".$val->id_konten."/".$val->kat_seo."/".$val->seo?>">Selengkapnya</a>                        	
                    </li> 
	<?php
		}
	?>
                 </ul>
				<?=$pager;?>
              </div>        	
          </div>
          <!--latest news-->
                  <div style="clear:both; height:1px;"></div>
        </div>
        <!--content-->
        
        <!--sidebar-->
        <div class="sidebar">
<?php
echo Modules::run("web_detail_samping",$id_kanal,"artikel",$id_rubrik);
?>
        </div>
        <!--sidebar-->
    </div>