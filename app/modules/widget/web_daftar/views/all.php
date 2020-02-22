<div class='mainbody'>
	<div class='artikelbody'>
<div class='framedaftarwrapper'>
<?=$jkanal;?>
<div class='judulrubrik'><?=strtoupper($rubrik);?></div>
<?php
$nomor=$mulai;
foreach($isi as $key=>$val){
		if($val->foto_thumbs!=""){	$sanu = "<img src='".base_url()."assets/media/file/direktori/".$val->id_direktori."/".$val->foto_thumbs."' width=50px>";	} else {	$sanu = "&nbsp;";	}
		if($nomor%2==0){	$rww="odd";	}	else	{	$rww="even";	}
	echo "<a href='".base_url()."read/daftar/".$val->id_direktori."/".$val->kat_seo."/".$val->seo."' class='biasa'>";
	echo "<div class='framedaftar $rww'>";
	echo "<div class='nomorall'>".$nomor.".</div>";
	echo "<div class='gambarall'>".$sanu."</div>";
	echo "<div class='textall'>".$val->nama_direktori."</div>";
	echo "</div>";
	echo "</a>";
		$nomor++;
}
?>
<?php
echo $pager;
?>
</div>
	</div>
	<div class='sidebody'>
<?php
echo Modules::run("web_detail_samping",$id_kanal,"direktori",$id_rubrik);
?>
	</div>
</div>
