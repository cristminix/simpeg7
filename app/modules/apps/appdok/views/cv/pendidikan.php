		<table border="1" width="800">
			<tr align="center"  width="800" style="background-color:#c8ecf8;">
				<th width="20">No.</th>
				<th>Jenjang</th>
				<th>Jurusan</th>
				<th>Nama Sekolah<br/>Lokasi</th>
				<th>No.STTB<br/>Tgl. Lulus</th>
			</tr>
<?php		$urut=1;?>
<?php		foreach($data as $rowPend):?>
			<tr>
				<td align="center"><?=$urut++;?></td>
				<td align="center"><?=$rowPend->nama_jenjang;?></td>
				<td align="center"><?=$rowPend->jurusan;?></td>
				<td align="center"><?=$rowPend->nama_sekolah.'<br/>'.$rowPend->lokasi_sekolah;?></td>
				<td align="center"><?=$rowPend->nomor_ijazah.'<br/>'.$rowPend->tanggal_lulus;?></td>
			</tr>
<?php		endforeach;?>
		</table>
