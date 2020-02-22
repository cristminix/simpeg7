<?php
$isi[0]->isi_artikel=str_replace("thumbs_","",$isi[0]->isi_artikel);		
$isi[0]->isi_artikel=str_replace('src="assets','src="'.base_url().'assets',$isi[0]->isi_artikel);		
?>
		    <ol class="breadcrumb">
              <?=$jkanal;?>
            </ol>
       	  	<div class="article-detail">
				<div class='widget-title'><?=strtoupper(@$isi[0]->nama_kategori);?></div>
            	 <h2><?=@$isi[0]->judul;?></h2>
                 <span class="datepost"><?php echo @$isi[0]->hari.", ".@$isi[0]->tanggal;?></span>
				 <?=@$isi[0]->isi_artikel;?>
       	  	</div>
<script type="text/javascript">
$(document).ready(function(){
	gridartikel(<?=$hal;?>);
});
////////////////////////////////////////////////////////////////////////////
function gridartikel(hal){
var rubrik = $("#rubrik").html();
$('#lainnya_'+rubrik+'').html("<img src='<?=base_url();?>assets/images/loading1.gif'>");
if(hal=="end"){var hali="end";} else {var hali=hal;}
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>web_artikel/getartikel/",
				data:{"hal": hali, "batas": <?=$batas;?>, "rubrik": rubrik},
				success:function(data){
if((data.hslquery.length)>0){
			var table="<ul>"; var nomor=0;
			$.each( data.hslquery, function(index, item){
					if(nomor%2==0){ var bgc="even";}else{ var bgc="odd";}
					if(item.id_konten == <?=@$isi[0]->id_konten;?>){
						table = table+ "<div class='widget-sidebox item "+bgc+"'>";
					} else {
						table = table+ "<a href=\"<?=base_url();?>read/artikel/"+item.id_konten+"/"+item.kat_seo+"/"+item.seo+"\"><div class='widget-sidebox item ada "+bgc+"'>";
					}
					table = table+ "<small>"+ item.hari+", "+ item.tanggal+"</small>";
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
