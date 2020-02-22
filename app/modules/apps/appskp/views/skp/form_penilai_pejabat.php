<h4><i class="fa fa-edit fa-fw"></i> Form Edit Pejabat Penilai</h4>
<div class="panel panel-default">
	<div class="panel-heading">
	</div>
	<div class="panel-body">
		<div class="row">
      <form role="form" id="form_editpenilai">
        <div class="col-lg-6">

					<!-- penilai_nama_pegawai Text Input-->
          <div class="form-group js">
            <label for="penilai_nama_pegawai">Nama Pejabat Penilai</label>
            <?php echo form_input('penilai_nama_pegawai',(isset($row->penilai_nama_pegawai))?$row->penilai_nama_pegawai:'','class="form-control" disabled');?>
          </div>
          <!-- /.form-group-->
          
					<!-- penilai_nip_baru Text Input-->
          <div class="form-group js">
            <label for="penilai_nip_baru">NIP Baru</label>
            <?php echo form_input('penilai_nip_baru',(isset($row->penilai_nip_baru))?$row->penilai_nip_baru:'','class="form-control" disabled');?>
          </div>
          <!-- /.form-group-->
					
          <div class="form-group">
            <label>Pangkat Golongan</label>
						<?=form_dropdown('penilai_kode_golongan',$this->dropdowns->kode_golongan_pangkat(),(!isset($row->penilai_kode_golongan))?'':$row->penilai_kode_golongan,'class="form-control"');?>
          </div>
          
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">

					<!-- penilai_id_unor Text Input-->
				 <label for="penilai_nomenklatur_jabatan">Jabatan</label>
         <div class="form-group input-group">
            <?=form_hidden('penilai_id_unor',(!isset($row->penilai_id_unor))?'':$row->penilai_id_unor);?>
            <?php echo form_input('penilai_nomenklatur_jabatan',(isset($row->penilai_nomenklatur_jabatan))?$row->penilai_nomenklatur_jabatan:'','class="form-control" disabled');?>
						<span class="input-group-btn">
              <button class="btn btn-primary" id="pickerjabatan" type="button"  data-toggle="modal" data-target="#myModal_pickerjabatan">Pilih</button>
            </span>
          </div>

          <!-- penilai_nama_ese Text Input-->
          <div class="form-group">
            <label for="penilai_nama_ese">Eselon</label>
            <?php echo form_input('penilai_nama_ese',(isset($row->penilai_nama_ese))?$row->penilai_nama_ese:'','class="form-control" disabled');?>
          </div>
          <!-- /.form-group-->
          
          <!-- penilai_nomenklatur_pada Text Input-->
          <div class="form-group">
          <label for="penilai_nomenklatur_pada">Unit Kerja</label>
            <?=form_input('penilai_nomenklatur_pada',(!isset($row->penilai_nomenklatur_pada))?'':$row->penilai_nomenklatur_pada,'class="form-control" disabled');?>
					</div>
          <!-- /.form-group-->
          
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
					<button class="btn btn-warning btn-block" type="button" onclick="editPenilaiCancel();return false">BATAL</button>
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
	$('#myModal_pickerjabatan').on('show.bs.modal', function (e) {
		$('#myModal_pickerjabatan .modal-body').css('overflow-y', 'auto'); 
		$('#myModal_pickerjabatan .modal-body').css('height', $(window).height() * 0.7);        
		$('#myModal_pickerjabatan .modal-dialog').css('width', $(window).width() * 0.7);        
		var data = {
			name:'id_unor',
			m:'jabatan',
			f:'pickerjabatan'
		};
		$.post("<?php echo site_url('appskp/skp/pickerjabatan');?>", data, function(result) {
			$('#myModal_pickerjabatan .modal-body').html(result);
		});
	});
  $('form#form_editpenilai')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					id_unor: { validators: { notEmpty: true} }
				}
			})
			.on('success.form.bv', function(e) {
				// Prevent form submission
				e.preventDefault();

				// Get the form instance
				var $form = $(e.target);

				// Get the BootstrapValidator instance
				var bv = $form.data('bootstrapValidator');

				var data = $("form#form_editpenilai").serializeArray();
        data.push({name: 'id_skp', value: '<?php echo $row->id_skp;?>'});
        data.push({name: 'penilai_nomenklatur_jabatan', value: $('form#form_editpenilai input[name="penilai_nomenklatur_jabatan"]').val()});
        data.push({name: 'penilai_nomenklatur_pada', value: $('form#form_editpenilai input[name="penilai_nomenklatur_pada"]').val()});
        data.push({name: 'penilai_nama_ese', value: $('form#form_editpenilai input[name="penilai_nama_ese"]').val()});
				
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('appskp/skp/save_penilai');?>", data, function(result) {
					if(result.success == true)
					{
						location.href = '<?=site_url();?>'+'admin/module/appskp/skp';
					}else
					{
						alert('gagal disimpan');
					}
				},'json');
			});
});
</script>
