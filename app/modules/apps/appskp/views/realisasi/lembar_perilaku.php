<div id="grid-data">
		<div class="table-responsive">
<div style="font-weight:bold; color:#FF0000;">Diisi oleh Pejabat Penilai</div>
<table style="width:600px;" class="table info table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th width=25>No.</th>
<th>USUR PENILAIAN</th>
<th width=156>NILAI</th>
<th width=150>KATEGORI</th>
</tr>
</thead>
<tbody>
<tr>
	<td>1</td>
	<td>Orientasi pelayanan</td>
	<td><?=(isset($perilaku->pelayanan))?$perilaku->pelayanan:"--";?></td>
	<td><?=(isset($perilaku->kat_pelayanan))?$perilaku->kat_pelayanan:"--";?></td>
</tr>
<tr>
	<td>2</td>
	<td>Integritas</td>
	<td><?=(isset($perilaku->integritas))?$perilaku->integritas:"--";?></td>
	<td><?=(isset($perilaku->kat_integritas))?$perilaku->kat_integritas:"--";?></td>
</tr>
<tr>
	<td>3</td>
	<td>Komitmen</td>
	<td><?=(isset($perilaku->komitmen))?$perilaku->komitmen:"--";?></td>
	<td><?=(isset($perilaku->kat_komitmen))?$perilaku->kat_komitmen:"--";?></td>
</tr>
<tr>
	<td>4</td>
	<td>Disiplin</td>
	<td><?=(isset($perilaku->disiplin))?$perilaku->disiplin:"--";?></td>
	<td><?=(isset($perilaku->kat_disiplin))?$perilaku->kat_disiplin:"--";?></td>
</tr>
<tr>
	<td>5</td>
	<td>Kerjasama</td>
	<td><?=(isset($perilaku->kerjasama))?$perilaku->kerjasama:"--";?></td>
	<td><?=(isset($perilaku->kat_kerjasama))?$perilaku->kat_kerjasama:"--";?></td>
</tr>
<tr>
	<td>6</td>
	<td>Kepemimpinan</td>
	<td><?=(isset($perilaku->kepemimpinan))?$perilaku->kepemimpinan:"--";?></td>
	<td><?=(isset($perilaku->kat_kepemimpinan))?$perilaku->kat_kepemimpinan:"--";?></td>
</tr>
<tr>
	<td align=right colspan=2>Jumlah</td>
	<td id='jumlah'><?=(isset($jumlah))?$jumlah:"--";?></td>
	<td>&nbsp;</td>
</tr>
<tr id='row_'>
	<td align=right colspan=2>Nilai rata-rata</td>
	<td id='rerata'><?=(isset($rerata))?$rerata:"--";?></td>
	<td id='kat_rerata'><?=(isset($kat_rerata))?$kat_rerata:"--";?></td>
</tr>
<tr id='row_'>
	<td align=right colspan=2>Nilai Perilaku Kerja</td>
	<td><div  id='nilai_perilaku' style="font-weight:bold;"><?=(isset($nilai_perilaku))?$nilai_perilaku:"--";?></div></td>
	<td>&nbsp;</td>
</tr>
</table>
		</div>
		<!-- table-responsive --->
</div>
<!-- /.grid-data -->
<div id="data_ada" style="display:none"><?=$ada;?></div>
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>