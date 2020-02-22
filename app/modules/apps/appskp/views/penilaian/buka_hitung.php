<div style="overflow-x:scroll;overflow-y:none;">
<?php
$bulan = $this->dropdowns->bulan();
foreach($skp_tahun as $key=>$val){
?>
<div style="padding-bottom:10px;">
<span><b>SKP No. <?=($key+1);?>, Periode: <?=$bulan[$val->bulan_mulai];?> s.d. <?=$bulan[$val->bulan_selesai];?></b></span>
<table width=1900>
<thead id=gridhead>
<tr height=30 style="border-bottom:1px solid #ccc;">
<th rowspan=2 width=35 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;">No.</th>
<th rowspan=2 width=250 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;">PEKERJAAN</th>
<th colspan=5 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;">TARGET</th>
<th colspan=5 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;">REALISASI</th>
<th rowspan=2 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;">PERHITUNGAN</th>
<th rowspan=2 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;border-right:1px solid #ccc;text-align:center;">NILAI CAPAIAN</th>
<th rowspan=2 width=50>&nbsp;</th>
<th rowspan=2 width=40 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;">% waktu</th>
<th rowspan=2 width=40 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">% biaya</th>
<th rowspan=2 width=50>&nbsp;</th>
<th colspan=4 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">SKOR</th>
<th rowspan=2 width=50>&nbsp;</th>
<th colspan=2 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">Rm. WAKTU</th>
<th rowspan=2 width=50>&nbsp;</th>
<th colspan=2 width=100 style="border-left:1px solid #ccc;border-top:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">Rm. BIAYA</th>
</tr>
<tr height=30>
<th width=70 style="border-left:1px solid #ccc;text-align:center;">AK</th>
<th width=100 style="border-left:1px solid #ccc;text-align:center;">KUANT.</th>
<th width=60 style="border-left:1px solid #ccc;text-align:center;">KUAL.</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;">WAKTU</th>
<th width=100 style="border-left:1px solid #ccc;text-align:center;">BIAYA</th>

<th width=70 style="border-left:1px solid #ccc;text-align:center;">AK</th>
<th width=100 style="border-left:1px solid #ccc;text-align:center;">KUANT.</th>
<th width=60 style="border-left:1px solid #ccc;text-align:center;">KUAL.</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;">WAKTU</th>
<th width=100 style="border-left:1px solid #ccc;text-align:center;">BIAYA</th>

<th width=70 style="border-left:1px solid #ccc;text-align:center;">KUANT.</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;">KUAL.</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;">WAKTU</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">BIAYA</th>

<th width=70 style="border-left:1px solid #ccc;text-align:center;">< 24</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">> 24</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;">< 24</th>
<th width=70 style="border-left:1px solid #ccc;text-align:center;border-right:1px solid #ccc;">> 24</th>
</tr>
</thead>
<tbody>
<?php
$j_perhitungan=0;
$j_nilai_capaian=0;
$i=0;
foreach($val->target as $ky=>$vl){
$sttop=($ky==0)?"border-top:2px solid #ccc;border-bottom:1px solid #ccc;padding:3px;":"border-bottom:1px solid #ccc;padding:3px;";
$j_perhitungan=$j_perhitungan+$vl->perhitungan;
$j_nilai_capaian=$j_nilai_capaian+$vl->nilai_capaian;
$i++;
?>
<tr>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=($ky+1);?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->pekerjaan;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->ak;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->volume." ".$vl->satuan;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->kualitas;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->waktu_lama." ".$vl->waktu_satuan;?></td>
<td style="border-left:1px solid #ccc;text-align:right;<?=$sttop;?>"><?=number_format($vl->biaya,2,","," ");?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->r_ak;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->r_volume." ".$vl->satuan;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->r_kualitas;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->r_waktu_lama." ".$vl->waktu_satuan;?></td>
<td style="border-left:1px solid #ccc;text-align:right;<?=$sttop;?>"><?=number_format($vl->r_biaya,2,","," ");?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->perhitungan;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>border-right:1px solid #ccc;"><?=number_format($vl->nilai_capaian,2,"."," ");?></td>
<td>&nbsp;</td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->persen_waktu;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>border-right:1px solid #ccc;"><?=$vl->persen_biaya;?></td>
<td>&nbsp;</td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->skor_kuantitas;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->skor_kualitas;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->skor_waktu;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>border-right:1px solid #ccc;"><?=$vl->skor_biaya;?></td>
<td>&nbsp;</td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->rw_K_24;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>border-right:1px solid #ccc;"><?=$vl->rw_L_24;?></td>
<td>&nbsp;</td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><?=$vl->rb_K_24;?></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>border-right:1px solid #ccc;"><?=$vl->rb_L_24;?></td>
</tr>
<?php
}
?>
<tr style="background-color:#eee">
<td style="border-left:1px solid #ccc;<?=$sttop;?>text-align:right;" colspan=12><b>Total :</b></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>"><b><?=$j_perhitungan;?></b></td>
<td style="border-left:1px solid #ccc;<?=$sttop;?>border-right:1px solid #ccc;"><b><?=number_format(($j_nilai_capaian/$i),2,"."," ");?></b></td>
</tr>
</tbody>
</table>
</div>
<?php
}
?>
</div>