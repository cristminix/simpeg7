<div class="row">
	<div class="col-lg-12">
		<h3><i class="fa fa-star-half-o fa-fw"></i>Data Pengangkatan Kontrak Pegawai</h3>
		<div class="panel panel-success">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<div class="row">
          <form role="form" id="form_kontrak">
            <div class="col-lg-6">
							<div class="form-group">
								<label>TMT Kontrak</label>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="tmt_kontrak">
                 
                    <?=form_label($data->tmt_kontrak?$data->tmt_kontrak:'-','tmt_kontrak','class="form-control" id="tmt_kontrak" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date datetimePicker -->
                </div>
                <!-- /.dateContainer -->
              </div>
			  
			  	<label>Masa Kerja Pengangkatan Kontrak</label>
								<div class="form-group input-group">
									<span class="">Tahun : </span>
									<?=form_label($data->mk_th?$data->mk_th:'-','mk_th','class="form-control"');?>
								</div>
								<div class="form-group input-group">
									<span class="">Bulan : </span>
									<?=form_label($data->mk_bl?$data->mk_bl:'-','mk_bl','class="form-control"');?>
								</div>
			  
              <!-- /.form-group -->
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-6">
							<div class="form-group">
								<label>Nomor SK</label><br/>
								<?=form_label($data->sk_nomor?$data->sk_nomor:'-','sk_nomor','class="form-control"');?>
								
							</div>
							<div class="form-group">
								<label>Tanggal SK</label><br/>
                <div class="dateContainer">
                  <div class="input-group date datetimePicker" id="sk_tanggal">
                 
                    <?=form_label($data->sk_tanggal?$data->sk_tanggal:'-','sk_tanggal','class="form-control" id="sk_tanggal" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                  </div>
                  <!-- /.input-group date datetimePicker -->
                </div>
                <!-- /.dateContainer -->
							</div>
							<div class="form-group">
								<label>Pejabat Penetap</label><br/>
								<?=form_label($data->sk_pejabat?$data->sk_pejabat:'-','sk_pejabat','class="form-control"');?>

                </div>
              
            </div>
            <!-- /.col-lg-6 (nested) -->
          </form>
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
<script type="text/javascript">
$(document).ready(function() {
   
});
</script>