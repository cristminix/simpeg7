<?php	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:#c8ecf8;">
				<th width="20"  align="center" valign="middle">No.</th>
				<th>Tgl. Mulai<br/>Tgl. Selesai</th>
				<th>Nama Diklat</th>
				<th>Tempat</th>
				<th>No. SK<br/>Tgl. SK<br/>Jenis Diklat<br/></th>
				
				
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowPkt):?>
			<tr>
				<td  align="center"><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->tanggal_mulai;?><br/>
					<?=$rowPkt->tanggal_selesai;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->nama_diklat;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->tempat_diklat;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->nomor_sk;?><br/>
					<?=$rowPkt->tanggal_sk;?><br/>
					<?=$rowPkt->jenis_diklat;?>
				</td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
