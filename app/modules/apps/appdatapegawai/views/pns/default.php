<div class="row">
	<div class="col-lg-12">
		<h3><i class="fa fa-star fa-fw"></i> Data Pengangkatan PNS Pegawai</h3>
		<div class="panel panel-success">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<div class="row">
          <form role="form" id="form_pns">
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
    if($("input[name='tmt_pns']").val() == '00-00-0000'){$("input[name='tmt_pns']").val('');}
    if($("input[name='sk_pns_tanggal']").val() == '00-00-0000'){$("input[name='sk_pns_tanggal']").val('');}
    $('.datetimePicker #tmt_pns').datetimepicker();
    $('.datetimePicker #sk_pns_tanggal').datetimepicker();
    $('form#form_pns')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					tmt_pns: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					sk_pns_tanggal: { validators: { date: { format: 'DD-MM-YYYY'} } }
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

				var data = $("form#form_pns").serializeArray();
				data.push({name: 'ID', value: '<?php echo $id_pegawai;?>'});
				data.push({name: 'm', value: 'pns'});
				data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitform');?>", data, function(result) {
					// enabling submit button for next submit
					$("div#dropdown22 button:disabled").removeAttr('disabled');
					// show alert notification
					$( "#dropdown22 .row .col-lg-12" ).prepend( result );
					// set alert notification to automaticaly close
					$(".alert").delay(4000).slideUp(200, function() {
						$(this).alert('close');
					});
				});
			});
      $('.datetimePicker #tmt_pns')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_pns').bootstrapValidator('revalidateField', 'tmt_pns');
      });
      $('.datetimePicker #sk_pns_tanggal')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_pns').bootstrapValidator('revalidateField', 'sk_pns_tanggal');
      });
});
</script>