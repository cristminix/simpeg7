<?php	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:#c8ecf8;">
				<th width="20"  align="center" valign="middle">No.</th>
				<th>Perusahaan</th>
				<th>Pekerjaan</th>
				<th>Tgl. Awal<br/>Tgl. Akhir</th>
				<th>Jabatan</th>
				
				
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowPkt):?>
			<tr>
				<td  align="center"><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->perusahaan;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->pekerjaan;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->tanggal_awal;?><br/>
					<?=$rowPkt->tanggal_akhir;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->jabatan;?>
				</td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
