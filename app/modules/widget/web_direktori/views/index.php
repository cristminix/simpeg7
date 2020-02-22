<div class='framedaftarwrapper'>
<div class='judulwrapper'><?=strtoupper($wrapper[0]->nama_wrapper);?></div>
<?php
	$nomor=1;
	foreach($iiii as $key=>$val){
		if($nomor%2==1){ $bgc="even";}else{ $bgc="odd";}
		echo "<a href='".base_url()."all/direktori/".$val->id_kategori."/1/".$val->seo."' class=biasa>";
		echo "<div class='framedaftar ".$bgc."'>";
				echo "<div class='nomor'>".$nomor.".</div>";
				echo "<div class='text'>".$val->nama_kategori."</div>";
		echo "</div>";
		echo "</a>";
		$nomor++;
	}
?>
</div>