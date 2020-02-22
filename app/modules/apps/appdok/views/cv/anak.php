<?php $arrGender = array('l'=>'Laki-laki','p'=>"Perempuan");?>
<?php	if(count(@$data) > 0):?>
		<table border="1" width="680">
			<tr align="center"  width="680" style="background-color:#c8ecf8;">
				<th width="20">No.</th>
				<th>Nama</th>
				<th>TTL</th>
				<th>Jenis Kelamin<br/>Status Anak</th>
				<th>Pendidikan<br/>Pekerjaan</th>
				<th>Tunjangan</th>
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowAnak):?>
			<tr>
				<td align="center"><?=$urut++;?></td>
				<td align="center"><?=@$rowAnak->nama_anak;?></td>
				<td align="center"><?=@$rowAnak->tempat_lahir_anak;?> / <?=@$rowAnak->tanggal_lahir_anak;?></td>
				<td align="center"><?=@$arrGender[$rowAnak->gender_anak].'<br/>'.@$rowAnak->status_anak;?></td>
				<td align="center"><?=@$rowAnak->pendidikan_anak.'<br/>'.@$rowAnak->pekerjaan_anak;?></td>
				<td align="center"><?=@$rowAnak->keterangan_tunjangan;?></td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
