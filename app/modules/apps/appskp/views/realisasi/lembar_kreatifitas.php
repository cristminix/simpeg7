<div id="grid-data">
		<div class="table-responsive">
<form id="kreatifitas-form" method="post" enctype="multipart/form-data">
<table  style="width:1024px;" class="table table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th style="width:45px;">No.</th>
<th style="width:55px;">AKSI</th>
<th style="width:200px;">KARYA KREATIFITAS</th>
<th style="width:200px;" align=center>NOMOR SURAT KEPUTUSAN</th>
<th style="width:100px;">TANGGAL</th>
<th style="width:250px;" align=center>PENANDATANGAN SURAT KEPUTUSAN</th>
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
		<button class="btn btn-danger dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_kreatifitas;?>" data-toggle="dropdown"><i class="fa fa-exclamation fa-fw"></i></button>
	<?php
	}
	elseif($val->icon=="acc")
	{
	?>
		<button class="btn btn-success dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_kreatifitas;?>" data-toggle="dropdown"><i class="fa fa-check fa-fw"></i></button>
	<?php
	}
	else
	{
	?>
		<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_kreatifitas;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
	<?php
	}
	?>
		<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu<?=$val->id_kreatifitas;?>">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('editpoint','<?=$val->id_kreatifitas;?>','kreatifitas','edit');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_kreatifitas;?>','kreatifitas','hapus');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_kreatifitas;?>','kreatifitas','komentar');"><i class="fa fa-exclamation fa-fw"></i>Lihat komentar</a></li>
		</ul>
	</div>
</td>
<td><?=$val->kreatifitas;?></td>
<td><?=$val->no_sk;?></td>
<td>
<?php
date_default_timezone_set('UTC');
echo date("d-m-Y", strtotime($val->tanggal_sk));
?>
</td>
<td><?=$val->penandatangan_sk;?></td>
</tr>
<?php
$no++;
}
?>
<tr id='row_cc'>
<td id='nomor_cc'><?=$no;?></td>
<td id='aksi_cc' align=center>...</td>
<td id='pekerjaan_cc'>
<button class="btn tambah btn-primary btn-xs" type="button" data-nomor="<?=($no);?>" data-form="kreatifitas" data-ini='cc' id='btn_cc'><i class="fa fa-plus fa-fw"></i> Tambah kreatifitas...</button>
</td>
<td id='ak_cc'>...</td>
<td id='volume_cc'>...</td>
<td id='satuan_cc'>...</td>
</tr>
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