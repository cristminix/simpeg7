<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="fa fa-star fa-fw"></i> Data Pengangkatan PNS Pegawai
			</div>
			<div class="panel-body">
				<div class="row">
            <div class="col-lg-6">
							<div class="form-group">
								<label>TMT PNS</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="tmt_pns">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('tmt_pns',$data->tmt_pns,'class="form-control" id="tmt_pns" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date datetimePicker -->
                </div>
                <!-- /.dateContainer -->
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-6">
							<div class="form-group">
								<label>Nomor SK</label>
								<?=form_input('sk_pns_nomor',$data->sk_pns_nomor,'class="form-control"');?>
								
							</div>
							<div class="form-group">
								<label>Tanggal SK</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="sk_pns_tanggal">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    <?=form_input('sk_pns_tanggal',$data->sk_pns_tanggal,'class="form-control" id="sk_pns_tanggal" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date datetimePicker -->
                </div>
                <!-- /.dateContainer -->
							</div>
							<div class="form-group">
								<label>Pejabat Penetap</label>
								<?=form_input('sk_pns_pejabat',$data->sk_pns_pejabat,'class="form-control"');?>

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