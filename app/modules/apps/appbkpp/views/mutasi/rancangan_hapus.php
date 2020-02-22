<div>
	<div style="width:120px; float:left;">Judul rancangan</div>
	<div style="width:10px; float:left;">:</div>
	<span><div style="display:table;"><?=$isi->nama_rancangan;?></div></span>
</div>
<div style="padding-top:5px;clear:both;">
	<div style="width:120px; float:left;">Tahun</div>
	<div style="width:10px; float:left;">:</div>
	<span><div style="display:table;"><?=$isi->tahun;?>
		<?=form_hidden('id_rancangan',(!isset($isi->id_rancangan))?'':$isi->id_rancangan);?>
	</div></span>
</div>
<div style="padding-top:5px; padding-bottom:15px;clear:both;">
	<div style="width:120px; float:left;">Periode</div>
	<div style="width:10px; float:left;">:</div>
	<span><div style="display:table; width:100px;">
		<?=$isi->periode;?>
	</div></span>
</div>
<!--//row-->

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