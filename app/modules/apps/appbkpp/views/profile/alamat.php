<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-home fa-fw"></i> Data Alamat Pegawai
			</div>
			<div class="panel-body">
				<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Jalan</label>
								<?=form_input('jalan',$data->jalan,'class="form-control" disabled=""');?>
							</div>
							 <div class="form-group">
								<label>RT</label>
								<?=form_input('rt',$data->rt,'class="form-control" disabled=""');?>
							</div>
							 <div class="form-group">
								<label>RW</label>
								<?=form_input('rw',$data->rw,'class="form-control" disabled=""');?>
							</div>
							 <div class="form-group">
								<label>Kelurahan / Desa</label>
								<?=form_input('kel_desa',$data->kel_desa,'class="form-control" disabled=""');?>
							</div>
							<div class="form-group">
								<label>Kecamatan</label>
								<?=form_input('kecamatan',$data->kecamatan,'class="form-control" disabled=""');?>
							</div>
						</div>
						<!-- /.col-lg-6 (nested) -->
						<div class="col-lg-6">
								<div class="form-group">
									<label>Kab. / Kota</label>
									<?=form_input('kab_kota',$data->kab_kota,'class="form-control" disabled=""');?>
								</div>
								<div class="form-group">
									<label>Propinsi</label>
									<?=form_input('propinsi',$data->propinsi,'class="form-control" disabled=""');?>
								</div>
								<div class="form-group">
									<label>Kode Pos</label>
									<?=form_input('kode_pos',$data->kode_pos,'class="form-control" disabled=""');?>
								</div>
								<label>Jarak Tempuh Rumah-Kantor</label>
								<div class="form-group input-group">
									<span class="input-group-addon">km</span>
									<?=form_input('jarak_meter',$data->jarak_meter,'class="form-control" disabled=""');?>
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon">menit</span>
									<?=form_input('jarak_menit',$data->jarak_menit,'class="form-control" disabled=""');?>
								</div>
						</div>
						<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
