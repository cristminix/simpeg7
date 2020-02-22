				<table width="410">
					<tr>
						<td width="100">Nama Lengkap</td><td width="5">:</td>
						<td width="310"><?=$data->nama_pegawai;?></td>
					</tr><tr>
						<td>NIP</td><td>:</td>
						<td><?=$data->nip_baru;?></td>
					</tr><tr>
						<td>Gol. Ruang/Pangkat</td><td>:</td>
						<td><?=$data->nama_golongan.' / '.$data->nama_pangkat;?></td>
					</tr><tr>
						<td>TMT Pangkat</td><td>:</td>
						<td><?=$data->tmt_pangkat;?></td>
					</tr><tr>
						<td>Jabatan</td><td>:</td>
						<td><?=$data->nomenklatur_jabatan;?></td>
					</tr><tr>
						<td>Unit Kerja</td><td>:</td>
						<td><?=$data->nomenklatur_pada;?></td>
					</tr>
				</table>