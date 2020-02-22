<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="fa fa-star-half-o fa-fw"></i> Data Pengangkatan CPNS Pegawai
			</div>
			<div class="panel-body">
				<div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>TMT CPNS</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="tmt_cpns">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('tmt_cpns',$data->tmt_cpns,'class="form-control" id="tmt_cpns" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date #datetimePicker -->
                </div>
                <!-- /.dateContainer -->
              </div>
              <!-- /.form-group -->
								<label>Masa Kerja Pengangkatan CPNS</label>
								<div class="form-group input-group">
									<span class="input-group-addon">Tahun</span>
									<?=form_input('mk_th',$data->mk_th,'class="form-control"');?>
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon">Bulan</span>
									<?=form_input('mk_bl',$data->mk_bl,'class="form-control"');?>
								</div>
              </div>
              <!-- /.col-lg-6 (nested) -->
							<div class="col-lg-6">
							<div class="form-group">
								<label>Nomor SK</label>
								<?=form_input('sk_cpns_nomor',$data->sk_cpns_nomor,'class="form-control"');?>
							</div>
							<div class="form-group">
								<label>Tanggal SK</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="sk_cpns_tgl">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('sk_cpns_tgl',$data->sk_cpns_tgl,'class="form-control" id="sk_cpns_tgl" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date #datetimePicker -->
                </div>
                <!-- /.dateContainer -->
							</div>
							<div class="form-group">
								<label>Pejabat Penetap</label>
								<?=form_input('sk_cpns_pejabat',$data->sk_cpns_pejabat,'class="form-control"');?>
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