<div id="grid-data">
		<div class="table-responsive">
<form id="tugas_tambahan-form" method="post" enctype="multipart/form-data">
<table width="100%" class="table info table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th width=25>No.</th>
<th width=35>AKSI</th>
<th width=400>KEGIATAN TUGAS TAMBAHAN</th>
<th align=center>NOMOR SURAT PERINTAH</th>
<th width=150>TANGGAL</th>
<th align=center>PEJABAT PEMBERI PERINTAH</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach($ttambahan AS $key=>$val)
{
?>
<tr id='row_tugas_tambahan_<?=$val->id_tambahan;?>'>
<td id='nomor_tugas_tambahan_<?=$val->id_tambahan;?>'><?=$no;?></td>
<td id='aksi_tugas_tambahan_<?=$val->id_tambahan;?>' align=center>
	<div class="dropdown" id="btMenu<?=$val->id_tambahan;?>">
	<?php
	if($val->icon=="pentung")
	{
	?>
		<button class="btn btn-danger dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_tambahan;?>" data-toggle="dropdown"><i class="fa fa-exclamation fa-fw"></i></button>
	<?php
	}
	elseif($val->icon=="acc")
	{
	?>
		<button class="btn btn-success dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_tambahan;?>" data-toggle="dropdown"><i class="fa fa-check fa-fw"></i></button>
	<?php
	}
	else
	{
	?>
		<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_tambahan;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
	<?php
	}
	?>
		<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu<?=$val->id_tambahan;?>">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('editpoint','<?=$val->id_tambahan;?>','tugas_tambahan','edit');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_tambahan;?>','tugas_tambahan','hapus');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_tambahan;?>','tugas_tambahan','komentar');"><i class="fa fa-exclamation fa-fw"></i>Lihat komentar</a></li>
		</ul>
	</div>
</td>
<td><?=$val->pekerjaan;?></td>
<td><?=$val->no_sp;?></td>
<td>
<?php
date_default_timezone_set('UTC');
echo date("d-m-Y", strtotime($val->tanggal_sp));
?>
</td>
<td><?=$val->penandatangan_sp;?></td>
</tr>
<?php
$no++;
}
?>
<tr id='row_xx'>
<td id='nomor_xx'><?=$no;?></td>
<td id='aksi_xx' align=center>...</td>
<td id='pekerjaan_xx'>
<button class="btn tambah btn-primary btn-xs" type="button" data-nomor="<?=($no);?>" data-form="tugas_tambahan" data-ini="xx" id="btn_xx"><i class="fa fa-plus fa-fw"></i> Tambah kegiatan...</button>
</td>
<td>...</td>
<td>...</td>
<td>...</td>
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