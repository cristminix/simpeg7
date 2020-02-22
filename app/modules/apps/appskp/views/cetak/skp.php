<!DOCTYPE html>
<html lang="en">
  <head>
	<title>SKP</title>
  </head>
  <body>

<?php
	$bulan = $this->dropdowns->bulan();
?>
		<table border="0" cellpadding="0" cellspacing="0" border="1" width="100%">
		<tr>
			<td colspan="3" align="center"><b>FORMULIR SASARAN KERJA<br/>PEGAWAI NEGERI SIPIL</b></td>
		</tr>
		<tr>
			<td width=70>TAHUN</td>
			<td width=5>:</td>
			<td align="left"><?=$skp->tahun;?></td>
		</tr>
		<tr>
			<td>PERIODE</td>
			<td>:</td>
			<td align="left"><?=$bulan[$skp->bulan_mulai];?> s.d. <?=$bulan[$skp->bulan_selesai];?></td>
		</tr>
		</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" width="270">
		<table border="0" cellpadding="0" cellspacing="0" border="1" width="100%">
		<tr>
			<td colspan=3><u>PEJABAT PENILAI</u></td>
		</tr>
		<tr>
			<td width=70>NAMA </td>
			<td width=5>:</td>
			<td width=195><?=(trim($skp->penilai_gelar_depan) != '-')?trim($skp->penilai_gelar_depan).' ':'';?><?=(trim($skp->penilai_gelar_nonakademis) != '-')?trim($skp->penilai_gelar_nonakademis).' ':'';?><?=$skp->penilai_nama_pegawai;?><?=(trim($skp->penilai_gelar_belakang) != '-')?', '.trim($skp->penilai_gelar_belakang):'';?></td>
		</tr>
		<tr>
			<td>NIP</td>
			<td>:</td>
			<td><?=$skp->penilai_nip_baru;?></td>
		</tr>
		<tr>
			<td valign="top">JABATAN</td>
			<td>:</td>
			<td><?=$skp->penilai_nomenklatur_jabatan;?></td>
		</tr>
		<tr valign="top">
			<td>UNIT KERJA</td>
			<td>:</td>
			<td><?=$skp->penilai_nomenklatur_pada;?></td>
		</tr>
		</table>
</td>
<td width=5>&nbsp;</td>
<td valign="top" width="270">
		<table border="0" cellpadding="0" cellspacing="0" border="1" width="100%">
		<tr>
			<td colspan=3><u>PEGAWAI YANG DINILAI</u></td>
		</tr>
		<tr>
			<td width=70>NAMA </td>
			<td width=5>:</td>
			<td width=195><?=(trim($skp->gelar_depan) != '-')?trim($skp->gelar_depan).' ':'';?><?=(trim($skp->gelar_nonakademis) != '-')?trim($skp->gelar_nonakademis).' ':'';?><?=$skp->nama_pegawai;?><?=(trim($skp->gelar_belakang) != '-')?', '.trim($skp->gelar_belakang):'';?></td>
		</tr>
		<tr>
			<td>NIP</td>
			<td>:</td>
			<td><?=$skp->nip_baru;?></td>
		</tr>
		<tr>
			<td valign="top">JABATAN</td>
			<td>:</td>
			<td><?=$skp->nomenklatur_jabatan;?></td>
		</tr>
		<tr valign="top">
			<td>UNIT KERJA</td>
			<td>:</td>
			<td><?=$skp->nomenklatur_pada;?></td>
		</tr>
		</table>
</td>
</tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<thead>
<tr>
<th rowspan=2 style="border:1px solid #333333;">No.</th>
<th rowspan=2 style="border:1px solid #333333;">KEGIATAN</th>
<th rowspan=2 style="border:1px solid #333333;">A.K.</th>
<th colspan=4 style="border:1px solid #333333;">TARGET</th>
</tr>
<tr>
<th style="border:1px solid #333333;">KUANT.</th>
<th style="border:1px solid #333333;">KUAL.</th>
<th style="border:1px solid #333333;">WAKTU</th>
<th style="border:1px solid #333333;">BIAYA</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
foreach($target AS $key=>$val)
{
?>
<tr>
<td style="border:1px solid #333333;" valign="top"><?=$i;?></td>
<td style="border:1px solid #333333;"><?=$val->pekerjaan;?></td>
<td style="border:1px solid #333333;"><?=$val->ak;?></td>
<td style="border:1px solid #333333;"><?=$val->volume;?> <?=$val->satuan;?></td>
<td style="border:1px solid #333333;"><?=$val->kualitas;?> %</td>
<td style="border:1px solid #333333;"><?=$val->waktu_lama;?> <?=$val->waktu_satuan;?></td>
<td style="border:1px solid #333333; text-align:right;"><?=number_format($val->biaya,2,"."," ");?></td>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>&nbsp;</td>
	<td width=5>&nbsp;</td>
	<td align="left">Tangerang, ...</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td width=270 align="center">PEJABAT PENILAI</td>
		</tr>
		<tr><td width=270 align="center">&nbsp;</td></tr>
		<tr><td width=270 align="center">&nbsp;</td></tr>
		<tr><td width=270 align="center">&nbsp;</td></tr>
		<tr>
			<td align="center"><?=(trim($skp->penilai_gelar_depan) != '-')?trim($skp->penilai_gelar_depan).' ':'';?><?=(trim($skp->penilai_gelar_nonakademis) != '-')?trim($skp->penilai_gelar_nonakademis).' ':'';?><?=$skp->penilai_nama_pegawai;?><?=(trim($skp->penilai_gelar_belakang) != '-')?', '.trim($skp->penilai_gelar_belakang):'';?></td>
		</tr>
		<tr>
			<td align="center">NIP. <?=$skp->penilai_nip_baru;?></td>
		</tr>
		</table>
</td>
<td>&nbsp;</td>
<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td width=270 align="center">PEGAWAI YANG DINILAI</td>
		</tr>
		<tr><td width=270 align="center">&nbsp;</td></tr>
		<tr><td width=270 align="center">&nbsp;</td></tr>
		<tr><td width=270 align="center">&nbsp;</td></tr>
		<tr>
			<td width=270 align="center"><?=(trim($skp->gelar_depan) != '-')?trim($skp->gelar_depan).' ':'';?><?=(trim($skp->gelar_nonakademis) != '-')?trim($skp->gelar_nonakademis).' ':'';?><?=$skp->nama_pegawai;?><?=(trim($skp->gelar_belakang) != '-')?', '.trim($skp->gelar_belakang):'';?></td>
		</tr>
		<tr>
			<td align="center">NIP. <?=$skp->nip_baru;?></td>
		</tr>
		</table>
</td>
</tr>
</table>
<br/>
  </body>
</html>

