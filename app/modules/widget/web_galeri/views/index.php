          <!--photo-->
		  <div class='wrapper' style="margin-top:<?=$margin_top;?>;">
              <div class="widget-title"><?=strtoupper(@$wrapper[0]->nama_wrapper);?></div>
              <div class="widget-box widget-photo">
                 <ul>

<?php
	foreach($daftar as $key=>$val){
		echo "<li>";
		echo "<a href='".base_url()."read/galeri/".$val->id_konten."/".$val->kat_seo."/".$val->seo."'>";
		echo "<img src='".base_url()."assets/media/file/galeri/".$val->id_konten."/".$val->foto_thumbs."' title='".$val->judul."'>";
		echo "</a>";
		echo "<l/i>";
	}
?>
                  </ul> 
<!--                 
                  <div class="pagination center">
                      <a href="#" class="page gradient">first</a>
                      <a href="#" class="page gradient">2</a>
                      <a href="#" class="page gradient">3</a>
                      <span class="page active">4</span>
                      <a href="#" class="page gradient">5</a>
                      <a href="#" class="page gradient">6</a>
                      <a href="#" class="page gradient">last</a>
                   </div>
-->
              </div>        	
          </div>
          <!--photo-->
            
          <div class="clearfix"></div>
