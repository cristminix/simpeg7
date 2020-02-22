	<div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
		<div class="panel panel-warning" style="margin:8px;">
			<div class="panel-heading">
			<b>Daftar Tahapan Penyusunan SKP</b>
			<button class="close" onclick="tutup_track();" type="button"><i class="fa fa-close"></i></button>
			</div>
			<div class="panel-body">

		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="background-color:#ffffff;">
<thead id=gridhead>
<tr height=20>
<th width=75>No.</th>
<th width=45>ST</th>
<th width=450>TAHAPAN</th>
<th align=center>PELAKSANA</th>
<th width=170>JEJAK WAKTU</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
foreach($tahapan_skp AS $key=>$val){
?>
	<tr>
	<td><?=$i;?>.</td>
	<td>
	<?php
		if($i<$tahapan_skp_nomor){
	?>
	<button class="btn btn-success btn-xs" type="button"><span class="fa fa-check fa-fw"></span></button>
	<?php
	} elseif($i==$tahapan_skp_nomor) {
	?>
	<button class="btn btn-warning btn-xs" type="button"><span class="fa fa-caret-right fa-fw"></span></button>
	<?php
	} else {
	?>
	...
	<?php
	}
	?>
	</td>
	<td><?=$val;?></td>
	<td><?=$tahapan_skp_pelaku[$key];?></td>
	<td align="center"><?=$skp->$key;?></td>
	</tr>
<?php
$i++;
}
?>
</tbody>
</table>
		</div>
		<!-- table-responsive --->
		<button class="btn btn-default" onclick="tutup_track();" type="button"><i class="fa fa-close fa=fw"></i> Tutup...</button>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel default -->
	</div>
	<!-- /.col-lg-12 -->
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>