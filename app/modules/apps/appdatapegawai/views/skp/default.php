<div class="row">
	<div class="col-lg-12"  id="form_skp">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<h3><i class="fa fa-trophy fa-fw"></i> Data SKP Pegawai</h3>
		<div class="panel panel-success">
			<div class="panel-heading row-fluid">
					
				<button data-toggle="dropdown" 
					class="btn btn-primary btn-xs" type="button" title="Tambah Data SKP"
					onclick="loadForm('<?php echo $id_pegawai;?>','add','skp','form','form_skp');return false">
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
