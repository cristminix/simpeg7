<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard barrrr</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row"> 
  <div class="col-lg-8">
    <div class="panel panel-primary">
      <div class="panel-heading">
          Ringkasan SKP Anda
      </div>
      <div class="panel-body">
		<div class="list-group">
				<div class="list-group-item">
						<div class="row">
								<div class="col-lg-4">Nama Pegawai</div>
								<div class="col-lg-8" style="text-align:right;">
									<strong>
										<?=(trim($peg->gelar_depan) != '-')?trim($peg->gelar_depan).' ':'';?><?=(trim($peg->gelar_nonakademis) != '-')?trim($peg->gelar_nonakademis).' ':'';?><?=$peg->nama_pegawai;?><?=(trim($peg->gelar_belakang) != '-')?', '.trim($peg->gelar_belakang):'';?>
									</strong>
								</div>
						</div>
				</div>
				<div class="list-group-item">
					<i class="fa fa-flag fa-fw"></i> Total SKP Dibuat
					<span class="pull-right text-muted "><strong><?php echo count($skp);?></strong></span>
				</div>
		</div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div> 
  <!-- /.col-lg-8 -->
  <div class="col-lg-4"> 
			<div class="panel panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-tasks fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?php echo count($kelola_skp);?></div>
							<div>Pegawai</div>
						</div>
					</div>
				</div>
				<a href="<?php echo site_url('admin/module/appskp/skp_kelola');?>">
				<div class="panel-footer">
					<span class="pull-left">Menunggu Persetujuan Target SKP</span>
					<span class="pull-right">Lihat Detail <i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-fire fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge"><?php echo count($kelola_realisasi);?></div>
							<div>Pegawai</div>
						</div>
					</div>
				</div>
				<a href="<?php echo site_url('admin/module/appskp/realisasi_kelola');?>">
				<div class="panel-footer">
					<span class="pull-left">Menunggu Persetujuan Realisasi SKP</span>
					<span class="pull-right">Lihat Detail <i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
				</a>
			</div>
		</div>
</div> 
<!-- /.row -->
<?php if(1<0): ?>
<input type="text" id="currency" />
<script type="text/javascript">
$(document).ready(function() {
	$('#currency').maskMoney(
		{
			thousands:' ', 
			decimal:'.', 
			allowZero:true
		}
	);
});
</script>
<?php endif;?>