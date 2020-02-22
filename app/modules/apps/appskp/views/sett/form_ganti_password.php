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
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=$user['nama_user'];?></div></span>
								</div>
								<div style="height:30px; clear:both;">
										<div style="float:left; width:110px; height:35px;">Username</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=$user['username'];?></div></span>
								</div>
								<div style="height:30px; clear:both;">
										<div style="float:left; width:110px;">Grup pengguna</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=$user['group_name'];?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i><b> Form Ganti Password</b></div>
			<div class="panel-body">
<form id="pw-form" method="post" action="<?=site_url('appskp/sett/ganti_password_aksi');?>" enctype="multipart/form-data">
<table>
<tr>
<td style="width:140px;">Password baru</td>
<td style="text-align:center;width:10px;">:</td>
<td><input type=password class="form-control" name=pw1></td>
</tr>
<tr>
<td style="width:140px;">Ulangi password baru</td>
<td style="text-align:center;width:10px;">:</td>
<td><input type=password class="form-control" name=pw2></td>
</tr>
<tr>
<td colspan=2>&nbsp;</td>
<td style="padding-top:10px;">
<button class="btn btn-primary" id="pwButtonAksi" onclick="set_password_aksi(); return false;"><i class="fa fa-save fa-fw"></i> Simpan</button>
<a href="<?=site_url('admin/');?>"><div class="btn btn-default"><i class="fa fa-close fa-fw"></i> Batal...</div></a>
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
					location.href = "<?=site_url('login/out');?>";
				} else {
					loadSegment('page-wrapper','appskp/sett/ganti_password');
				}
			},
			dataType:"html"});
}
</script>
