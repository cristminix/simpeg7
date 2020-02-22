<?php
////////////////////////////////////////////////////////////////
class Paging {

	function halamanB($banyakItem,$banyakHal,$banyakBat=10,$hal,$fnpaging="paging"){
		$batas=($hal-1)*$banyakBat;
		$atas=$batas+$banyakBat;
		$page=ceil($banyakItem/$banyakBat);
		$b_atas=($atas<$banyakItem)?$atas:$banyakItem;
		$pagel=ceil($page/$banyakHal);
		$beem=ceil($hal/$banyakHal);
		$beem_a=(($beem-1)*$banyakHal)+1;
		$beem_z=($beem!=$pagel)?$beem_a+$banyakHal:$page+1;
		$sebel=$beem-1;
		$berik=$beem+1;
		$batasi=$batas+1;

		$beem_sebel=($beem!=1)?"<div class='btn btn-default' onclick='javacsript:void(0); grid$fnpaging(".$sebel*$banyakHal.");'>Prev</div>":"<div class='btn btn-default active'>Prev</div>";
		$halfnpaging="hal".$fnpaging;
		$hasilHal[$halfnpaging][0]=$beem_sebel;
			$i=1;
		for($bw=$beem_a;$bw<$beem_z;$bw++){
			$hasilHal[$halfnpaging][$i]=($hal!=$bw)?"<div class='btn btn-default' onclick='javascript:void(0); grid$fnpaging($bw);'>$bw</div>":"<div class='btn btn-default active'>$bw</div>";
			$i++;
		}
		$beem_berik=($beem!=$pagel)?"<div class='btn btn-default' onclick='javacsript:void(0); grid$fnpaging($bw);'>Next</div>":"<div class='btn btn-default active'>Next</div>";
		$hasilHal[$halfnpaging][$i]=$beem_berik;

		$batasfnpaging="batas".$fnpaging;$hasilHal[$batasfnpaging]=$batas;
		$b_atasfnpaging="b_atas".$fnpaging;$hasilHal[$b_atasfnpaging]=$b_atas;
		$b_halmaxfnpaging="b_halmax".$fnpaging;$hasilHal[$b_halmaxfnpaging]=$page;
		$halamanfnpaging="halaman".$fnpaging;$hasilHal[$halamanfnpaging]=$hal;
		return $hasilHal;
	}
//////////////////////////////////////////////////
	function halamanD($banyakItem,$banyakHal,$banyakBat=10,$hal,$fnpaging="paging"){
		$batas=($hal-1)*$banyakBat;
		$atas=$batas+$bat;
		$page=ceil($banyakItem/$banyakBat);
		$b_atas=($atas<$banyakItem)?$atas:$banyakItem;
		$pagel=ceil($page/$banyakHal);
		$beem=ceil($hal/$banyakHal);
		$beem_a=(($beem-1)*$banyakHal)+1;
		$beem_z=($beem!=$pagel)?$beem_a+$banyakHal:$page+1;
		$sebel=$beem-1;
		$berik=$beem+1;
		$batasi=$batas+1;

		$beem_sebel=($beem!=1)?"<a class='page gradient' href='".site_url()."$fnpaging/".$sebel*$banyakHal."/XX'>Prev</a>":"<span class='page active'>Prev</span>";
		$halfnpaging="hal".$fnpaging;
		$hasilHal[$halfnpaging][0]=$beem_sebel;
			$i=1;
		for($bw=$beem_a;$bw<$beem_z;$bw++){
			$hasilHal[$halfnpaging][$i]=($hal!=$bw)?"<a class='page gradient' href='".site_url()."$fnpaging/$bw/XX'>$bw</a>":"<span class='page active'>$bw</span>";
			$i++;
		}
		$beem_berik=($beem!=$pagel)?"<a class='page gradient' href='".site_url()."$fnpaging/$bw/XX'>Next</a>":"<span class='page active'>Next</span>";
		$hasilHal[$halfnpaging][$i]=$beem_berik;

		$batasfnpaging="batas".$fnpaging;$hasilHal[$batasfnpaging]=$batas;
		$b_atasfnpaging="b_atas".$fnpaging;$hasilHal[$b_atasfnpaging]=$b_atas;
		$b_halmaxfnpaging="b_halmax".$fnpaging;$hasilHal[$b_halmaxfnpaging]=$pagekk;
		$halamanfnpaging="halaman".$fnpaging;$hasilHal[$halamanfnpaging]=$hal;
		return $hasilHal;
	}
}
?>