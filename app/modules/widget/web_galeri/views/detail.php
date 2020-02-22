<!--main-page-->
<div class="main-page" style="margin-top:10px;">
        <!--content-->
        <div class="content">
        
	        <ol class="breadcrumb">
              <?=$jkanal;?>
            </ol>
       	  	<div class="article-detail">
				<div class='widget-title'><?=strtoupper(@$muka[0]->nama_kategori);?></div>
            	 <h2><?=@$muka[0]->judul;?></h2>
                 <span class="datepost"><?php echo @$muka[0]->hari.", ".@$muka[0]->tanggal;?></span>
				 <?=@$muka[0]->isi_artikel;?>
       	  	</div>
<?php
	foreach($isi as $key=>$val){
		echo "<div  class=\"gallery-box margin_r_10\">";
		echo "<a class=\"group1\" href=\"".site_url()."assets/media/file/galeri/".@$muka[0]->id_konten."/".$val->foto."\">";
		echo "<img src=\"".site_url()."assets/media/file/galeri/".@$muka[0]->id_konten."/".$val->foto_thumbs."\" alt=\"".$val->judul_foto."\">";
		echo "<p>".$val->judul_foto."</p>";
		echo "</a>";
		echo "</div>";
	}
?>

      </div>
        <!--content-->
        <!--sidebar-->
        <div class="sidebar">
		  <div id=rubrik style='display:none'><?=@$muka[0]->id_kategori; ?></div>
          <div class="wrapper">
              <div class="widget-sidebox">
                  <h4>Arsip <?=@$muka[0]->nama_kategori;?></h4>
                  <div id='lainnya_<?=@$muka[0]->id_kategori;?>'></div>
				  <div class="clearfix"></div>
                   <div id='pager' class='bbb'></div>
              </div>
          </div>
          <div class="clearfix"></div>
<?php
echo Modules::run("web_detail_samping",@$muka[0]->id_kanal,"artikel",@$muka[0]->id_kategori);
?>
      </div>
        <!--sidebar-->
   </div>
<!--main-page-->
<script type="text/javascript" src="<?=site_url();?>assets/js/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?=site_url();?>assets/js/colorbox/colorbox.css" type="text/css" />

<script>
$(function(){
	$(".group1").colorbox({rel:'group1'});
});
</script>
<!--main-page-->
<script type="text/javascript">
$(document).ready(function(){
	gridartikel(<?=$hal;?>);
});
////////////////////////////////////////////////////////////////////////////
function gridartikel(hal){
var rubrik = $("#rubrik").html();
$('#lainnya_'+rubrik+'').html("<img src='<?=site_url();?>assets/images/loading1.gif'>");
if(hal=="end"){var hali="end";} else {var hali=hal;}
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>web_galeri/getgaleri/",
				data:{"hal": hali, "batas": <?=$batas;?>, "rubrik": rubrik},
				success:function(data){
if((data.hslquery.length)>0){
			var table="<ul>"; var nomor=0;
			$.each( data.hslquery, function(index, item){
					if(nomor%2==0){ var bgc="even";}else{ var bgc="odd";}
					if(item.id_konten == <?=@$isi[0]->id_konten;?>){
						table = table+ "<div class='widget-sidebox item "+bgc+"'>";
					} else {
						table = table+ "<a href=\"<?=site_url();?>read/galeri/"+item.id_konten+"/"+item.kat_seo+"/"+item.seo+"\"><div class='widget-sidebox item ada "+bgc+"'>";
					}
					table = table+ "<small>"+ item.hari_buat+", "+ item.tanggal+"</small>";
					table = table+ "<br />";
					table = table+item.judul;
					if(item.id_konten == <?=@$isi[0]->id_konten;?>){
						table = table+ "</div>";
					} else {
						table = table+ "</div></a>";
					}
				nomor++;
			}); //endeach
			table = table+"</ul>";
			var hu=data.pager;
				$('#lainnya_'+rubrik+'').html(table);
				$('#pager').html(data.pager);
				$('#status_'+rubrik+'').html("lama");
		} else {
			$('#lainnya_'+rubrik+'').html("");
		}
}, 
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
</script>
