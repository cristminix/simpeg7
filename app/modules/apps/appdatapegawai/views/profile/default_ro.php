<?php $arGender = $this->dropdowns->gender();?>
<?php $arAgama = $this->dropdowns->agama();?>
<?php $arStatusPegawai = $this->dropdowns->status_pegawai();?>
<?php $arKelompokPegawai = $this->dropdowns->kelompok_pegawai();?>
<?php $arMarital = $this->dropdowns->status_perkawinan();?>
<input id="id_pegawai" type="hidden" value="<?php echo $id_pegawai;?>" name="id_pegawai">
<br/>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-user fa-fw"></i> Data Utama
       <!--  <button type="button" class="btn btn-primary btn-xs pull-right" onclick="viewTabPegawai('utama','dropdown11');return false;"
        title="Edit Data Utama">
          <i class="fa fa-edit"></i>
        </button> -->
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<dl class="dl-horizontal">
				  <dt>Nama Lengkap</dt>
				  <dd><?=(trim($data->gelar_nonakademis) != '-')?trim($data->gelar_nonakademis).' ':'';?><?=(trim($data->gelar_depan) != '-')?trim($data->gelar_depan).' ':'';?><?=trim($data->nama_pegawai);?><?=(trim($data->gelar_belakang) != '-')?', '.trim($data->gelar_belakang):'';?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Jenis Kelamin</dt>
				  <dd><?php echo $arGender[$data->gender];?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Gelar Non Akademis</dt>
				  <dd><?php echo $data->gelar_nonakademis;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Gelar Depan</dt>
				  <dd><?php echo $data->gelar_depan;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Gelar Belakang</dt>
				  <dd><?php echo $data->gelar_belakang;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>NIP</dt>
				  <dd><?php echo $data->nip_baru;?></dd>
				</dl>			
				
				<dl class="dl-horizontal">
				  <dt>Tempat Lahir</dt>
				  <dd><?php echo $data->tempat_lahir;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Tanggal Lahir</dt>
				  <dd><?php echo $data->tanggal_lahir;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Agama</dt>
				  <dd><?php echo $arAgama[$data->agama];?></dd>
				</dl>		
				<dl class="dl-horizontal">
				  <dt>Status Pegawai</dt>
				  <dd><?php echo $arStatusPegawai[$data->status_pegawai];?></dd>
				</dl>	
			<dl class="dl-horizontal">
				  <dt>Kelompok Pegawai</dt>
				  <dd><?php echo $arKelompokPegawai[$data->kelompok_pegawai];?></dd>
				</dl>					
				<dl class="dl-horizontal">
				  <dt>Status Perkawinan</dt>
				  <dd><?php echo $arMarital[$data->status_perkawinan];?></dd>
				</dl>	
				<dl class="dl-horizontal">
				  <dt>Golongan Darah</dt>
				  <dd><?php echo $data->gol_darah; ?></dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Nomor HP</dt>
				  <dd><?php echo $data->nomor_hp; ?></dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Nomor Telp. Rumah</dt>
				  <dd><?php echo $data->nomor_tlp_rumah; ?></dd>
				</dl>		
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-tasks fa-fw"></i> Jabatan
        <!-- <button type="button" class="btn btn-success btn-xs pull-right" onclick="viewTabPegawai('utama','dropdown24');return false;"
        title="Edit Data Jabatan">
          <i class="fa fa-edit"></i>
        </button> -->
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">TMT Jabatan</label>
						<div class="col-sm-9">
						  <p class="form-control-static"><?php echo $data->tmt_jabatan;?></p>
						</div>
						<!-- /.col-sm-9 -->
					</div>
					<!-- /.form-group -->
				</form>
				<!-- /.form-horizontal -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-8 -->
	<div class="col-lg-4">
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-file-picture-o fa-fw"></i> Foto Pegawai
       <!--  <button type="button" class="btn btn-success btn-xs pull-right" onclick="return false;"
        title="Upload Foto Pegawai">
          <i class="fa fa-upload"></i>
        </button> -->
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<img src="<?php echo $fotoSrc;?>" alt="Foto Pegawai" class="img-responsive img-thumbnail">
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		
		<!-- /.panel -->
	
		<!-- /.panel -->
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-sort-amount-desc fa-fw"></i> Kepangkatan
       <!--  <button type="button" class="btn btn-success btn-xs pull-right" onclick="viewTabPegawai('utama','dropdown23');return false;"
        title="Edit Data Kepangkatan Pegawai">
          <i class="fa fa-edit"></i>
        </button> -->
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-4 control-label">Pangkat</label>
						<div class="col-sm-8">
						  <p class="form-control-static"><?php echo $data->nama_pangkat;?></p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-4 control-label">Golongan</label>
						<div class="col-sm-8">
						  <p class="form-control-static"><?php echo $data->nama_golongan;?></p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-5 control-label">TMT Pangkat</label>
						<div class="col-sm-7">
						  <p class="form-control-static"><?php echo $data->tmt_pangkat;?></p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
				</form>
				<!-- /.form-horizontal -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-4 -->
</div>
<!-- /.row -->
<script type="text/javascript">
jQuery(document).ready(function() { 
	$('#subtext-pegawai').html('<?php echo $data->nama_pegawai;?>')
});
</script>
