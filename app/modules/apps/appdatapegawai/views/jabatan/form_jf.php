<h4><i class="fa fa-edit fa-fw"></i> Form Jabatan</h4>
<div class="panel panel-default">
	<div class="panel-heading">
	</div>
	<div class="panel-body">
		<div class="row">
      <form role="form" id="form_jabatan">
        <div class="col-lg-6">

          <!-- id_unor Text Input-->
          <label for="nama_unor">UNOR</label>
          <div class="form-group input-group">
            <?=form_hidden('id_unor',(!isset($row->id_unor))?'':$row->id_unor);?>
            <?php echo form_input('kode_unor',(isset($row->kode_unor))?$row->kode_unor:'','class="form-control" disabled');?>
            <span class="input-group-btn">
              <button class="btn btn-primary" id="pickerunor" type="button"  data-toggle="modal" data-target="#myModal_pickerunor">Pilih UNOR</button>
            </span>
          </div>
          
          <!-- nama_unor Text Input-->
          <div class="form-group">
            <?=form_input('nama_unor',(!isset($row->nama_unor))?'':$row->nama_unor,'class="form-control" disabled');?>
          </div>
          <!-- /.form-group-->
          
          <!-- nama_jabatan_jf Text Input-->
          <label for="nama_jabatan_jf" class="non-js">Nama Jabatan Fungsional</label>
          <div class="form-group input-group non-js">
            <?php echo form_hidden('id_jabatan',(!isset($row->id_jabatan))?'':$row->id_jabatan);?>
            <?php echo form_input('nama_jabatan_jf',(isset($row->nama_jabatan_jf))?$row->nama_jabatan_jf:'','class="form-control" disabled');?>
            <span class="input-group-btn">
              <button class="btn btn-primary" id="pickerjabfung" type="button"  data-toggle="modal" data-target="#myModal_pickerjabatan" >Pilih Jabatan</button>
            </span>
          </div>
          <!-- /.form-group-->
          
          <!-- nama_jenis_jabatan Text Input-->
          <div class="form-group">
            <label for="nama_jenis_jabatan">Jenis Jabatan</label>
						<?=form_dropdown('nama_jenis_jabatan',$this->dropdowns->jenis_jabatan(),(!isset($row->nama_jenis_jabatan))?'':$row->nama_jenis_jabatan,'class="form-control" disabled');?>
          </div>
          <!-- /.form-group-->
          
          
          <!-- tugas_tambahan Text Input-->
          <div class="form-group">
            <label for="tugas_tambahan">Tugas Tambahan</label>
						<?=form_dropdown('tugas_tambahan',$this->dropdowns->tugas_tambahan(),(!isset($row->tugas_tambahan))?'':$row->tugas_tambahan,'class="form-control"');?>
          </div>
          <!-- /.form-group-->
          
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">

          <!-- tmt_jabatan Text Input-->
          <div class="form-group">
            <label for="tmt_jabatan">TMT Jabatan</label>
            <div class="dateContainer">
              <div class="input-group date datetimePicker" id="tmt_jabatan">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <?=form_input('tmt_jabatan',(!isset($row->tmt_jabatan))?'':$row->tmt_jabatan,'class="form-control" id="tmt_jabatan" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
              </div>
              <!-- /.input-group date datetimePicker -->
            </div>
            <!-- /.dateContainer -->
          </div>
          <!-- /.form-group-->
          
          <!-- sk_pejabat Text Input-->
          <div class="form-group">
            <label for="sk_pejabat">Jabatan Penandatangan SK</label>
            <?php echo form_input('sk_pejabat',(isset($row->sk_pejabat))?$row->sk_pejabat:'','class="form-control"');?>
          </div>
          <!-- /.form-group-->
          
          <!-- sk_nomor Text Input-->
          <div class="form-group">
            <label for="sk_nomor">Nomor SK</label>
            <?php echo form_input('sk_nomor',(isset($row->sk_nomor))?$row->sk_nomor:'','class="form-control"');?>
          </div>
          <!-- /.form-group-->
          
          <!-- sk_tanggal Text Input-->
          <div class="form-group">
            <label for="sk_tanggal">Tanggal SK</label>
            <div class="dateContainer">
              <div class="input-group date datetimePicker" id="sk_tanggal">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <?=form_input('sk_tanggal',(!isset($row->sk_tanggal))?'':$row->sk_tanggal,'class="form-control" id="sk_tanggal" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
              </div>
              <!-- /.input-group date datetimePicker -->
            </div>
            <!-- /.dateContainer -->
          </div>
          <!-- /.form-group-->
          
          
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
					<button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_jabatan');return false">BATAL</button>
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
  
  if($("input[name='tmt_jabatan']").val() == '00-00-0000'){$("input[name='tmt_jabatan']").val('');}
  $('.datetimePicker #tmt_jabatan').datetimepicker();
  
  if($("input[name='sk_tanggal']").val() == '00-00-0000'){$("input[name='sk_tanggal']").val('');}
  $('.datetimePicker #sk_tanggal').datetimepicker();

  $('form#form_jabatan')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					id_unor: { validators: { notEmpty: true} },
					tmt_jabatan: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					sk_tanggal: { validators: { date: { format: 'DD-MM-YYYY'} } }
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

				var data = $("form#form_jabatan").serializeArray();
        data.push({name: 'id_pegawai', value: '<?php echo $id_pegawai;?>'});
        data.push({name: 'ID', value: '<?=(!isset($row->id_peg_jab))?'add':$row->id_peg_jab;?>'});
        data.push({name: 'm', value: 'jabatan'});
        data.push({name: 'f', value: 'save'});
        data.push({name: 'nama_jenis_jabatan', value: $('form#form_jabatan select[name="nama_jenis_jabatan"]').val()});
        data.push({name: 'nama_jabatan_jf', value: $('form#form_jabatan input[name="nama_jabatan_jf"]').val() } );
        // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitformriwayat');?>", data, function(result) {
          $("#dropdown24").html(result);
				});
			});
  $('.datetimePicker #tmt_jabatan')
  .on('dp.change dp.show', function (e) {
    // Revalidate the date when user change it
    $('form#form_jabatan').bootstrapValidator('revalidateField', 'tmt_jabatan');
  });
  $('.datetimePicker #sk_tanggal')
  .on('dp.change dp.show', function (e) {
    // Revalidate the date when user change it
    $('form#form_jabatan').bootstrapValidator('revalidateField', 'sk_tanggal');
  });
});
</script>
