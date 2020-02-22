<div style="text-align:center">
	<h3>PERUSAHAAN DAERAH AIR MINUM<h3>
	<h2>TIRTA KERTA RAHARJA<h2>
	<h3>KABUPATEN TANGERANG<h3>
	<h3><?php echo strtoupper($nomenklatur_pada);?><h3>
	<h3>NOTA DINAS<h3>
Nomor :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<p></p><p></p>
<div style="text-align:left">
<table>
<tr><td width="100px">Kepada Yth.</td><td width="10px">:</td><td>Bapak Direktur Umum Melalui Bagian Kepegawaian</td></tr>
<tr><td>Dari</td><td width="10px">:</td><td><?php echo $nama_pegawai;?></td></tr>
<tr><td>Perihal</td><td width="10px">:</td><td>Permohonan cuti tahunan</td></tr>
<tr><td>Tanggal</td><td width="10px">:</td><td><?php echo $tgl_cuti1;?> </td></tr>
</table>
</div>
<hr>

<div style="text-align:justify">
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang Bertanda-tangan dibawah ini :</p>
<p></p>
	<table style="padding-left:100px;">
	<tr>
		<td width="50px;"></td><td width="125px">Nama</td><td width="10px">:</td><td width="400px"><?php echo $nama_pegawai;?></td>
	</tr>
	<tr>
		<td width="50px;"></td><td width="125px">NIP</td><td width="10px">:</td><td><?php echo $nip_baru;?></td>
	</tr>
	<tr>
		<!-- <td width="125px">Peringkat/Pangkat</td><td width="10px">:</td><td><?php echo $nama_pegawai;?></td> -->
		<td width="50px;"></td><td width="125px">Jabatan</td><td width="10px">:</td><td><?php echo $nomenklatur_jabatan;?></td>
	</tr>
	<tr>
		<td width="50px;"></td><td width="125px">Unit Kerja</td><td width="10px">:</td><td><?php echo $nomenklatur_pada;?></td>
	</tr>
	</table>
	<p></p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $remarks;?>, maka mohon diberikan cuti tahunan selama <?php echo ($DiffDate+1);?> hari kerja pada tanggal <?php echo ($DiffDate > 0 ? $tgl_cuti1." s/d ".$tgl_cuti2 : $tgl_cuti1);?>.</p>

<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Demikianlah permohonan ini kami sampaikan, atas perhatian dan pertimbangan Bapak, saya ucapkan terimakasih.
</p>
<p></p>
</div>

<table>
<tr>
<td><?php echo $jabatan_atasan;?></td><td></td><td>Pemohon</td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td><?php echo $atasan;?></td><td></td><td><?php echo $nama_pegawai;?></td>
</tr>
</table>