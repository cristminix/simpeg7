<h4><i class="fa fa-edit fa-fw"></i> Form Kepangkatan</h4>
<div class="panel panel-default">
  <div class="panel-heading">
  </div>
  <div class="panel-body">
    <div class="row">
      <form role="form" id="form_kepangkatan">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Pangkat Golongan</label>
						<?=form_dropdown('kode_golongan',$this->dropdowns->kode_golongan_pangkat(),(!isset($row->kode_golongan))?'':$row->kode_golongan,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Jenis KP</label>
						<?=form_dropdown('kode_jenis_kp',$this->dropdowns->kode_jenis_kp(),(!isset($row->kode_jenis_kp))?'':$row->kode_jenis_kp,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>TMT Pangkat</label>
            <div class="dateContainer">
              <div class="input-group date datetimePicker" id="tmt_golongan">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <?=form_input('tmt_golongan',(!isset($row->tmt_golongan))?'':$row->tmt_golongan,'class="form-control" id="tmt_golongan" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
              </div>
              <!-- /.input-group date datetimePicker -->
            </div>
            <!-- /.dateContainer -->
          </div>
          <div class="form-group">
            <label>Jumlah Angka Kredit Utama</label>
						<?=form_input('kredit_utama',(!isset($row->kredit_utama))?'':$row->kredit_utama,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Jumlah Angka Kredit Tambahan</label>
						<?=form_input('kredit_tambahan',(!isset($row->kredit_tambahan))?'':$row->kredit_tambahan,'class="form-control"');?>
          </div>
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">
          <div class="form-group">
            <label>MK Golongan Tahun</label>
						<?=form_input('mk_gol_tahun',(!isset($row->mk_gol_tahun))?'':$row->mk_gol_tahun,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>MK Golongan Bulan</label>
						<?=form_input('mk_gol_bulan',(!isset($row->mk_gol_bulan))?'':$row->mk_gol_bulan,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Nomor SK</label>
						<?=form_input('sk_nomor',(!isset($row->sk_nomor))?'':$row->sk_nomor,'class="form-control"');?>
          </div>
          <div class="form-group">
            <label>Tanggal SK</label>
            <div class="dateContainer">
              <div class="input-group date datetimePicker" id="sk_tanggal">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <?=form_input('sk_tanggal',(!isset($row->sk_tanggal))?'':$row->sk_tanggal,'class="form-control" id="sk_tanggal" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
              </div>
              <!-- /.input-group date datetimePicker -->
            </div>
            <!-- /.dateContainer -->
          </div>
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
          <button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_kepangkatan');return false">BATAL</button>
        </form>
      </div>
      <!-- /.col-lg-6 (nested) -->
    </div>
    <!-- /.row (nested) -->
  </div>
  <!-- /.panel-body -->
</div>
<!-- /.panel -->
<script type="text/javascript">
$(document).ready(function() {
    if($("input[name='tmt_golongan']").val() == '00-00-0000'){$("input[name='tmt_golongan']").val('');}
    if($("input[name='sk_tanggal']").val() == '00-00-0000'){$("input[name='sk_tanggal']").val('');}
    
    $('.datetimePicker #tmt_golongan').datetimepicker();
    $('.datetimePicker #sk_tanggal').datetimepicker();
    $('form#form_kepangkatan')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					kode_golongan: { validators: { notEmpty: true} },
					tmt_golongan: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'} } },
					sk_tanggal: { validators: {date: { format: 'DD-MM-YYYY'} } }
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

				var data = $("form#form_kepangkatan").serializeArray();
        data.push({name: 'id_pegawai', value: '<?php echo $id_pegawai;?>'});
        data.push({name: 'ID', value: '<?=(!isset($row->id_peg_golongan))?'add':$row->id_peg_golongan ;?>'});
        data.push({name: 'm', value: 'kepangkatan'});
        data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitformriwayat');?>", data, function(result) {
          $("#dropdown23").html(result);
          loadDetailPegawai(<?php echo $id_pegawai;?>);
				});
			});
      $('.datetimePicker #tmt_golongan')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_kepangkatan').bootstrapValidator('revalidateField', 'tmt_golongan');
      });
      $('.datetimePicker #sk_tanggal')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_kepangkatan').bootstrapValidator('revalidateField', 'sk_tanggal');
      });
});
</script>
