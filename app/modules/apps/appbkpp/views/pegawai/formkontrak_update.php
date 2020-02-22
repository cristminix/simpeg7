<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td id="ipt_kontrak">
		
		<div style="clear:both;">
			
			<span><div style="display:table float:center"><input type="text" class="form-control row-fluid" id="tmt_kontrak" name="tmt_kontrak" value="<?=(!isset($val->tmt_kontrak))?'':$val->tmt_kontrak;?>" style="height:30px;padding:1px 0px 0px 5px;" placeholder="dd-mm-yyyy"></div></span>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="mk_th" name="mk_th" value="<?=(!isset($val->mk_th))?'':$val->mk_th;?>" placeholder="yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="mk_bl" name="mk_bl" value="<?=(!isset($val->mk_bl))?'':$val->mk_bl;?>" placeholder="mm" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="sk_nomor" name="sk_nomor" value="<?=(!isset($val->sk_nomor))?'':$val->sk_nomor;?>" placeholder="No SK" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>
		
		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="sk_tanggal" name="sk_tanggal" value="<?=(!isset($val->sk_tanggal))?'':$val->sk_tanggal;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>

		<td>
		<div style="clear:both;">
			<div style="float:center"><input type="text" class="form-control" id="sk_pejabat" name="sk_pejabat" value="<?=(!isset($val->sk_pejabat))?'':$val->sk_pejabat;?>" placeholder="Pejabat Penetap" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		</td>


		<!--td>
		<div style="clear:both;">
			<?=form_textarea('uraian',(!isset($val->uraian))?'':$val->uraian,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
		
		</td-->
	
</tr>

			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
<?php if(isset($val->id)){	?>
			<input type=hidden name="id" id="id" value="<?=$val->id;?>">
<?php	}	?>
			<div class="btn btn-primary" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Simpan</div>
			<button class="btn batal btn-default" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>