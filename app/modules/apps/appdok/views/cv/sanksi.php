<?php	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:#c8ecf8;">
				<th width="20"  align="center" valign="middle">No.</th>
				<th>No. SK<br/>Tgl. SK</th>
				<th>Uraian</th>
				
				
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowPkt):?>
			<tr>
				<td  align="center"><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->nomor_sk;?><br/>
					<?=$rowPkt->sk_tanggal;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->uraian;?>
				</td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
