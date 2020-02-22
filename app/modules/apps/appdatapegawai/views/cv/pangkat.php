<?	if(count(@$data) > 0):?>
		<table border="1" width="850">
			<tr align="center"  width="850" style="background-color:yellow;">
				<th width="20">No.</th>
				<th>Gol./Pangkat<br/>TMT Pangkat</th>
				<th>Angka Kredit Utama / Tambahan</th>
				<th>No. SK<br/>Tgl. SK</th>
			</tr>
<?		$urut=1;?>
<?		foreach(@$data as $rowPkt):?>
			<tr>
				<td><?=$urut++;?></td>
				<td align="center">
					<?=$rowPkt->nama_golongan.' / '.$rowPkt->nama_pangkat;?><br/>
					<?=$rowPkt->tmt_golongan;?>
				</td>
				<td align="center">
					
				<?=$rowPkt->kredit_utama;?> / <?=$rowPkt->kredit_tambahan;?>
				</td>
				<td align="center">
					<?=$rowPkt->sk_nomor;?><br/>
					<?=$rowPkt->sk_tanggal;?>
				</td>
			</tr>
<?		endforeach;?>
		</table>
<?	else:?>
		Tidak Ada Data untuk ditampilkan
<?	endif;?>
