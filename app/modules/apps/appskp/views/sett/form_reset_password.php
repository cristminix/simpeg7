<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i> <b>Data Pengguna</b></div>
			<div class="panel-body">
								<div style="height:30px;">
										<div style="float:left; width:110px; height:35px;">Nama pengguna</div>
										<span> : </span>
										<span><?=$user->nama_user;?></span>
								</div>
								<div style="height:30px; clear:both;">
										<div style="float:left; width:110px; height:35px;">Username</div>
										<span> : </span>
										<span><?=$user->username;?></span>
								</div>
								<div style="height:30px; clear:both;">
										<div style="float:left; width:110px;">Grup pengguna</div>
										<span> : </span>
										<span><?=$user->group;?></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-recycle fa-fw"></i><b> Form Reset Password</b></div>
			<div class="panel-body">
<form id="pw-form" method="post" action="<?=site_url('appskp/sett/reset_password_aksi');?>" enctype="multipart/form-data">
<table>
<tr>
<td style="width:180px;">Masukkan password baru</td>
<td style="text-align:center;width:20px;">:</td>
<td><input type=password class="form-control" name=pw1></td>
</tr>
<tr>
<td style="width:180px;">Ulangi password baru</td>
<td style="text-align:center;width:20px;">:</td>
<td><input type=password class="form-control" name=pw2></td>
</tr>
<tr>
<td colspan=2>&nbsp;</td>
<td style="padding-top:10px;">
<button class="btn btn-primary" id="pwButtonAksi" onclick="set_password_aksi(); return false;"><i class="fa fa-save fa-fw"></i> Simpan</button>
<button class="btn btn-primary" onclick="kembali(); return false;"><i class="fa fa-close fa-fw"></i> Batal</button>
</td>
</tr>
</table>
</form>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<script type="text/javascript">
function set_password_aksi(){
			$.ajax({
			type:"POST",
			url:	$("#pw-form").attr('action'),
			data:$("#pw-form").serialize(),
			beforeSend:function(){	
				$('#pwButtonAksi').hide();
				$('#page-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				if(data=="success"){
					kembali();
				} else {
					loadSegment('page-wrapper','appskp/sett/reset_password');
				}
			},
			dataType:"html"});
}
function kembali(){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/sett/<?=$asal;?>",
			data:{"hal": <?=$hal;?>,"cari":"<?=$cari;?>","batas":<?=$batas;?> },
			beforeSend:function(){	
				$("#page-wrapper").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				$('#page-wrapper').html(data);
			},
			dataType:"html"});
}
</script>
