  <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<i class="fa fa-edit fa-fw"></i> <b>Form Setup User SKP</b>
								</div>
								<!--//col-lg-6-->
								<div class="col-lg-6">
									<div class="btn-group pull-right">
									<button class="btn btn-primary btn-xs" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-6-->
						</div>
						<!--//row-->
			</div>
			<div class="panel-body" style="padding-left:5px;padding-right:5px;">


<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default" style="margin-bottom:5px;" id="panel_pegawai">
			<div class="panel-heading">
				<span class="fa fa-user fa-fw"></span>
				<span id=judul_box_pegawai><b>IDENTITAS PEGAWAI PEGAWAI</b></span>
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:90px;">Nama</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=(trim($pegawai->gelar_depan) != '-')?trim($pegawai->gelar_depan).' ':'';?><?=(trim($pegawai->gelar_nonakademis) != '-')?trim($pegawai->gelar_nonakademis).' ':'';?><?=$pegawai->nama_pegawai;?><?=(trim($pegawai->gelar_belakang) != '-')?', '.trim($pegawai->gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">NIP</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=$pegawai->nip_baru;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Pangkat/Gol.</div>
										<div style="float:left; width:5px;">:</div>
										<div style="float:left;" id="pegawai_pangkat"><?=$pegawai->nama_pangkat." / ".$pegawai->nama_golongan;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Jabatan</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="pegawai_jabatan"><?=$pegawai->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Unit kerja</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="pegawai_unor"><?=$pegawai->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->


	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-plug fa-fw"></i><b> Form Setup User SKP</b></div>
			<div class="panel-body">
<form id="pw-form" method="post" action="<?=site_url('appbkpp/pegawai/formuserskp_aksi');?>" enctype="multipart/form-data">
<input type="hidden" name="nama" value="<?=$pegawai->nama_pegawai;?>">
<input type="hidden" name="id_pegawai" value="<?=$pegawai->id_pegawai;?>">
<table>
<tr>
<td style="width:140px;">Username</td>
<td style="text-align:center;width:10px;">:</td>
<td><input type=text class="form-control" name="username" value="<?=$pegawai->nip_baru;?>"></td>
</tr>
<tr>
<td style="width:140px;">Password</td>
<td style="text-align:center;width:10px;">:</td>
<td><input type=password class="form-control"  name="password" value="<?=$pegawai->nip_baru;?>"></td>
</tr>
<tr>
<td colspan=2>&nbsp;</td>
<td style="padding-top:10px;">
<div class="btn btn-primary bt_simpan" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Simpan</div>
<div class="btn btn-default" onclick="batal();"><i class="fa fa-close fa-fw"></i> Batal...</div>
</td>
</tr>
</table>
</form>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>

</div>
<!-- /.row -->

<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function simpan(){
	$.ajax({
		type:"POST",
		url: $("#pw-form").attr('action'),
		data: $("#pw-form").serialize(),
		beforeSend:function(){	
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
		},
		success:function(data){
			batal();
		}, // end success
		dataType:"html"}); // end ajax
}
//////////////////////////////////////////////////////////////////////////
</script>

