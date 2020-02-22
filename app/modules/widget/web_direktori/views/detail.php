<!--main-page-->
<div class="main-page" style="margin-top:10px;">
        <!--content-->
        <div class="content">
        
	        <ol class="breadcrumb">
              <?=$jkanal;?>
            </ol>
       	  	<div class="article-detail">
				<div class='widget-title'><?=strtoupper(@$isi[0]->nama_kategori);?></div>
            	 <h2><?=@$isi[0]->judul;?></h2>
				 <br/>
				 <?php
				 foreach($atr AS $key=>$val){
				 ?>
				 <div><div style="width:200px; float:left;"><?=$val->label;?></div><span>: <?=$val->nilai;?></span></div>
				 <?php
				 }
				 ?>
       	  	</div>
      </div>
        <!--content-->
        <!--sidebar-->
        <div class="sidebar">
				<div id=rubrik style='display:none'><?=@$isi[0]->id_kategori; ?></div>


          <div class="wrapper">
              <div class="widget-sidebox">
                  <h4><?=@$isi[0]->nama_kategori;?> lainnya</h4>
                  <div id='lainnya_<?=@$isi[0]->id_kategori;?>'></div>
				  <div class="clearfix"></div>
                   <div id='pager' class='bbb'></div>
              </div>
          </div>
          <div class="clearfix"></div>
<?php
echo Modules::run("web_detail_samping",@$isi[0]->id_kanal,"artikel",@$isi[0]->id_kategori);
?>
      </div>
        <!--sidebar-->
   </div>
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
				url:"<?=site_url();?>web_direktori/getdirektori/",
				data:{"hal": hali, "batas": <?=$batas;?>, "rubrik": rubrik},
				success:function(data){
if((data.hslquery.length)>0){
			var table="<ul>"; var nomor=data.mulai;
			$.each( data.hslquery, function(index, item){
					if(nomor%2==0){ var bgc="even";}else{ var bgc="odd";}
					if(item.id_konten == <?=@$isi[0]->id_konten;?>){
						table = table+ "<div class='widget-sidebox item "+bgc+"'>";
					} else {
						table = table+ "<a href=\"<?=site_url();?>read/direktori/"+item.id_konten+"/"+item.kat_seo+"/"+item.seo+"\"><div class='widget-sidebox item ada "+bgc+"'>";
					}
					table = table+nomor+". "+item.judul;
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
