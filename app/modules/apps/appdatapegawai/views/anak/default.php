<div class="row">
	<div class="col-lg-12"  id="form_anak">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<h3><i class="fa fa-child fa-fw"></i> Data Anak Pegawai</h3>
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					
				<button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tambah Data Anak"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','anak','form','form_anak');return false">
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
function delPegAnak(ID){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai;?>',
    'ID': ID,
    'm': 'anak',
    'f': 'del'
  };
  $.post("<?php echo site_url('datapegawai/del');?>", data, 
    function(result){
      $("#dropdown14").html(result);
    }
  );
}
$(document).ready(function() {
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});
</script>