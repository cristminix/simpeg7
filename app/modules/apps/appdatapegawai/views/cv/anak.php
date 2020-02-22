<? $arrGender = array('l'=>'Laki-laki','p'=>"Perempuan");?>
<?	if(count(@$data) > 0):?>
		<table border="1" width="680">
			<tr align="center"  width="680" style="background-color:yellow;">
				<th width="20">No.</th>
				<th>Nama</th>
				<th>TTL</th>
				<th>Jenis Kelamin<br/>Status Anak</th>
				<th>Pendidikan<br/>Pekerjaan</th>
				<th>Tunjangan</th>
			</tr>
<?		$urut=1;?>
<?		foreach(@$data as $rowAnak):?>
			<tr>
				<td><?=$urut++;?></td>
				<td align="center"><?=@$rowAnak->nama_anak;?></td>
				<td align="center"><?=@$rowAnak->tempat_lahir_anak;?> / <?=@$rowAnak->tanggal_lahir_anak;?></td>
				<td align="center"><?=@$arrGender[$rowAnak->gender_anak].'<br/>'.@$rowAnak->status_anak;?></td>
				<td align="center"><?=@$rowAnak->pendidikan_anak.'<br/>'.@$rowAnak->pekerjaan_anak;?></td>
				<td align="center"><?=@$rowAnak->keterangan_tunjangan;?></td>
			</tr>
<?		endforeach;?>
		</table>
<?	else:?>
		Tidak Ada Data untuk ditampilkan
<?	endif;?>
