<div class="row">
	<div class="col-lg-12"  id="form_jabatan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<div class="panel panel-success">
			<div class="panel-heading row-fluid">
				<i class="fa fa-tasks fa-fw"></i> Riwayat Jabatan Pegawai
<!--					
				<button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tambah Data Jabatan Struktural"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','jabatan','form_js','form_jabatan');return false">
					<i class="fa fa-plus-square fa-fw fa-lg"></i> Jab. Struktural
				</button>
					
				<button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tambah Data Jabatan Fungsional"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','jabatan','form_jf','form_jabatan');return false">
					<i class="fa fa-plus-square fa-fw fa-lg"></i> Jab. Fungsional
				</button>
-->
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
			<?php //echo @$panel_body;?>
			<?php echo @$panel_body;?>
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- Modal -->
<div class="modal fade" id="myModal_pickerunor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pencarian UNOR</h4>
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
<div class="modal fade" id="myModal_pickerjabatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pencarian Jabatan Fungsional</h4>
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
<div class="modal fade" id="myModal_datalama_jabatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Riwayat Jabatan pada SIKDA Lama</h4>
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
function delPegJabatan(ID){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai;?>',
    'ID': ID,
    'm': 'jabatan',
    'f': 'del'
  };
  $.post("<?php echo site_url('datapegawai/del');?>", data, 
    function(result){
      $("#dropdown24").html(result);
    }
  );
}
$(document).ready(function() {
    $('#myModal_pickerunor').on('show.bs.modal', function (e) {
      $('#myModal_pickerunor .modal-body').css('overflow-y', 'auto'); 
      $('#myModal_pickerunor .modal-body').css('height', $(window).height() * 0.7);        
      $('#myModal_pickerunor .modal-dialog').css('width', $(window).width() * 0.7);        
      var data = {
        name:'id_unor',
        m:'jabatan',
        f:'pickerunor'
      };
      $.post("<?php echo site_url('datapegawai/picker');?>", data, function(result) {
        $('#myModal_pickerunor .modal-body').html(result);
      });
    });
    $('#myModal_pickerjabatan').on('show.bs.modal', function (e) {
      $('#myModal_pickerjabatan .modal-body').css('overflow-y', 'auto'); 
      $('#myModal_pickerjabatan .modal-body').css('height', $(window).height() * 0.7);        
      $('#myModal_pickerjabatan .modal-dialog').css('width', $(window).width() * 0.7);        
      var data = {
        name:'id_jabatan',
        m:'jabatan',
        f:'pickerjabatan'
      };
      $.post("<?php echo site_url('datapegawai/picker');?>", data, function(result) {
        $('#myModal_pickerjabatan .modal-body').html(result);
      });
    });
    $('#myModal_datalama_jabatan').on('show.bs.modal', function (e) {
      $('#myModal_datalama_jabatan .modal-body').css('overflow-y', 'auto'); 
      $('#myModal_datalama_jabatan .modal-body').css('height', $(window).height() * 0.7);        
      $('#myModal_datalama_jabatan .modal-dialog').css('width', $(window).width() * 0.7);        
    });
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});
</script>