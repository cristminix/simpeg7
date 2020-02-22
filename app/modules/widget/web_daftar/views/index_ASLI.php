<div class='framedaftarwrapper'>
	<div class='judulwrapper'><?=strtoupper($wrapper[0]->nama_wrapper);?></div>
	<div id='fr_daftar_<?=$id_wrapper;?>'>
		<?php
		$nomor=1;
			foreach($hslquery as $key=>$val){
				if($nomor%2==1){ $bgc="even";}else{ $bgc="odd";}
				echo "<a href='".base_url()."read/daftar/".$val->id_konten."/".$val->katseo."/".$val->seo."' class=biasa>";
				echo "<div class='framedaftar ".$bgc."'>";
				echo "<div class='nomor'>".$nomor.".</div>";
				echo "<div class='text'>".$val->judul."</div>";
				echo "</div>";
				echo "</a>";
				$nomor++;
			}
		echo $pager;
		?>
	</div>
<div class='clr'></div>
</div>
<script type="text/javascript">
function refresh(load){	window.open(load,"_self");	} 
///////////////////////////////////////////
function griddaftar_<?=$id_wrapper;?>(hal){
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>web_daftar/getdaftar/",
				data:{ "hal": hal,"batas": <?=$batas;?>,"count": <?=$count;?>,"ini": "<?=$ini;?>","id_wrapper": "<?=$id_wrapper;?>"},
				success:function(data){
if((data.hslquery.length)>0){
			var table=""; var nomor=data.mulai;
			$.each( data.hslquery, function(index, item){
		if(nomor%2==1){ var bgc="even";}else{ var bgc="odd";}
		table = table+ "<a href='<?=base_url();?>read/daftar/"+item.id_konten+"/"+item.kat_seo+"/"+item.seo+"' class=biasa>";
		table = table+ "<div class='framedaftar "+bgc+"'>";
		table = table+ "<div class='nomor'>"+nomor+".</div><div class='text'><b>"+item.judul+"</b></div>";
		table = table+ "</div>";
		table = table+ "</a>";
			nomor++;
			}); //endeach
			table = table+data.pager;
				$('#fr_daftar_<?=$id_wrapper;?>').html(table);
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
