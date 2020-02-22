<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td id="ipt_pengalaman">
		<div style="clear:both;">
		<?=form_textarea('perusahaan',(!isset($val->perusahaan))?'':$val->perusahaan,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
		</td>
	<td>
		<div style="clear:both;">
		<?=form_textarea('pekerjaan',(!isset($val->pekerjaan))?'':$val->pekerjaan,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
		</td>	
	<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?=(!isset($val->tanggal_awal))?'':$val->tanggal_awal;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?=(!isset($val->tanggal_akhir))?'':$val->tanggal_akhir;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
		<?=form_textarea('jabatan',(!isset($val->jabatan))?'':$val->jabatan,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
		</td>
		
</tr>
<?php if(isset($val->id_peg_pengalaman)){	?>
			<input type=hidden name="id_peg_pengalaman" id="id_peg_pengalaman" value="<?=$val->id_peg_pengalaman;?>">
<?php	}	?>
			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
			<div class="btn btn-primary btn-danger btn-xs" onclick="hapus();"><i class="fa fa-save fa-fw"></i> Hapus</div>
			<button class="btn batal btn-default btn-xs" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>