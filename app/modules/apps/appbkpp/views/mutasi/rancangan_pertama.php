<?php 		date_default_timezone_set('UTC'); ?>
<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row" id="form-wrapper" style="padding-bottom:30px;">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<span id="kopForm">Buat Rancangan Mutasi Pertama</span>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body" style="padding-top:15px; padding-bottom:5px; padding-right:5px; padding-left:5px;">
			<form id="pageFormTo" method="post" action="<?=site_url();?>appbkpp/mutasi/baru_aksi" enctype="multipart/form-data">
				<div id="isiForm">

<div>
	<div style="width:120px; float:left; padding-top:7px;">Judul rancangan</div>
	<div style="width:10px; float:left; padding-top:7px;">:</div>
	<span><div style="display:table;">
		<?=form_input('nama_rancangan',(!isset($isi->nama_rancangan))?'':$isi->nama_rancangan,'class="form-control" style="width:550px; padding-left:2px; padding-right:2px;"');?>
	</div></span>
</div>
<div style="padding-top:5px;">
	<div style="width:120px; float:left; padding-top:7px;">Tahun</div>
	<div style="width:10px; float:left; padding-top:7px;">:</div>
	<span><div style="display:table;">
		<?=form_input('tahun',(!isset($isi->tahun))?'':$isi->tahun,'class="form-control" style="width:50px; padding-left:2px; padding-right:2px;"');?>
		<?=form_hidden('id_rancangan',(!isset($isi->id_rancangan))?'':$isi->id_rancangan);?>
	</div></span>
</div>
<div style="padding-top:5px; padding-bottom:15px">
	<div style="width:120px; float:left; padding-top:7px;">Periode</div>
	<div style="width:10px; float:left; padding-top:7px;">:</div>
	<span><div style="display:table; width:200px;">
		<?=form_input('tmt_jabatan',(!isset($isi->periode))?'':$isi->periode,'class="form-control" style="padding-right:3px;padding-left:3px;"');?>
	</div></span>
</div>
<!--//row-->
				
				
				</div>
				<div id="tbForm" style="text-align:right;">
<button id='btAct' type=button class='btn btn-primary' onclick='simpan(); return false;'><i class='fa fa-save fa-fw'></i> Simpan</button>
				</div>
			</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel-default -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.pageForm -->
<script type="text/javascript">
function simpan(){
				$.ajax({
					type:"POST",
					url: $("#pageFormTo").attr('action'),
					data: $("#pageFormTo").serialize(),
					beforeSend:function(){	
						$('#form-wrapper').html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p>');
					},
					success:function(data){
						location.href = '<?=site_url();?>'+'admin/module/appbkpp/mutasi/rancangan';
					},
					dataType:"html"}); // end ajax
}
</script>