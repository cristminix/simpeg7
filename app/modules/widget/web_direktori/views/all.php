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
		$nomor=$mulai;
		foreach($isi as $key=>$val){
	?>
                    <li>
                      <img src="<?=site_url();?>assets/media/file/<?=$val->thumb;?>" />
                      <h3><?=$nomor.". ".$val->judul;?></h3>
                     <br />
                     <a class="btn-more right" href="<?=site_url()."read/direktori/".$val->id_konten."/".$val->kat_seo."/".$val->seo?>">Selengkapnya</a>                        	
                    </li> 
	<?php
	$nomor++;
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
echo Modules::run("web_detail_samping",$id_kanal,"direktori",$id_rubrik);
?>
        </div>
        <!--sidebar-->
    </div>