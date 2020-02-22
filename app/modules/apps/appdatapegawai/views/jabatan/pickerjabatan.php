<div class="row">
  <form role="form" onsubmit="return false;" id="form_picker_jabatan">
    <div class="col-lg-4">
      <div class="form-group">
        <?php $jenis_jabatan = $this->dropdowns->jenis_jabatan();?>
        <?php unset($jenis_jabatan['js']);?>
        <?=form_dropdown('nama_jenis_jabatan',$jenis_jabatan,'','class="form-control"');?>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Nama jabatan Fungsional" name="nama_jabatan_jf">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button" id="pickercaribtn">Cari</button>
          </span>
          <!-- /input-group-btn -->
         </div>
         <!-- /input-group -->
      </div>
    </div>
  </form>
</div>
<!-- /row -->
<div class="row" id="resultareapicker">
</div>
<!-- /row -->
<script type="text/javascript">
$(document).ready(function() {
  $('#myModal_pickerjabatan #pickercaribtn').on('click', function (e) {
    var data = {
        nama_jenis_jabatan:$('#myModal_pickerjabatan select[name="nama_jenis_jabatan"]').val(),
        nama_jabatan_jf:$('#myModal_pickerjabatan input[name="nama_jabatan_jf"]').val()
      };
      if(data.nama_jabatan_jf == '' ){
        
        alert('Isi Nama Jabatan yang akan dicari !');
        
      }else{
        $.post("<?php echo site_url('appdatapegawai/jabatan/getjabatan');?>", data, function(result) {
          $('#myModal_pickerjabatan #resultareapicker').html(result);
          $('#myModal_pickerjabatan .modal-body').html();
        });
      }
  });
});
</script>

