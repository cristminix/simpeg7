<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<h3><i class="fa fa-file-picture-o fa-fw"></i> Foto Pegawai</h3>
		<div class="panel panel-success">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<div class="row">
          <form role="form" id="form_foto" enctype="multipart/form-data" accept-charset="utf-8" method="post" >
            <div class="col-lg-4">
              <img src="<?php echo $fotoSrc;?>" alt="Foto Pegawai" class="img-responsive img-thumbnail">
            
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-8">

              <div class="form-group">
                <label for="file_foto">File Foto</label>
                <input type="file" id="file_foto" name="file_foto">
                <p class="help-block">Pilih file Foto .</p>
              </div>
              
              <button type="submit" class="btn btn-primary btn-block">Upload</button>
              <div class="progress">
                <div class="bar"></div >
                <div class="percent">0%</div >
              </div>
              
              <div id="status"></div>
            </div>
            <!-- /.col-lg-6 (nested) -->
          </form>
          
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
  
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
  
  // uploading ile script using jquery form (malsup)
  var bar = $('.bar');
  var percent = $('.percent');
  var status = $('#status');
  
  $('form#form_foto')
    beforeSend: function() {
      status.empty();
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    success: function() {
      var percentVal = '100%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    complete: function(xhr) {
      status.html(xhr.responseText);
    }
  }); 
  
  $('form#form_foto')
  .bootstrapValidator({
    // excluded:":disabled",
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      file_foto: {
        validators: {
          file: {
            extension: 'jpg',
            // type: 'application/jpg',
            message: 'Silahkan pilih file dengan ekstensi <em>jpg</em>.'
          }
        }
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
     $form.ajaxSubmit();
    
    // var data = $("form#form_foto").serializeArray();
    // data.push({name: 'ID', value: '<?php echo $id_pegawai;?>'});
    // data.push({name: 'm', value: 'foto'});
    // data.push({name: 'f', value: 'save'});
    // $.post("<?php echo site_url('appdatapegawai/foto/upload');?>", data, function(result) {
      // $("div#dropdown16").html(result);
    // });
  });
  
});
</script>
