<?	if(count($data) > 0):?>
		<table width="600">
			<tr>
				<td width="200">Jalan</td><td width="5">:</td>
				<td width="300"><?=$data->jalan;?></td>
			</tr><tr>
				<td>RT/RW</td><td>:</td>
				<td><?=$data->rt.'/'.$data->rw;?></td>
			</tr><tr>
				<td>Kel/Desa</td><td>:</td>
				<td><?=$data->kel_desa;?></td>
			</tr><tr>
				<td>Kecamatan</td><td>:</td>
				<td><?=$data->kecamatan;?></td>
			</tr><tr>
				<td>Kab./Kota</td><td>:</td>
				<td><?=$data->kab_kota;?></td>
			</tr><tr>
				<td>Propinsi</td><td>:</td>
				<td><?=$data->propinsi;?></td>
			</tr><tr>
				<td>Kode Pos</td><td>:</td>
				<td><?=$data->kode_pos;?></td>
			</tr><tr>
				<td>Tlp. Rumah</td><td>:</td>
				<td><?=$data->telepon_rumah;?></td>
			</tr><tr>
				<td>Tlp. Genggam</td><td>:</td>
				<td><?=$data->telepon_genggam;?></td>
			</tr><tr>
				<td>Jarak Tempuh/Waktu Tempuh</td><td>:</td>
				<td><?=$data->jarak_meter.' km / '.$data->jarak_menit.' menit';?></td>

			</tr>
		</table>
<?	else:?>
	-
<?	endif;?>
