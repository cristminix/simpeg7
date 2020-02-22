<div class="row">
	<div class="col-lg-12"  id="form_pernikahan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<h3><i class="fa fa-institution fa-fw"></i> Data Pernikahan Pegawai</h3>
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					
				<button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tambah Data Pernikahan"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','pernikahan','form','form_pernikahan');return false">
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
function delPegPernikahan(ID){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai;?>',
    'ID': ID,
    'm': 'pernikahan',
    'f': 'del'
  };
  $.post("<?php echo site_url('datapegawai/del');?>", data, 
    function(result){
      $("#dropdown13").html(result);
    }
  );
}
$(document).ready(function() {
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});

function jumptoform(h){
    var url = location.href;               //Save down the URL without hash.
    location.href = "#"+h;                 //Go to the target element.
    history.replaceState(null,null,url);   //Don't like hashes. Changing it back.
}
</script>