<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td id="ipt_penghargaan">
		
		<div style="clear:both;">
			<span><div style="display:table;"><input type="text" class="form-control row-fluid" id="nomor_sk" name="nomor_sk" value="<?=(!isset($val->nomor_sk))?'':$val->nomor_sk;?>" style="height:30px;padding:1px 0px 0px 5px;"></div></span>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:left;"><input type="text" class="form-control" id="tanggal_sk" name="tanggal_sk" value="<?=(!isset($val->tanggal_sk))?'':$val->tanggal_sk;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<?=form_textarea('uraian',(!isset($val->uraian))?'':$val->uraian,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
		</td>
</tr>
<?php if(isset($val->id_peg_penghargaan)){	?>
			<input type=hidden name="id_peg_penghargaan" id="id_peg_penghargaan" value="<?=$val->id_peg_penghargaan;?>">
<?php	}	?>
			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
			<div class="btn btn-primary btn-danger btn-xs" onclick="hapus();"><i class="fa fa-save fa-fw"></i> Hapus</div>
			<button class="btn batal btn-default btn-xs" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>