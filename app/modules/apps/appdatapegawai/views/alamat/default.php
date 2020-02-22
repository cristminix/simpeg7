<div class="row">
	<div class="col-lg-12">
		<h3><i class="fa fa-home fa-fw"></i> Data Alamat Pegawai</h3>
		<div class="panel panel-info">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<div class="row">
					<form role="form" id="form_alamat">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Jalan</label>
								<?=form_input('jalan',$data->jalan,'class="form-control"');?>
							</div>
							 <div class="form-group">
								<label>RT</label>
								<?=form_input('rt',$data->rt,'class="form-control"');?>
							</div>
							 <div class="form-group">
								<label>RW</label>
								<?=form_input('rw',$data->rw,'class="form-control"');?>
							</div>
							 <div class="form-group">
								<label>Kelurahan / Desa</label>
								<?=form_input('kel_desa',$data->kel_desa,'class="form-control"');?>
							</div>
							<div class="form-group">
								<label>Kecamatan</label>
								<?=form_input('kecamatan',$data->kecamatan,'class="form-control"');?>
							</div>
						</div>
						<!-- /.col-lg-6 (nested) -->
						<div class="col-lg-6">
								<div class="form-group">
									<label>Kab. / Kota</label>
									<?=form_input('kab_kota',$data->kab_kota,'class="form-control"');?>
								</div>
								<div class="form-group">
									<label>Propinsi</label>
									<?=form_input('propinsi',$data->propinsi,'class="form-control"');?>
								</div>
								<div class="form-group">
									<label>Kode Pos</label>
									<?=form_input('kode_pos',$data->kode_pos,'class="form-control"');?>
								</div>
								<label>Jarak Tempuh Rumah-Kantor</label>
								<div class="form-group input-group">
									<span class="input-group-addon">km</span>
									<?=form_input('jarak_meter',$data->jarak_meter,'class="form-control"');?>
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon">menit</span>
									<?=form_input('jarak_menit',$data->jarak_menit,'class="form-control"');?>
								</div>
								<button type="submit" class="btn btn-primary btn-block">Simpan</button>
						</div>
						<!-- /.col-lg-6 (nested) -->
					</form>
					<!-- form/.form_alamat -->
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
    $('form#form_alamat')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					jalan: {
						validators: { notEmpty: true}
					},
					kab_kota: {
						validators: { notEmpty: true}
					}
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

				var data = $("form#form_alamat").serializeArray();
				data.push({name: 'ID', value: '<?php echo $id_pegawai;?>'});
				data.push({name: 'm', value: 'alamat'});
				data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitform');?>", data, function(result) {
					// enabling submit button for next submit
					$("div#dropdown12 button:disabled").removeAttr('disabled');
					// show alert notification
					$( "#dropdown12 .row .col-lg-12" ).prepend( result );
					// set alert notification to automaticaly close
					$(".alert").delay(4000).slideUp(200, function() {
						$(this).alert('close');
					});
				});
			});
		// });
});
</script>
