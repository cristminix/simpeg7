	<table width="680" border="1">
		<tr width="680" style="background-color:#c8ecf8;">
			<th width="340" align="center">CAPEG</th>
			<th width="340" align="center">TETAP</th>
		</tr><tr>
		<td valign="top">
			<table>
				<tr>
					<td style="text-indent: 1em;">Pejabat Penetap</td><td width="5">:</td>
					<td><?=$data['capeg']->sk_pejabat;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">No. SK</td><td>:</td>
					<td><?=$data['capeg']->sk_nomor;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">Tgl. SK</td><td>:</td>
					<td><?=$data['capeg']->sk_tanggal;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">TMT CAPEG</td><td>:</td>
					<td><?=$data['capeg']->tmt_capeg;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">Masa Kerja</td><td>:</td>
					<td><?=$data['capeg']->mk_th.' tahun '.$data['capeg']->mk_bl.' bulan';?></td>
				</tr>
			</table>
		</td>
		<td valign="top">
			<table>
				<tr>
					<td style="text-indent: 1em;">Pejabat Penetap</td><td width="5">:</td>
					<td><?=$data['tetap']->sk_pejabat;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">No. SK</td><td>:</td>
					<td><?=$data['tetap']->sk_nomor;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">Tgl. SK</td><td>:</td>
					<td><?=$data['tetap']->sk_tanggal;?></td>
				</tr><tr>
					<td style="text-indent: 1em;">TMT TETAP</td><td>:</td>
					<td><?=$data['tetap']->tmt_tetap;?></td>
				</tr>
			</table>
		</td>
		</tr>
	</table>
