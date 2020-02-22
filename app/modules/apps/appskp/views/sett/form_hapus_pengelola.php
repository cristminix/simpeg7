<table>
	<tr>
		<td style="width:150px;">Nama pengelola</td>
		<td style="width:10px;">:</td>
		<td style="width:350px;">
		<?=$pengelola->nama_user;?>
		<?=form_hidden('user_id',$pengelola->user_id);?>
		</td>
	</tr>
	<tr>
		<td>Username</td>
		<td>:</td>
		<td>
		<?=$pengelola->username;?>
		</td>
	</tr>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$('#modalButtonAksi').attr('onclick','set_pengelola_aksi();').html('<i class="fa fa-trash fa-fw"></i> Hapus').show();
});
</script>
