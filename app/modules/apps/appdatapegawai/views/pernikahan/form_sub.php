<h5><i class="fa fa-edit fa-fw"></i> Form Tunjangan Pernikahan [<?php echo isset($row->id) ? 'Sunting #' . $row->id : 'Entri Baru' ;?>]</h5>
<div class="panel panel-success">
  <div class="panel-heading">
  </div>
  <div class="panel-body">
    <div class="row">
      <form role="form" id="<?php printf('form_pernikahan_tunj%s', $id_peg_perkawinan);?>">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Status Tunjangan</label>
            
            <?php echo 
            form_dropdown('status_tunjangan',
              $this->dropdowns->alwMarStat(),
                !isset($row->status_tunjangan) ? 
                  '':
                  $row->status_tunjangan, 
                ' class="form-control" '
            );?>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <?php echo form_input('keterangan',(!isset($row->keterangan))?'':$row->keterangan,'class="form-control"');?>
          </div>
          
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-6">
          
          <div class="form-group">
            <label>Tanggal Efektif</label>
              <div class="dateContainer">
                <div class="input-group date datetimePicker" id="tgl_efektif">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  <?php 
                  $thisdate = intval($row->tgl_efektif) ? date('d-m-Y', strtotime($row->tgl_efektif)) : '';
                  echo form_input('tgl_efektif',$thisdate,'class="form-control" id="tgl_efektif'.$id_peg_perkawinan.'" placeholder="DD-MM-YYYY"  data-date-format="DD-MM-YYYY"');?>
                </div>
                <!-- /.input-group date datetimePicker -->
              </div>
              <!-- /.dateContainer -->
          </div>
          
          
        <button type="submit" class="btn btn-success btn-block">Simpan</button>
          <!-- <button class="btn btn-warning btn-block" type="button" onclick="cancelForm('form_pernikahan');return false">BATAL</button>
        </div> -->
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
    
    if($("input[name='tgl_efektif']").val() == '00-00-0000'){$("input[name='tgl_efektif']").val('');}
    $('.datetimePicker #<?php printf('tgl_efektif%s', $id_peg_perkawinan);?>').datetimepicker();
    $('form#<?php printf('form_pernikahan_tunj%s', $id_peg_perkawinan);?>')
			.bootstrapValidator({
				// excluded:":disabled",
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					tgl_efektif: { validators: {  date: { format: 'DD-MM-YYYY'} } } ,
          status_tunjangan: { validators: { notEmpty: true} } 
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
        var idpeg = $('#span_id_pegawai').val();

				var data = $("form#<?php printf('form_pernikahan_tunj%s', $id_peg_perkawinan);?>").serializeArray();
        data.push({name: 'id_pegawai', value: idpeg});
        data.push({name: 'id_sub', value: '<?php echo $id_peg_perkawinan;?>'});
        data.push({name: 'ID', value: '<?php echo (!isset($row->id))?'add':$row->id;?>'});
        data.push({name: 'm', value: 'pernikahan'});
        data.push({name: 'f', value: 'save_sub'});
			   // Use Ajax POST to submit form data
        $.post("<?php echo site_url('datapegawai/submitformsubriwayat');?>",data, function(result) {
          $("#dropdown13").html(result);
				});
			});
      $('.datetimePicker #<?php printf('tgl_efektif%s', $id_peg_perkawinan);?>')
        .on('dp.change dp.show', function (e) {
            // Revalidate the date when user change it
            $('form#<?php printf('form_pernikahan_tunj%s', $id_peg_perkawinan);?>').bootstrapValidator('revalidateField', 'tgl_efektif');
      });
});
</script>
