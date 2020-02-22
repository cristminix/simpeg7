<div id="grid-data">
		<div class="table-responsive">
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
	<td style="padding:0px;">
			<input type="text" id="ipt_pelayanan" data-ipt="pelayanan" class="form-control rel" placeholder="Masukkan angka" data-lama="<?=(isset($perilaku->pelayanan))?$perilaku->pelayanan:"";?>" value="<?=(isset($perilaku->pelayanan))?$perilaku->pelayanan:"";?>">
	</td>
	<td id='kat_pelayanan'><?=(isset($perilaku->kat_pelayanan))?$perilaku->kat_pelayanan:"--";?></td>
</tr>
<tr>
	<td>2</td>
	<td>Integritas</td>
	<td style="padding:0px;">
			<input type="text" id="ipt_integritas" data-ipt="integritas" class="form-control rel" placeholder="Masukkan angka" data-lama="<?=(isset($perilaku->integritas))?$perilaku->integritas:"";?>" value="<?=(isset($perilaku->integritas))?$perilaku->integritas:"";?>">
	</td>
	<td id='kat_integritas'><?=(isset($perilaku->kat_integritas))?$perilaku->kat_integritas:"--";?></td>
</tr>
<tr>
	<td>3</td>
	<td>Komitmen</td>
	<td style="padding:0px;">
			<input type="text" id="ipt_komitmen" data-ipt="komitmen" class="form-control rel" placeholder="Masukkan angka" data-lama="<?=(isset($perilaku->komitmen))?$perilaku->komitmen:"";?>" value="<?=(isset($perilaku->komitmen))?$perilaku->komitmen:"";?>">
	</td>
	<td id='kat_komitmen'><?=(isset($perilaku->kat_komitmen))?$perilaku->kat_komitmen:"--";?></td>
</tr>
<tr>
	<td>4</td>
	<td>Disiplin</td>
	<td style="padding:0px;">
			<input type="text" id="ipt_disiplin" data-ipt="disiplin" class="form-control rel" placeholder="Masukkan angka" data-lama="<?=(isset($perilaku->disiplin))?$perilaku->disiplin:"";?>" value="<?=(isset($perilaku->disiplin))?$perilaku->disiplin:"";?>">
	</td>
	<td id='kat_disiplin'><?=(isset($perilaku->kat_disiplin))?$perilaku->kat_disiplin:"--";?></td>
</tr>
<tr>
	<td>5</td>
	<td>Kerjasama</td>
	<td style="padding:0px;">
			<input type="text" id="ipt_kerjasama" data-ipt="kerjasama" class="form-control rel" placeholder="Masukkan angka" data-lama="<?=(isset($perilaku->kerjasama))?$perilaku->kerjasama:"";?>" value="<?=(isset($perilaku->kerjasama))?$perilaku->kerjasama:"";?>">
	</td>
	<td id='kat_kerjasama'><?=(isset($perilaku->kat_kerjasama))?$perilaku->kat_kerjasama:"--";?></td>
</tr>
<tr>
	<td>6</td>
	<td>Kepemimpinan</td>
	<td style="padding:0px;">
			<input type="text" id="ipt_kepemimpinan" data-ipt="kepemimpinan" class="form-control rel" placeholder="Masukkan angka" data-lama="<?=(isset($perilaku->kepemimpinan))?$perilaku->kepemimpinan:"";?>" value="<?=(isset($perilaku->kepemimpinan))?$perilaku->kepemimpinan:"";?>">
	</td>
	<td id='kat_kepemimpinan'><?=(isset($perilaku->kat_kepemimpinan))?$perilaku->kat_kepemimpinan:"--";?></td>
</tr>
<tr>
	<td align=right colspan=2>Jumlah</td>
	<td id='jumlah'><?=$jumlah;?></td>
	<td>&nbsp;</td>
</tr>
<tr id='row_'>
	<td align=right colspan=2>Nilai rata-rata</td>
	<td id='rerata'><?=$rerata;?></td>
	<td id='kat_rerata'><?=$kat_rerata;?></td>
</tr>
<tr id='row_'>
	<td align=right colspan=2>Nilai Perilaku Kerja</td>
	<td><div  id='nilai_perilaku' style="font-weight:bold;"><?=$nilai_perilaku;?></div></td>
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
.rel	{	width:100%;height:36px;border:none; background-color:#FFFF99;	}
</style>