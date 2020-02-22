		<div class="row">
      <form role="form" onsubmit="return false;">
        <div class="col-lg-10">
          <div class="form-group input-group">
            <input type="text" class="form-control" placeholder="Nama Unor" name="picker_nama_unor">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" id="pickercaribtn">Cari</button>
            </span>
          </div>
        </div>
        <!-- /col-lg-6 -->
      </form>
    </div>
    <!-- /row -->
    <div class="row" id="resultareapicker">
    </div>
    <!-- /row -->
<script type="text/javascript">
$(document).ready(function() {
  $('#myModal_pickerunor #pickercaribtn').on('click', function (e) {
    var data = {
        nama_unor:$('#myModal_pickerunor input[name="picker_nama_unor"]').val(),
      };
      if(data.nama_unor == ''  ){
        
        alert('Ketikkan nama unor yang akan dicari.');
        
      }else{
        $.post("<?php echo site_url('appdatapegawai/jabatan/getunor');?>", data, function(result) {
          $('#myModal_pickerunor #resultareapicker').html(result);
          $('#myModal_pickerunor .modal-body').html();
        });
      }
  });
});
</script>

