		<table border="1" width="680">
			<tr align="center"  width="680" style="background-color:#c8ecf8;">
				<th width="20">No.</th>
				<th>Nama</th>
				<th>TTL</th>
				<th>Pendidikan<br/>Pekerjaan</th>
				<th>Tgl Menikah</th>
			</tr>
<?php		$urut=1;?>
<?php		foreach($data as $rowPerk):?>
			<tr>
				<td align="center"><?=$urut++;?></td>
				<td align="center"><?=$rowPerk->nama_suris;?></td>
				<td align="center"><?=$rowPerk->tempat_lahir_suris;?> / <?=$rowPerk->tanggal_lahir_suris;?></td>
				<td align="center"><?=$rowPerk->pendidikan_suris.'<br/>'.$rowPerk->pekerjaan_suris;?></td>
				<td align="center"><?=$rowPerk->tanggal_menikah.'<br/>'.$rowPerk->keterangan;?></td>
			</tr>
<?php		endforeach;?>
		</table>
