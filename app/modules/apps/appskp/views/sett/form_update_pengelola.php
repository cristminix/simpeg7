<table>
	<tr>
		<td style="width:150px;">Nama pengelola</td>
		<td style="width:10px;">:</td>
		<td style="width:350px;">
		<?=form_input('nama_user',(!isset($pengelola->nama_user))?'':$pengelola->nama_user,'class="form-control" style="padding-left:2px; padding-right:2px;"');?>
		<?=form_hidden('user_id',(!isset($pengelola->user_id))?'':$pengelola->user_id);?>
		</td>
	</tr>
	<tr>
		<td>Username</td>
		<td>:</td>
		<td>
		<?=form_input('username',(!isset($pengelola->username))?'':$pengelola->username,'class="form-control" style="padding-left:2px; padding-right:2px;"');?>
		</td>
	</tr>
</table>