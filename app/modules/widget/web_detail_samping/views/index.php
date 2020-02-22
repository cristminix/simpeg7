<?php
    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
	foreach($artikel as $key=>$val){
			$seo=str_replace($d, '-', $val->nama_kategori);
		if($val->status=="pasif"){
			echo "<a class='widget-sidebox link' href='".site_url()."all/".$val->komponen."/".$val->id_kategori."/1/".$seo."'>".$val->nama_kategori."</a>";
		} else {
			echo "<div class='widget-sidebox active'>".$val->nama_kategori."</div>";
		}
	}
?>