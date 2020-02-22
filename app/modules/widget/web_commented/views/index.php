          <!--tabs-->
		  <div class='wrapper' style="margin-top:<?=$margin_top;?>;">
              <div class="widget-article-tab-wrapper">                
                <!--Tabs-->	                
                <div class="article-tab">
                  <ul>
                    <li id="article-tab-1" class="active"><a href="javascript:void(0);" onclick="articleIntro(1);">Terpopuler</a></li>
                    <li id="article-tab-2" class="pasive"><a href="javascript:void(0);" onclick="articleIntro(2);">Terkomentari</a></li>
                  </ul>
                </div>
                  
                <!--TabContent 1-->
                <div class="article-intro" id="article-intro-1" style="display:block;">
                  <ul>
	<?php
		$ii=0;
		foreach($populer as $key=>$val){
		$iu=($ii%2==0)? " class=blink" : "";
	?>
                    <li <?=$iu;?>><small><?=$val->hari.", ".$val->tanggal;?></small><br /><a href="<?=site_url();?>read/artikel/<?=$val->id_konten;?>/<?=$val->kat_seo;?>/<?=$val->seo;?>"><?=$val->judul;?></a></li>
	<?php
		$ii++;
		}
	?>
                  </ul>    
                  
                  <div class="pagination pagination-box">
				  <!--
                      <a href="#" class="page gradient">&laquo;</a>
                      <a href="#" class="page gradient">2</a>
                      <a href="#" class="page gradient">3</a>
                      <span class="page active">4</span>
                      <a href="#" class="page gradient">5</a>
                      <a href="#" class="page gradient">&raquo;</a>              
-->
                  </div>
                  
                </div>
                  
                <!--TabContent 2-->
                <div class="article-intro" id="article-intro-2" style="display:none;"> 
                  <ul>
	<?php
		$ii=0;
		foreach($komentar as $key=>$val){
		$iu=($ii%2==0)? " class=blink" : "";
	?>
                    <li <?=$iu;?>><span>15</span><small><?=$val->hari.", ".$val->tanggal;?></small><br /><a href="<?=site_url();?>read/artikel/<?=$val->id_konten;?>/<?=$val->kat_seo;?>/<?=$val->seo;?>"><?=$val->judul;?></a></li>
	<?php
		$ii++;
		}
	?>
                  </ul>    
                  
                  <div class="pagination pagination-box">
				  <!--
                      <a href="#" class="page gradient">&laquo;</a>
                      <a href="#" class="page gradient">2</a>
                      <a href="#" class="page gradient">3</a>
                      <span class="page active">4</span>
                      <a href="#" class="page gradient">5</a>
                      <a href="#" class="page gradient">&raquo;</a>
					  -->
                  </div>                            
                </div>
              </div>
          </div>
          <!--tabs-->
<script>        
    function articleIntro(id){
        $('.article-tab ul li').removeClass('active');
        $('.article-tab ul li').addClass('pasive');
        $('.article-tab ul li#article-tab-'+id).removeClass('pasive');
        $('.article-tab ul li#article-tab-'+id).addClass('active');		
        $('.article-intro').hide();
        $('#article-intro-'+id).fadeIn();		
        $('.article-other').hide();
        $('#article-other-'+id).fadeIn();		
    }	
</script>   
