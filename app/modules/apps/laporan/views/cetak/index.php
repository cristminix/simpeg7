<!DOCTYPE html>
<html lang="en">
  <head>
	<title>SKP</title>
<style>
.gridcell	{	border-right:1px solid #333333; border-bottom:1px solid #333333;	}
.left	{	border-left:1px solid #333333;	}
.top	{	border-top:1px solid #333333;	}
</style>
  </head>
  <body>

<?php
	$bulan = $this->dropdowns->bulan();
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="center"><img src="<?=base_url('assets/images/garuda.gif');?>"></td></tr>
<tr><td align="center"><b>PENILAIAN PRESTASI KERJA<br/>PEGAWAI NEGERI SIPIL</b></td></tr>
</table>

<br/>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td width=50>INSTANSI</td>
			<td width=5>:</td>
			<td width=195>PEMERINTAH KOTA TANGERANG</td>
		</tr>
		</table>
</td>
<td width=50>&nbsp;</td>
<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td width=270>JANGKA WAKTU PENILAIAN :</td>
		</tr>
		<tr>
			<td><?=$bulan[$skp->bulan_mulai];?> s.d. <?=$bulan[$skp->bulan_selesai];?></td>
		</tr>
		</table>
</td>
</tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td class="gridcell left top" rowspan=6 width=20 valign=top>1</td>
	<td class="gridcell top" colspan=2>PNS YANG DINILAI</td>
</tr>
<tr>
	<td class="gridcell" width=260> a. Nama</td>
	<td class="gridcell" width=260> <?=(trim($skp->gelar_depan) != '-')?trim($skp->gelar_depan).' ':'';?><?=(trim($skp->gelar_nonakademis) != '-')?trim($skp->gelar_nonakademis).' ':'';?><?=$skp->nama_pegawai;?><?=(trim($skp->gelar_belakang) != '-')?', '.trim($skp->gelar_belakang):'';?></td>
</tr>
<tr>
	<td class="gridcell"> b. NIP</td>
	<td class="gridcell"> <?=$skp->nip_baru;?></td>
</tr>
<tr>
	<td class="gridcell"> c. Pangkat / Golongan Ruang / TMT</td>
	<td class="gridcell"> <?=$skp->nama_pangkat;?> / <?=$skp->nama_golongan;?> / </td>
</tr>
<tr>
	<td class="gridcell" valign=top> d. Jabatan</td>
	<td class="gridcell"> <?=$skp->nomenklatur_jabatan;?></td>
</tr>
<tr>
	<td class="gridcell" valign=top> e. Unit organisasi</td>
	<td class="gridcell"> <?=$skp->nomenklatur_pada;?></td>
</tr>
<tr>
	<td class="gridcell left" rowspan=6 valign=top>2</td>
	<td class="gridcell" colspan=2>PEJABAT PENILAI</td>
</tr>
<tr>
	<td class="gridcell" width=270> a. Nama</td>
	<td class="gridcell" width=270> <?=(trim($skp->penilai_gelar_depan) != '-')?trim($skp->penilai_gelar_depan).' ':'';?><?=(trim($skp->penilai_gelar_nonakademis) != '-')?trim($skp->penilai_gelar_nonakademis).' ':'';?><?=$skp->penilai_nama_pegawai;?><?=(trim($skp->penilai_gelar_belakang) != '-')?', '.trim($skp->penilai_gelar_belakang):'';?></td>
</tr>
<tr>
	<td class="gridcell"> b. NIP</td>
	<td class="gridcell"> <?=$skp->penilai_nip_baru;?></td>
</tr>
<tr>
	<td class="gridcell"> c. Pangkat / Golongan Ruang / TMT</td>
	<td class="gridcell"> <?=$skp->penilai_nama_pangkat;?> / <?=$skp->penilai_nama_golongan;?> / </td>
</tr>
<tr>
	<td class="gridcell" valign=top> d. Jabatan</td>
	<td class="gridcell"> <?=$skp->penilai_nomenklatur_jabatan;?></td>
</tr>
<tr>
	<td class="gridcell" valign=top> e. Unit organisasi</td>
	<td class="gridcell"> <?=$skp->penilai_nomenklatur_pada;?></td>
</tr>
<tr>
	<td class="gridcell left" rowspan=6 valign=top>3</td>
	<td class="gridcell" colspan=2>ATASAN PEJABAT PENILAI</td>
</tr>
<tr>
	<td class="gridcell" width=270> a. Nama</td>
	<td class="gridcell" width=270> </td>
</tr>
<tr>
	<td class="gridcell"> b. NIP</td>
	<td class="gridcell"> </td>
</tr>
<tr>
	<td class="gridcell"> c. Pangkat / Golongan Ruang / TMT</td>
	<td class="gridcell"> </td>
</tr>
<tr>
	<td class="gridcell" valign=top> d. Jabatan</td>
	<td class="gridcell"> </td>
</tr>
<tr>
	<td class="gridcell" valign=top> e. Unit organisasi</td>
	<td class="gridcell"> </td>
</tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td class="gridcell left top" rowspan=11 width=20 valign=top>4</td>
	<td class="gridcell top" colspan=4>UNSUR YANG DINILAI PERILAKU KERJA</td>
	<td class="gridcell top" width=50 >JUMLAH</td>
</tr>
<tr>
	<td class="gridcell" colspan=4 style="padding-left:3px;">A. SASARAN KERJA PEGAWAI</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" valign=top width=120 rowspan=9>B. PERILAKU KERJA</td>
	<td class="gridcell" width=180>1. Orientasi Pelayanan</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>2. Integritas</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>3. Komitmen</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>4. Disiplin</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>5. Kerjasama</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>6. Kepemimpinan</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>7. Jumlah</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>8. Nilai rata-rata</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell" width=180>9. Nilai Perilaku Kerja</td>
	<td class="gridcell" width=50>4</td>
	<td class="gridcell" width=100>5</td>
	<td class="gridcell" width=50 >7</td>
</tr>
<tr>
	<td class="gridcell left" width=20>.</td>
	<td class="gridcell" width=120>.</td>
	<td class="gridcell" width=180>.</td>
	<td class="gridcell" width=50>.</td>
	<td class="gridcell" width=100>.</td>
	<td class="gridcell" width=50 >.</td>
</tr>
<tr>
	<td class="gridcell left" colspan=5 rowspan=2 valign="middle" align="center">NILAI PRESTASI KERJA</td>
	<td class="gridcell" width=50 >.</td>
</tr>
<tr>
	<td class="gridcell" width=50 >.</td>
</tr>
</table>
<br/>
<table cellpadding="0" cellspacing="0" border="0">
<tr style="height:100px;">
	<td class="gridcell left top" style="width:680px;" valign="top">5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI (Apabila ada)</td>
</tr>
<tr style="height:100px;">
	<td class="gridcell left" style="width:680px;" valign="top">6. TANGGAPAN PEJABAT PENIAI ATAS KEBERATAN</td>
</tr>
<tr style="height:100px;">
	<td class="gridcell left" style="width:680px;" valign="top">7. KEPUTUSAN ATASAN PEJABAT PENIAI ATAS KEBERATAN</td>
</tr>
</table>

  </body>
</html>
