<h4><i class="fa fa-edit fa-fw"></i> Form Orang Tua</h4>
<div class="panel panel-default">
  <div class="panel-heading">
  </div>
  <div class="panel-body">
    <div class="row">
      <form role="form" id="form_orangtua">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Nama Orang Tua</label>
						<?=form_input('nama_orangtua',(!isset($row->nama_orangtua))?'':$row->nama_orangtua,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Tempat Lahir</label>
						<?=form_input('tempat_lahir_orangtua',(!isset($row->tempat_lahir_orangtua))?'':$row->tempat_lahir_orangtua,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
              <div class="dateContainer">
                <div class="input-group date datetimePicker" id="tanggal_lahir_orangtua">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <?=form_input('tanggal_lahir_orangtua',(!isset($row->tanggal_lahir_orangtua))?'':$row->tanggal_lahir_orangtua,'class="form-control" id="tanggal_lahir_orangtua" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                </div>
                <!-- /.input-group date datetimePicker -->
              </div>
              <!-- /.dateContainer -->
            
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
						<?=form_dropdown('gender_orangtua',$this->dropdowns->gender(),(!isset($row->gender_orangtua))?'':$row->gender_orangtua,'class="form-control"');?>
            
          </div>
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">
          <div class="form-group">
            <label>Status Orang Tua</label>
						<?=form_dropdown('status_orangtua',$this->dropdowns->status_orangtua(),(!isset($row->status_orangtua))?'':$row->status_orangtua,'class="form-control"');?>
            
          </div>
          <div class="form-group">
            <label>Keterangan Tunjangan</label>
						<?=form_dropdown('keterangan_tunjangan',$this->dropdowns->keterangan_tunjangan(),(!isset($row->keterangan_tunjangan))?'':$row->keterangan_tunjangan,'class="form-control"');?>
            
          </div>
		  
		  <div class="form-group">
            <label>Keterangan</label>
						<?=form_dropdown('keterangan',$this->dropdowns->keterangan(),(!isset($row->keterangan))?'':$row->keterangan,'class="form-control"');?>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
          <button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_orangtua');return false">BATAL</button>
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
    if($("input[name='tanggal_lahir_orangtua']").val() == '00-00-0000'){$("input[name='tanggal_lahir_orangtua']").val('');}
    $('.datetimePicker #tanggal_lahir_orangtua').datetimepicker();
    $('form#form_orangtua')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					nama_oranguta: { validators: { notEmpty: true} },
					tanggal_lahir_orangtua: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					tempat_lahir_orangtua: { validators: { notEmpty: true} },
					gender_orangtua: { validators: { notEmpty: true} },
					status_orangtua: { validators: { notEmpty: true} },
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

				var data = $("form#form_orangtua").serializeArray();
        data.push({name: 'id_pegawai', value: '<?php echo $id_pegawai;?>'});
        data.push({name: 'ID', value: '<?=(!isset($row->id_peg_orangtua))?'add':$row->id_peg_orangtua;?>'});
        data.push({name: 'm', value: 'orangtua'});
        data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitformriwayat');?>", data, function(result) {
          $("#dropdown151").html(result);
				});
			});
      $('.datetimePicker #tanggal_lahir_orangtua')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_orangtua').bootstrapValidator('revalidateField', 'tanggal_lahir_orangtua');
      });
});
</script>
