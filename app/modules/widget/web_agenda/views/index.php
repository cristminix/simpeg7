<div class='framedaftarwrapper'>
<div class='judulwrapper'><?=strtoupper($wrapper[0]->nama_wrapper);?></div>
<?php
	foreach($iiii as $key=>$val){
		if($key%2==1){$bgc="odd";} else {$bgc="even";}
		echo "<a href='".base_url()."read/agenda/".$val->id_konten."/".$val->kat_seo."/".$val->seo."' class=biasa>";
		echo "<div class='frameagenda ".$bgc."'>";
			echo "<div class='kategori'>".$val->nama_kategori."</div>";
			echo "<div class='isi'>";
			echo "<div class='tema'>".$val->judul."</div>";
			echo "<div class='tanggal'>".$val->hari_mulai.", ".$val->tgl_mulai." s/d ".$val->hari_selesai.", ".$val->tgl_selesai."</div>";
			echo "</div>";
		echo "<div class=clr></div>";
		echo "</div>";
		echo "</a>";
	}
?>
</div>
