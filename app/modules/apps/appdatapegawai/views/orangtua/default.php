<div class="row">
	<div class="col-lg-12"  id="form_orangtua">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<h3><i class="fa fa-child fa-fw"></i> Data Orang Tua Pegawai</h3>
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					
				<button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tambah Data Orang Tua"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','orangtua','form','form_orangtua');return false">
					<i class="fa fa-plus-square fa-fw fa-lg"></i>
				</button>
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
<script type="text/javascript">
function delPegOrangtua(ID){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai;?>',
    'ID': ID,
    'm': 'orangtua',
    'f': 'del'
  };
  $.post("<?php echo site_url('datapegawai/del');?>", data, 
    function(result){
      $("#dropdown151").html(result);
    }
  );
}
$(document).ready(function() {
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});
</script>