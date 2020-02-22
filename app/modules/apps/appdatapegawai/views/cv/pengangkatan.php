	<table width="680" border="1">
		<tr width="680" style="background-color:yellow;">
			<th width="340" align="center">CPNS</th>
			<th width="340" align="center">PNS</th>
		</tr><tr>
		<td valign="top">
			<table>
				<tr>
					<td>Pejabat Penetap</td><td width="5">:</td>
					<td><?=$data['cpns']->sk_cpns_pejabat;?></td>
				</tr><tr>
					<td>No. SK</td><td>:</td>
					<td><?=$data['cpns']->sk_cpns_nomor;?></td>
				</tr><tr>
					<td>Tgl. SK</td><td>:</td>
					<td><?=$data['cpns']->sk_cpns_tgl;?></td>
				</tr><tr>
					<td>TMT CPNS</td><td>:</td>
					<td><?=$data['cpns']->tmt_cpns;?></td>
				</tr><tr>
					<td>Masa Kerja</td><td>:</td>
					<td><?=$data['cpns']->mk_th.' tahun '.$data['cpns']->mk_bl.' bulan';?></td>
				</tr>
			</table>
		</td>
		<td valign="top">
			<table>
				<tr>
					<td>Pejabat Penetap</td><td width="5">:</td>
					<td><?=$data['pns']->sk_pns_pejabat;?></td>
				</tr><tr>
					<td>No. SK</td><td>:</td>
					<td><?=$data['pns']->sk_pns_nomor;?></td>
				</tr><tr>
					<td>Tgl. SK</td><td>:</td>
					<td><?=$data['pns']->sk_pns_tanggal;?></td>
				</tr><tr>
					<td>TMT PNS</td><td>:</td>
					<td><?=$data['pns']->tmt_pns;?></td>
				</tr>
			</table>
		</td>
		</tr>
	</table>
