<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>PEJABAT PENILAI</b></div>
			<div class="panel-body">
								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=(trim($pegawai_info->gelar_depan) != '-')?trim($pegawai_info->gelar_depan).' ':'';?><?=(trim($pegawai_info->gelar_nonakademis) != '-')?trim($pegawai_info->gelar_nonakademis).' ':'';?><?=$pegawai_info->nama_pegawai;?><?=(trim($pegawai_info->gelar_belakang) != '-')?', '.trim($pegawai_info->gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><?=$pegawai_info->nip_baru;?></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$pegawai_info->nama_pangkat." / ".$pegawai_info->nama_golongan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$pegawai_info->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Unit kerja</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$pegawai_info->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">&nbsp;</div>
</div>
<!-- /.row -->
<div id="grid-data">
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
<table style="width:100%" class="table table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th style="width:25px;">No.</th>
<th style="width:25px;">AKSI</th>
<th style="width:300px;">TAHUN / PERIODE / TAHAPAN</th>
<th style="width:300px;">PEGAWAI YANG DINILAI</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
$bulan = $this->dropdowns->bulan();
foreach($skp AS $key=>$val){
?>
<tr id='row_<?=$val->id_skp;?>'>
<td id='nomor_<?=$val->id_skp;?>'><?=$no;?></td>
<td id='aksi_<?=$val->id_skp;?>' align=center>
	<a href="<?=site_url('appskp/skp_kelola/alih/'.$val->id_skp);?>" style="cursor:pointer;"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenu1"><i class="fa fa-binoculars fa-fw"></i></button></a>
</td>
<td id='periode_<?=$val->id_skp;?>'>
<?=$val->tahun;?><br/>
<?=$bulan[$val->bulan_mulai]." s.d. ".$bulan[$val->bulan_selesai];?><br/>
<div>
	<div style="float:left; margin-right:5px;"><?=$tahapan_skp_nomor[$val->status];?>.</div>
	<span><div style="display:table;"><?=$tahapan_skp[$val->status];?></div></span>
</div>
</td>
<td id='penilai_<?=$val->id_skp;?>'>
								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id='nama_penilai_<?=$val->id_skp;?>'><?=(trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'';?><?=(trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'';?><?=$val->nama_pegawai;?><?=(trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'';?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id='nip_penilai_<?=$val->id_skp;?>'><?=$val->nip_baru;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id='pangkat_penilai_<?=$val->id_skp;?>'><?=$val->nama_pangkat." / ".$val->nama_golongan;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;" id='jabatan_penilai_<?=$val->id_skp;?>'><?=$val->nomenklatur_jabatan;?></div></span>
								</div>
</td>
</tr>
<?php
$no++;
}
if($no==1){
?>
<tr>
<td colspan=7 align="center">Tidak Ada Pengajuan Target Kinerja</td>
</tr>
<?php
}
?>
</table>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.grid-data -->
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>