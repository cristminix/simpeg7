<div id="grid-data">
		<div class="table-responsive">
<form id="kreatifitas-form" method="post" enctype="multipart/form-data">
<table width="100%" class="table info table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th width=25>No.</th>
<th width=35>AKSI</th>
<th width=400>KARYA KREATIFITAS</th>
<th align=center>NOMOR SURAT KEPUTUSAN</th>
<th align=center>TANGGAL</th>
<th align=center>PENANDATANGAN SURAT KEPUTUSAN</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach($kreatifitas AS $key=>$val)
{
?>
<tr id='row_kreatifitas_<?=$val->id_kreatifitas;?>'>
<td id='nomor_kreatifitas_<?=$val->id_kreatifitas;?>'><?=$no;?></td>
<td id='aksi_kreatifitas_<?=$val->id_kreatifitas;?>' align=center>
	<div class="dropdown" id="btMenu<?=$val->id_kreatifitas;?>">
	<?php
	if($val->icon=="pentung")
	{
	?>
		<button class="btn btn-danger dropdown-toggle btn-xs" type="button" id="dd_kreatifitas_<?=$val->id_kreatifitas;?>" data-toggle="dropdown"><i class="fa fa-exclamation fa-fw"></i></button>
	<?php
	}
	elseif($val->icon=="acc")
	{
	?>
		<button class="btn btn-success dropdown-toggle btn-xs" type="button" id="dd_kreatifitas_<?=$val->id_kreatifitas;?>" data-toggle="dropdown"><i class="fa fa-check fa-fw"></i></button>
	<?php
	}
	else
	{
	?>
		<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dd_kreatifitas_<?=$val->id_kreatifitas;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
	<?php
	}
	?>
		<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu<?=$val->id_kreatifitas;?>">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_kreatifitas;?>','kreatifitas','acc');"><i class="fa fa-check fa-fw"></i>ACC Karya Kreatifitas</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_kreatifitas;?>','kreatifitas','koreksi');"><i class="fa fa-edit fa-fw"></i>Koreksi Karya Kreatifitas, dan beri komentar</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_kreatifitas;?>','kreatifitas','komentar');"><i class="fa fa-comment fa-fw"></i>Lihat komentar</a></li>
		</ul>
	</div>
</td>
<td><?=$val->kreatifitas;?></td>
<td><?=$val->no_sk;?></td>
<td><?=$val->tanggal_sk;?></td>
<td><?=$val->penandatangan_sk;?></td>
</tr>
<?php
$no++;
}
if($no==1){
?>
<tr>
<td colspan=8 align=center>Tidak Ada Data</td>
</tr>
<?php
}
?>
</tbody>
</table>
</form>
		</div>
		<!-- table-responsive --->
</div>
<!-- /.grid-data -->
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>