<?php	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:#c8ecf8;">
				<th width="20">No.</th>
				<th>UNIT KERJA</th>
				<th>TMT Jabatan <br/>Nama Jabatan </th>
				<th>No. SK<br/>Tgl. SK<br/>Penandatangan SK</th>
				
			</tr>
<?php		$urut=1;?>
<?php		foreach(@$data as $rowPkt):?>
			<tr>
				<td  align="center"><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->nama_unor;?><br/>
					pada<br/>
					<?=$rowPkt->nomenklatur_pada;?>
				</td>
				
				<td align="center">
					<?=$rowPkt->tmt_jabatan;?><br/>
					<?=$rowPkt->nama_jabatan;?><br/>
				</td>
				
				
				<td align="center">
				<?=$rowPkt->sk_nomor;?> <br/>
					<?=$rowPkt->sk_tanggal;?><br/>
					<?=$rowPkt->sk_pejabat;?>
				</td>
			</tr>
<?php		endforeach;?>
		</table>
<?php	else:?>
		Tidak Ada Data untuk ditampilkan
<?php	endif;?>
