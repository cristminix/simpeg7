<div class="row">
	<div class="col-lg-12"  id="form_kepangkatan">
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
			<i class="fa fa-signal fa-fw"></i> Riwayat Diklat Pegawai
<!--
        <button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tanbah Data Kepangkatan"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','kepangkatan','form','form_kepangkatan')">
					<i class="fa fa-plus-square fa-fw fa-lg"></i>
				</button>
				<button   data-toggle="modal" data-target="#myModal_datalama_golongan"
					class="btn btn-success btn-xs" type="button" title="Lihat Referensi Data Golongan">
					<i class="fa fa-search fa-fw fa-lg"></i> Lihat Riwayat Kepangkatan pada Data SIKDA Lama
				</button>
-->					
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
<div class="modal fade" id="myModal_datalama_diklat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Riwayat Kepangkatan pada SIKDA Lama</h4>
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
function delPegKepangkatan(ID){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai;?>',
    'ID': ID,
    'm': 'kepangkatan',
    'f': 'del'
  };
  $.post("<?php echo site_url('datapegawai/del');?>", data, 
    function(result){
      $("#dropdown23").html(result);
    }
  );
}
$(document).ready(function() {
    $('#myModal_datalama_golongan').on('show.bs.modal', function (e) {
      $('#myModal_datalama_golongan .modal-body').css('overflow-y', 'auto'); 
      $('#myModal_datalama_golongan .modal-body').css('height', $(window).height() * 0.7);        
      $('#myModal_datalama_golongan .modal-dialog').css('width', $(window).width() * 0.7);        
    });
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});
</script>