<div class="row">
	<div class="col-lg-12">
		<h3><i class="fa fa-star-half-o fa-fw"></i> Data Pengangkatan CPNS Pegawai</h3>
		<div class="panel panel-success">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<div class="row">
				  <form role="form" id="form_cpns">
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
              <button type="submit" class="btn btn-primary btn-block">Simpan</button>
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
    if($("input[name='tmt_cpns']").val() == '00-00-0000'){$("input[name='tmt_cpns']").val('');}
    if($("input[name='sk_cpns_tgl']").val() == '00-00-0000'){$("input[name='sk_cpns_tgl']").val('');}
    $('.datetimePicker #tmt_cpns').datetimepicker();
    $('.datetimePicker #sk_cpns_tgl').datetimepicker();
    $('form#form_cpns')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					tmt_cpns: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					sk_cpns_tgl: { validators: { date: { format: 'DD-MM-YYYY'} } }
				}
			})
			.on('error.validator.bv', function(e, data){
				/* // Prevent li.active menu become affected */
				$("li.bv-tab-error").removeClass('bv-tab-error')
			})
			.on('success.validator.bv', function(e, data){
				/* // Prevent li.active menu become affected */
				$("li.bv-tab-success").removeClass('bv-tab-success')
			})
			.on('success.form.bv', function(e) {
				// Prevent form submission
				e.preventDefault();

				// Get the form instance
				var $form = $(e.target);

				// Get the BootstrapValidator instance
				var bv = $form.data('bootstrapValidator');

				var data = $("form#form_cpns").serializeArray();
				data.push({name: 'ID', value: '<?php echo $id_pegawai;?>'});
				data.push({name: 'm', value: 'cpns'});
				data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitform');?>", data, function(result) {
					// enabling submit button for next submit
					$("div#dropdown21 button:disabled").removeAttr('disabled');
					// show alert notification
					$( "#dropdown21 .row .col-lg-12" ).prepend( result );
					// set alert notification to automaticaly close
					$(".alert").delay(4000).slideUp(200, function() {
						$(this).alert('close');
					});
				});
			});
      $('.datetimePicker #tmt_cpns')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_cpns').bootstrapValidator('revalidateField', 'tmt_cpns');
      });
      $('.datetimePicker #sk_cpns_tgl')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_cpns').bootstrapValidator('revalidateField', 'sk_cpns_tgl');
      });
});
</script>
