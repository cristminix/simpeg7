<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td id="ipt_kontrak">
		
	<div style="clear:both;">
			
			<span><div style="display:table float:center"><input type="text" readonly="readonly" class="form-control row-fluid" id="tmt_kontrak" name="tmt_kontrak" value="<?=(!isset($val->tmt_kontrak))?'':$val->tmt_kontrak;?>" style="height:30px;padding:1px 0px 0px 5px;" ></div></span>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" readonly="readonly" class="form-control" id="mk_th" name="mk_th" value="<?=(!isset($val->mk_th))?'':$val->mk_th;?>"  style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" readonly="readonly" class="form-control" id="mk_bl" name="mk_bl" value="<?=(!isset($val->mk_bl))?'':$val->mk_bl;?>" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" readonly="readonly" class="form-control" id="sk_nomor" name="sk_nomor" value="<?=(!isset($val->sk_nomor))?'':$val->sk_nomor;?>" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" readonly="readonly" class="form-control" id="sk_tanggal" name="sk_tanggal" value="<?=(!isset($val->sk_tanggal))?'':$val->sk_tanggal;?>" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>

		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="sk_pejabat" name="sk_pejabat" value="<?=(!isset($val->sk_pejabat))?'':$val->sk_pejabat;?>" placeholder="Pejabat Penetap" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
</tr>
<?php if(isset($val->id)){	?>
			<input type=hidden name="id" id="id" value="<?=$val->id;?>">
<?php	}	?>
			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
			<div class="btn btn-primary btn-danger btn-xs" onclick="hapus();"><i class="fa fa-save fa-fw"></i> Hapus</div>
			<button class="btn batal btn-default btn-xs" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>