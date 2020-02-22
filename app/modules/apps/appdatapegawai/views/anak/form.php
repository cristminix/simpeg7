<h4><i class="fa fa-edit fa-fw"></i> Form Anak</h4>
<div class="panel panel-default">
  <div class="panel-heading">
  </div>
  <div class="panel-body">
    <div class="row">
      <form role="form" id="form_anak">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Nama Anak</label>
						<?=form_input('nama_anak',(!isset($row->nama_anak))?'':$row->nama_anak,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Tempat Lahir</label>
						<?=form_input('tempat_lahir_anak',(!isset($row->tempat_lahir_anak))?'':$row->tempat_lahir_anak,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
              <div class="dateContainer">
                <div class="input-group date datetimePicker" id="tanggal_lahir_anak">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <?=form_input('tanggal_lahir_anak',(!isset($row->tanggal_lahir_anak))?'':$row->tanggal_lahir_anak,'class="form-control" id="tanggal_lahir_anak" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                </div>
                <!-- /.input-group date datetimePicker -->
              </div>
              <!-- /.dateContainer -->
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
						<?=form_dropdown('gender_anak',$this->dropdowns->gender(),(!isset($row->gender_anak))?'':$row->gender_anak,'class="form-control"');?>
            
          </div>
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">
          <div class="form-group">
            <label>Status Anak</label>
						<?=form_dropdown('status_anak',$this->dropdowns->status_anak(),(!isset($row->status_anak))?'':$row->status_anak,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Keterangan Tunjangan</label>
						<?=form_dropdown('keterangan_tunjangan',$this->dropdowns->keterangan_tunjangan(),(!isset($row->keterangan_tunjangan))?'':$row->keterangan_tunjangan,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Pendidikan</label>
						<?=form_input('pendidikan_anak',(!isset($row->pendidikan_anak))?'':$row->pendidikan_anak,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Pekerjaan</label>
						<?=form_input('pekerjaan_anak',(!isset($row->pekerjaan_anak))?'':$row->pekerjaan_anak,'class="form-control"');?>
            
          </div>
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
          <button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_anak');return false">BATAL</button>
        </div>
        <!-- /.col-lg-6 (nested) -->
      </form>
    </div>
    <!-- /.row (nested) -->
  </div>
  <!-- /.panel-body -->
</div>
<!-- /.panel -->
<script type="text/javascript">
$(document).ready(function() {
    if($("input[name='tanggal_lahir_anak']").val() == '00-00-0000'){$("input[name='tanggal_lahir_anak']").val('');}
    $('.datetimePicker #tanggal_lahir_anak').datetimepicker();
    $('form#form_anak')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					nama_anak: { validators: { notEmpty: true} },
					tanggal_lahir_anak: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					tempat_lahir_anak: { validators: { notEmpty: true} },
					gender_anak: { validators: { notEmpty: true} },
					status_anak: { validators: { notEmpty: true} },
					keterangan_tunjangan: { validators: { notEmpty: true} }
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

				var data = $("form#form_anak").serializeArray();
        data.push({name: 'id_pegawai', value: '<?php echo $id_pegawai;?>'});
        data.push({name: 'ID', value: '<?=(!isset($row->id_peg_anak))?'add':$row->id_peg_anak;?>'});
        data.push({name: 'm', value: 'anak'});
        data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitformriwayat');?>", data, function(result) {
          $("#dropdown14").html(result);
				});
			});
      $('.datetimePicker #tanggal_lahir_anak')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_anak').bootstrapValidator('revalidateField', 'tanggal_lahir_anak');
      });
});
</script>
