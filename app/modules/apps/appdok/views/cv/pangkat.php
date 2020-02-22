<?php	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:#c8ecf8;">
				<th width="20">No.</th>
				<th>Gol./Pangkat</th>
				<th>TMT Pangkat</th>
				<th>No. SK<br/>Tgl. SK</th>
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowPkt):?>
			<tr>
				<td  align="center"><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->nama_golongan.' / '.$rowPkt->nama_pangkat;?><br/>
				</td>
				<td align="center">
					
				<?=$rowPkt->tmt_golongan;?> 
				</td>
				<td align="center">
					<?=$rowPkt->sk_nomor;?><br/>
					<?=$rowPkt->sk_tanggal;?>
				</td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
