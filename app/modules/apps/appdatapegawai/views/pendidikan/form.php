<h4><i class="fa fa-edit fa-fw"></i> Form Pendidikan</h4>
<div class="panel panel-default">
	<div class="panel-heading">
	</div>
	<div class="panel-body">
		<div class="row">
      <form role="form" id="form_pendidikan">
        <div class="col-lg-6">
          <label>Nama Pendidikan / Jurusan</label>
          <div class="form-group input-group">
            <?=form_hidden('nip_baru',(!isset($row->nip_baru))?'':$row->nip_baru);?>
            <?=form_hidden('id_pendidikan',(!isset($row->id_pendidikan))?'':$row->id_pendidikan);?>
            <?=form_input('jurusan',(!isset($row->jurusan))?'':$row->jurusan,'class="form-control" disabled');?>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button"  data-toggle="modal" data-target="#myModal">Pilih Pendidikan</button>
            </span>
          </div>
					<div class="form-group">
						<label>Jenjang Pendidikan</label>
            <?=form_input('nama_jenjang',(!isset($row->nama_jenjang))?'':$row->nama_jenjang,'class="form-control" disabled');?>
					</div>
					<div class="form-group">
						<label>Gelar Depan</label>
						<?=form_input('gelar_depan',(!isset($row->gelar_depan))?'':$row->gelar_depan,'class="form-control"');?>
					</div>
					<div class="form-group">
						<label>Gelar Belakang</label>
						<?=form_input('gelar_belakang',(!isset($row->gelar_belakang))?'':$row->gelar_belakang,'class="form-control"');?>
					</div>
					<div class="form-group">
						<label>Nama Sekolah</label>
						<?=form_input('nama_sekolah',(!isset($row->nama_sekolah))?'':$row->nama_sekolah,'class="form-control"');?>
					</div>
					<div class="form-group">
						<label>Tempat Sekolah</label>
						<?=form_input('tempat_sekolah',(!isset($row->lokasi_sekolah))?'':$row->lokasi_sekolah,'class="form-control"');?>
					</div>
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">
					<div class="form-group">
						<label>Nomor Ijazah</label>
						<?=form_input('nomor_ijazah',(!isset($row->nomor_ijazah))?'':$row->nomor_ijazah,'class="form-control"');?>
					</div>
					<div class="form-group">
						<label>Tanggal Lulus</label>
            <div class="dateContainer">
              <div class="input-group date datetimePicker" id="tanggal_lulus">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <?=form_input('tanggal_lulus',(!isset($row->tanggal_lulus))?'':$row->tanggal_lulus,'class="form-control" id="tanggal_lulus" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
              </div>
              <!-- /.input-group date datetimePicker -->
            </div>
            <!-- /.dateContainer -->
					</div>
					<div class="form-group">
						<label>Tahun Lulus</label>
						<?=form_input('tahun_lulus',(!isset($row->tahun_lulus))?'':$row->tahun_lulus,'class="form-control"');?>
					</div>
					
					<div class="form-group">
            <label>Jenis Pendidikan</label>
						<?=form_dropdown('jenis_pendidikan',$this->dropdowns->jenis_pendidikan(),(!isset($row->jenis_pendidikan))?'':$row->jenis_pendidikan,'class="form-control"');?>
            
          </div>
		
		
					<div class="form-group">
						<label>
						<?=form_checkbox('pendidikan_pertama','V', (isset($row->pendidikan_pertama) && $row->pendidikan_pertama == 'V')?TRUE:FALSE);?>
            Pendidikan Pengangkatan sebagai Capeg</label>
					</div>
					<div class="form-group">
						<label>
						<?=form_checkbox('diakui','V', (isset($row->diakui) && $row->diakui == 'V')?TRUE:FALSE);?>
            Diakui :</label> 
            <ol>
              <li>Pendidikan sebelum dan pada saat Pengangkatan Capeg</li>
              <li>Pendidikan setelah pengangkatan Capeg dan sudah Lulus Ujian Penyesuaian Ijazah</li>
            </ol>
					</div>
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
					<button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_pendidikan');return false">BATAL</button>
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
    $('#myModal').on('show.bs.modal', function (e) {
      $('#myModal .modal-body').css('overflow-y', 'auto'); 
      $('#myModal .modal-body').css('height', $(window).height() * 0.7);        
      // set modal height to be 70 % of window screen
      var data = {
          name:'id_pendididikan',
          m:'pendidikan',
          f:'show'
        };
				$.post("<?php echo site_url('datapegawai/picker');?>", data, function(result) {
          $('#myModal .modal-body').html(result);
				});
      
    });
    if($("input[name='tanggal_lulus']").val() == '00-00-0000'){$("input[name='tanggal_lulus']").val('');}
    $('.datetimePicker #tanggal_lulus').datetimepicker();
    $('form#form_pendidikan')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					// kode_jenjang: { validators: { notEmpty: true} },
					nama_pendidikan: { validators: { notEmpty: true} },
					jurusan: { validators: { notEmpty: true} },
					tahun_lulus: { validators: { notEmpty: false} },
					tanggal_lulus: { validators: {  date: { format: 'DD-MM-YYYY'} } }
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

				var data = $("form#form_pendidikan").serializeArray();
        data.push({name: 'id_pegawai', value: '<?php echo $id_pegawai;?>'});
        data.push({name: 'ID', value: '<?=(!isset($row->id_peg_pendidikan))?'add':$row->id_peg_pendidikan;?>'});
        data.push({name: 'm', value: 'pendidikan'});
        data.push({name: 'f', value: 'save'});
        data.push({name: 'jurusan',value:$('input[name=jurusan]').val()});
        data.push({name: 'lokasi_sekolah',value:$('input[name=tempat_sekolah]').val()});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('datapegawai/submitformriwayat');?>", data, function(result) {
          $("#dropdown15").html(result);
				});
			});
      $('.datetimePicker #tanggal_lulus')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_pendidikan').bootstrapValidator('revalidateField', 'tanggal_lulus');
      });
});
</script>
