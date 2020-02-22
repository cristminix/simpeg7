<div class="row">
	<div class="col-lg-12"  id="form_pendidikan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<h3><i class="fa fa-graduation-cap fa-fw"></i> Data Pendidikan Pegawai</h3>
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					
				
				
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
			<?php echo @$panel_body;?>
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pencarian Nama Pendidikan / Jurusan</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal_datalama" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Riwayat Pendidikan pada SIKDA Lama</h4>
      </div>
      <div class="modal-body">
			<?php echo $datalama;?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function delPegPendidikan(ID){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai;?>',
    'ID': ID,
    'm': 'pendidikan',
    'f': 'del'
  };
  $.post("<?php echo site_url('datapegawai/del');?>", data, 
    function(result){
      $("#dropdown15").html(result);
    }
  );
}
$(document).ready(function() {
    $('#myModal_datalama').on('show.bs.modal', function (e) {
      $('#myModal_datalama .modal-body').css('overflow-y', 'auto'); 
      $('#myModal_datalama .modal-body').css('height', $(window).height() * 0.7);        
      $('#myModal_datalama .modal-dialog').css('width', $(window).width() * 0.7);        
    });
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});
</script>