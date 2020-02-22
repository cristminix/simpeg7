<h4><i class="fa fa-edit fa-fw"></i> Form Pernikahan Pegawai</h4>
<div class="panel panel-default">
  <div class="panel-heading">
  </div>
  <div class="panel-body">
    <div class="row">
      <form role="form" id="form_pernikahan">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Nama Istri / Suami</label>
            <?php echo form_input('nama_suris',(!isset($row->nama_suris))?'':$row->nama_suris,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Tempat Lahir</label>
            <?php echo form_input('tempat_lahir_suris',(!isset($row->tempat_lahir_suris))?'':$row->tempat_lahir_suris,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <div class="dateContainer">
              <div class="input-group date datetimePicker" id="tanggal_lahir_suris">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <?php echo form_input('tanggal_lahir_suris',(!isset($row->tanggal_lahir_suris))?'':$row->tanggal_lahir_suris,'class="form-control" id="tanggal_lahir_suris" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
              </div>
              <!-- /.input-group date datetimePicker -->
            </div>
            <!-- /.dateContainer -->
          </div>
          <div class="form-group">
            <label>Tanggal Menikah</label>
              <div class="dateContainer">
                <div class="input-group date datetimePicker" id="tanggal_menikah">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <?php echo form_input('tanggal_menikah',(!isset($row->tanggal_menikah))?'':$row->tanggal_menikah,'class="form-control" id="tanggal_menikah" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                </div>
                <!-- /.input-group date datetimePicker -->
              </div>
              <!-- /.dateContainer -->
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <?php echo form_input('keterangan',(!isset($row->keterangan))?'':$row->keterangan,'class="form-control"');?>
          </div>
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">
          <div class="form-group">
            <label>Pendidikan</label>
            <?php echo form_input('pendidikan_suris',(!isset($row->pendidikan_suris))?'':$row->pendidikan_suris,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Pekerjaan</label>
			<?php echo form_input('pekerjaan_suris',(!isset($row->pekerjaan_suris))?'':$row->pekerjaan_suris,'class="form-control"');?>
          </div>

          <div class="form-group">
            <label>Status Aktif</label>
            <?php echo 
            form_dropdown('status_aktif',
              $this->dropdowns->activeStat(),
                !isset($row->status_aktif) ? 
                  '':
                  $row->status_aktif, 
                ' class="form-control" '
            );?>
          </div> 

          <div class="form-group">
            <label>Tanggal Aktif</label>
              <div class="dateContainer">
                <div class="input-group date datetimePicker" id="tanggal_aktif">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <?php echo form_input('tanggal_aktif',(!isset($row->tanggal_aktif))?'':$row->tanggal_aktif,'class="form-control" id="tanggal_aktif" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                </div>
                <!-- /.input-group date datetimePicker -->
              </div>
              <!-- /.dateContainer -->
          </div>
         
          
          
        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
          <button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_pernikahan');return false">BATAL</button>
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
    if($("input[name='tanggal_lahir_suris']").val() == '00-00-0000'){$("input[name='tanggal_lahir_suris']").val('');}
    if($("input[name='tanggal_menikah']").val() == '00-00-0000'){$("input[name='tanggal_menikah']").val('');}
    if($("input[name='tanggal_aktif']").val() == '00-00-0000'){$("input[name='tanggal_aktif']").val('');}
    $('.datetimePicker #tanggal_lahir_suris').datetimepicker();
    $('.datetimePicker #tanggal_menikah').datetimepicker();
    $('.datetimePicker #tanggal_aktif').datetimepicker();
    $('form#form_pernikahan')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					nama_suris: { validators: { notEmpty: true} },
					tempat_lahir_suris: { validators: { notEmpty: true} },
					tanggal_lahir_suris: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					tanggal_menikah: { validators: {  date: { format: 'DD-MM-YYYY'} } },
          status_aktif: { validators: { notEmpty: true} },
          tanggal_aktif: { validators: {  date: { format: 'DD-MM-YYYY'} } }
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

				var data = $("form#form_pernikahan").serializeArray();
        data.push({name: 'id_pegawai', value: '<?php echo $id_pegawai;?>'});
        data.push({name: 'ID', value: '<?php echo (!isset($row->id_peg_perkawinan))?'add':$row->id_peg_perkawinan;?>'});
        data.push({name: 'm', value: 'pernikahan'});
        data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitformriwayat');?>", data, function(result) {
          $("#dropdown13").html(result);
				});
			});
      $('.datetimePicker #tanggal_lahir_suris')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_pernikahan').bootstrapValidator('revalidateField', 'tanggal_lahir_suris');
      });
      $('.datetimePicker #tanggal_menikah')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_pernikahan').bootstrapValidator('revalidateField', 'tanggal_menikah');
      });
      $('.datetimePicker #tanggal_aktif')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_pernikahan').bootstrapValidator('revalidateField', 'tanggal_aktif');
      });
});
</script>
