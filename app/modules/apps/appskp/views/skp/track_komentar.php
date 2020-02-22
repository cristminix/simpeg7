<td colspan=10>
		<div class="table-responsive" style="margin:0px;padding:0px">
<table width="100%" class="table table-striped table-bordered table-hover" style="background-color:#ffffff;margin:0px;">
	<thead id=gridhead>
		<tr height=20>
			<th width=75>No.</th>
			<th width=450>KOMENTAR</th>
			<th align=center>PEMBERI KOMENTAR</th>
			<th width=160>JEJAK WAKTU</th>
		</tr>
	</thead>
	<tbody>
<?php
$i = 1;
foreach($komentar AS $key=>$val){
?>
		<tr>
			<td><?=$i;?>.</td>
			<td><?=$val->komentar;?></td>
			<td>..</td>
			<td>..</td>
		</tr>
<?php
$i++;
}
if($i==1){
?>
		<tr>
			<td colspan=4><p align="center">TIDAK ADA KOMENTAR UNTUK KEGIATAN INI</p></td>
		</tr>
<?php
}
?>
	<tr>
	<td colspan=4><button class="btn batal btn-primary btn-xs" onclick="tutup_track();" type="button"><i class="fa fa-close"></i> Tutup</button></td>
	</tr>
	</tbody>
</table>
		</div>
		<!-- table-responsive --->
</td>
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>