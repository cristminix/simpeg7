		<table border="1" width="800">
			<tr align="center"  width="800" style="background-color:yellow;">
				<th width="20">No.</th>
				<th>Jenjang</th>
				<th>Jurusan</th>
				<th>Nama Sekolah<br/>Lokasi</th>
				<th>No.STTB<br/>Tgl. Lulus</th>
			</tr>
<?		$urut=1;?>
<?		foreach($data as $rowPend):?>
			<tr>
				<td><?=$urut++;?></td>
				<td align="center"><?=$rowPend->nama_jenjang;?></td>
				<td align="center"><?=$rowPend->nama_pendidikan;?></td>
				<td align="center"><?=$rowPend->nama_sekolah.'<br/>'.$rowPend->lokasi_sekolah;?></td>
				<td align="center"><?=$rowPend->nomor_ijazah.'<br/>'.$rowPend->tanggal_lulus;?></td>
			</tr>
<?		endforeach;?>
		</table>
