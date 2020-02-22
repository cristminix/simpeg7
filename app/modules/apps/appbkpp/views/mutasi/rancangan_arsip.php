<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
<table style="width:1024px;" class="table table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th style="width:25px;">No.</th>
<th style="width:35px;">PILIH</th>
<th style="width:150px;">TAHUN</th>
<th style="width:550px;">JUDUL RANCANGAN</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach($rancangan AS $key=>$val){
?>
<tr id='row_<?=$val->id_rancangan;?>'>
<td id='nomor_<?=$val->id_rancangan;?>'><?=$no;?></td>
<td id='aksi_<?=$val->id_rancangan;?>' align=center>
	<button class="btn btn-primary btn-xs" type="button" onclick="iniRANCANGAN(<?=$val->id_rancangan;?>);" data-dismiss="modal" title='Klik untuk memilih rancangan'><span class="fa fa-check"></span>
</td>
<td id='periode_<?=$val->id_rancangan;?>'>
<?=$val->tahun;?>
</td>
<td id='penilai_<?=$val->id_rancangan;?>'>
<?=$val->nama_rancangan;?>
</td>
</tr>
<?php
$no++;
}
?>
</table>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<script type="text/javascript">
function iniRANCANGAN(idd){
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/mutasi/alih_rancangan",
		data:{"idd": idd },
		beforeSend:function(){	
			$('#form-wrapper').html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p>');
		},
        success:function(data){
			location.href = '<?=site_url();?>'+'admin/module/appbkpp/mutasi/rancangan';
		},
        dataType:"html"});
}
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>