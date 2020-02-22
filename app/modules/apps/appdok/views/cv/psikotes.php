<?php	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:#c8ecf8;">
				<th width="20"  align="center" valign="middle">No.</th>
				<th>Tgl. Tes</th>
				<th>Tempat</th>
				<th>Hasil</th>
				
				
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowPkt):?>
			<tr>
				<td  align="center"><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->tanggal_tes;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->tempat;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->hasil;?>
				</td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
