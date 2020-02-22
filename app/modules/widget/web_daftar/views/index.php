<div class="wrapper" style="margin-top:<?=$margin_top;?>;">

              <div class="widget-sidebox" style="width:100%;">
                  <h4><?=$wrapper[0]->nama_wrapper;?></h4>
	<div id='fr_daftar_<?=$wrapper[0]->id_wrapper;?>'>
					<?php
					foreach($hslquery AS $key=>$val){
						$seling=($key%2==0)?"even":"odd";
						echo "<a href='".site_url()."read/direktori/".$val->id_konten."/".$val->katseo."/".$val->seo."'>";
						echo "<div class=\"widget-sidebox item ada ".$seling."\">".($key+1).". ".$val->judul."</div>";
						echo "</a>";
					}
					?>
	</div>
				  <div id="pager" class="bbb"><?=$pager;?></div>
              </div>

</div>
<script type="text/javascript">
function griddaftar_<?=$wrapper[0]->id_wrapper;?>(hal){
$('#fr_daftar_<?=$wrapper[0]->id_wrapper;?>').html("<img src='<?=base_url();?>assets/images/loading1.gif'>");
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>web_daftar/getdaftar/",
				data:{ "hal": hal,"batas": <?=$batas;?>,"count": <?=$count;?>,"ini": "<?=$ini;?>","id_wrapper": "<?=$wrapper[0]->id_wrapper;?>"},
				success:function(data){
if((data.hslquery.length)>0){
			var table=""; var nomor=data.mulai;
			$.each( data.hslquery, function(index, item){
		if(nomor%2==1){ var bgc="even";}else{ var bgc="odd";}
		table = table+ "<a href='<?=site_url();?>read/direktori/"+item.id_konten+"/"+item.kat_seo+"/"+item.seo+"'>";
		table = table+ "<div class=\"widget-sidebox item ada "+bgc+"\">"+nomor+". "+item.judul+"</div>";
		table = table+ "</a>";
			nomor++;
			}); //endeach
				$('#fr_daftar_<?=$wrapper[0]->id_wrapper;?>').html(table);
				$('#pager').html(data.pager);
		} else {
			$('#fr_daftar').html("Tidak ada komentar");
		}
}, 
        dataType:"json"});
}
function godaftar_<?=$id_wrapper;?>(){
	var gohal=$("#inputdaftar_<?=$id_wrapper;?>").val();
	griddaftar_<?=$id_wrapper;?>(gohal);
}
</script>
