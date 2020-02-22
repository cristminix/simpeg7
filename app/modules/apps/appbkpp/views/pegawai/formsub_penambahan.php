<div class="row" id="divAddEmployeeForm">
  <div class="col-lg-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6">
              <i class="fa fa-briefcase fa-fw"></i> Data Utama Pegawai
            </div>
            <!--//col-lg-6-->
            <div class="col-lg-6">
              <div class="btn-group pull-right">
              <button class="btn btn-primary btn-xs" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
              </div>
            </div>
            <!--//col-lg-6-->
        </div>
        <!--//row-->
			</div>
      <div class="panel-body">
        <div class="row">
          <form role="form" id="form_sub_t" action="<?=site_url('appbkpp/pegawai/formsub_penambahan_aksi');?>">
            <div class="col-lg-6">
              <div class="form-group">
                <label>Nama Pegawai</label>
                <?=form_input('nama_pegawai', @$data->nama_pegawai, 'class="form-control"');?>
                <p class="help-block">Tanpa Gelar depan, belakang atau Gelar Non-Akademis.</p>
              </div>
               <div class="form-group">
                <label>Gelar Depan</label>
                <?=form_input('gelar_depan', @$data->gelar_depan, 'class="form-control"');?>
                <p class="help-block">Drs. Dra. dr. </p>
              </div>
               <div class="form-group">
                <label>Gelar Non-Akademis</label>
                <?=form_input('gelar_nonakademis', @$data->gelar_nonakademis, 'class="form-control"');?>
                <p class="help-block">H. Hj.</p>
              </div>
              <div class="form-group">
                <label>Gelar Belakang</label>
                <?=form_input('gelar_belakang', @$data->gelar_belakang, 'class="form-control"');?>
                <p class="help-block">Amd. </p>
              </div>
              <div class="form-group">
                <label>Tempat Lahir</label>
                <?=form_input('tempat_lahir', @$data->tempat_lahir, 'class="form-control"');?>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="dateContainer">
                    <div class="input-group date" id="datetimePicker">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <?=form_input('tanggal_lahir', @$data->tanggal_lahir, 'class="form-control" id="tanggal_lahir" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label>Jenis Kelamin</label>
                <?=form_dropdown('gender', $this->dropdowns->gender(), @$data->gender, 'class="form-control"');?>
              </div>
              <div class="form-group">
                <label>Agama</label>
                <?=form_dropdown('agama', $this->dropdowns->agama(), @$data->agama, ' class="form-control"');?>
              </div>
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-6">
              <div class="form-group">
                <label>NIP</label>
                <?=form_input('nip_baru', @$data->nip_baru, 'class="form-control"');?>
                <p class="help-block">Tanpa spasi atau tanda baca lain.</p>
              </div>

              <div class="form-group">
                <label>Nomor HP</label>
                <?=form_input('nomor_hp', @$data->nomor_hp, 'class="form-control"');?>
                <p class="help-block">Tanpa spasi atau tanda baca lain (08XXXXXX).</p>
              </div>
              <div class="form-group">
                <label>Nomor Tlp. Rumah</label>
                <?=form_input('nomor_tlp_rumah', @$data->nomor_tlp_rumah, 'class="form-control"');?>
                <p class="help-block">Tanpa spasi atau tanda baca lain (021XXXXX).</p>
              </div>
			  <div class="form-group">
                <label>Status Pegawai</label>
                <?=form_dropdown('status_pegawai', $this->dropdowns->status_pegawai(), @$data->status_pegawai, ' class="form-control" id="status_pegawai"');?>
              </div>
			    <div class="form-group">
                <label>Kelompok Pegawai</label>
                <?=form_dropdown('kelompok_pegawai', $this->dropdowns->kelompok_pegawai(), @$data->kelompok_pegawai, ' class="form-control" id="kelompok_pegawai"');?>
              </div>
              <div class="form-group">
                <label>Status Perkawinan</label>
                <?=form_dropdown('status_perkawinan', $this->dropdowns->status_perkawinan(), @$data->status_perkawinan, ' class="form-control" id="status_perkawinan"');?>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Simpan</button>
			<button class="btn btn-default  btn-block" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Batal...</button>
            </div>
            <!-- /.col-lg-6 (nested) -->
          </form>
          <!-- form/#form_utama -->
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
/*
function simpan(){
		var hasil=validasi_isian();
//		if (hasil!=false) {
				$.ajax({
					type:"POST",
					url: $("#form_sub_t").attr('action'),
					data: $("#form_sub_t").serialize(),
					beforeSend:function(){
						$('.bt_simpan').remove();
					},
					success:function(data){
						gopaging();
						$('#content-wrapper').show();
						$('#form-wrapper').html('');
					}, // end success
					dataType:"html"}); // end ajax
//		} //endif Hasil
}
*/
function validasi_isian(){
	return "";
/*
	var data="";
	var dati="";
			var tgmg = $.trim($("#tanggal_pensiun").val());
			var tpmg = $.trim($("#no_sk").val());
			var tgsk = $.trim($("#tanggal_sk").val());
			var jnps = $.trim($("#jenis_pensiun").val());
			data=data+""+tpmg+"*"+tgmg+"**";
			if( tgmg ==""){	dati=dati+"TANGGAL PENSIUN tidak boleh kosong\n";	}
			if( tpmg ==""){	dati=dati+"NO SK PENSIUN tidak boleh kosong\n";	}
			if( tgsk ==""){	dati=dati+"TANGGAL SK PENSIUN tidak boleh kosong\n";	}
			if( jnps ==""){	dati=dati+"JENIS PENSIUN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
*/
}

$(document).ready(function() {
    if($("input[name='tanggal_lahir']").val() == '00-00-0000'){$("input[name='tanggal_lahir']").val('');}
    $('#datetimePicker').datetimepicker();
    $('form#form_sub_t')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					nama_pegawai: { validators: { notEmpty: true} },
					gelar_belakang: { validators: { notEmpty: false} },
					tempat_lahir: { validators: { notEmpty: true} },
					tanggal_lahir: { validators: { notEmpty: true, date: { format: 'DD-MM-YYYY'}} },
					gender: { validators: { notEmpty: true} },
					agama: { validators: { notEmpty: true} },
					nip_baru: { validators: { numeric: true} },
					nip: { validators: { numeric : true} },
					nomor_hp: { validators: { numeric : true} },
					nomor_tlp_rumah: { validators: { numeric : true} },
					status_perkawinan: { validators: { notEmpty: true} },
					kelompok_pegawai: { validators: { notEmpty: true} },
					status_pegawai: { validators: { notEmpty: true} }
				}
			})
			.on('error.validator.bv', function(e, data){
				/* // Prevent li.active menu become affected */
				$("li.bv-tab-error").removeClass('bv-tab-error');
			})
			.on('success.validator.bv', function(e, data){
				/* // Prevent li.active menu become affected */
				$("li.bv-tab-success").removeClass('bv-tab-success');
			})
			.on('success.form.bv', function(e) {
				// Prevent form submission
				e.preventDefault();

				// Get the form instance
				var $form = $(e.target);

				// Get the BootstrapValidator instance
				var bv = $form.data('bootstrapValidator');

				var data = $("form#form_sub_t").serializeArray();
			<?php /*	// data.push({name: 'ID', value: '<?php echo $id_pegawai;?>'}); */ ?>
				// data.push({name: 'm', value: 'utama'});
				// data.push({name: 'f', value: 'save'});
			   // Use Ajax POST to submit form data
				$.post("<?php echo site_url('appbkpp/pegawai/formsub_penambahan_aksi');?>", data, function(result) {
					
          // enabling submit button for next submit
					// $("div#dropdown11 button:disabled").removeAttr('disabled');
          
					// show alert notification
					$( "#divAddEmployeeForm .col-lg-12" ).prepend( result.msg );
					if( result.status == 'success') {
            // console.log(result);
            window.location.href = result.redir;
            // viewDetailPegawai(result.id_pegawai);
          }
          // set alert notification to automaticaly close
					/**$(".alert").delay(4000).slideUp(200, function() {
            gopaging();
						$('#content-wrapper').show();
						$('#form-wrapper').html('');
						$(this).alert('close');
					});*/
				}, 'json');
			});
      $('#datetimePicker')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#form_sub_t').bootstrapValidator('revalidateField', 'tanggal_lahir');
      });
});
</script>