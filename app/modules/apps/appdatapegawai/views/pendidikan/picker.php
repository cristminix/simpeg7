<div class="row">
  <form role="form" class="form-inline" onsubmit="return false;">
    <div class="form-group">
      <?=form_dropdown('kode_jenjang',$this->dropdowns->kode_jenjang_pendidikan(),(!isset($row->kode_jenjang))?'':$row->kode_jenjang,'class="form-control" id="pick_kode_jenjang"');?>
    </div>
    <div class="form-group">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Pendidikan / Jurusan"  id="pick_nama_pendidikan">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="button" id="pickercaribtn">Cari</button>
        </span>
        <!-- /input-group-btn -->
       </div>
       <!-- /input-group -->
    </div>
  </form>
</div>
<!-- /row -->
<div class="row" id="resultareapicker">
</div>
<!-- /row -->
<script type="text/javascript">
$(document).ready(function() {
  $('#myModal #pickercaribtn').on('click', function (e) {
    var data = {
        kode_jenjang:$("#myModal #pick_kode_jenjang").val(),
        pendidikan:$("#myModal #pick_nama_pendidikan").val()
      };
      if(data.pendidikan == '' && data.kode_jenjang == '' ){
        
        alert('Belum memilih Jenjang Pendidikan atau mengisi Nama Pendidikan yang akan dicari.');
        
      }else{
        $.post("<?php echo site_url('appdatapegawai/pendidikan/getpendidikan');?>", data, function(result) {
          $('#myModal #resultareapicker').html(result);
          $('#myModal .modal-body').html();
        });
      }
  });
});
</script>

