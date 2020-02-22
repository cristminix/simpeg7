<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td style="padding:0px;">
		<?=form_input('tmt_golongan',(!isset($val->tmt_golongan))?'':$val->tmt_golongan,'class="form-control row-fluid" placeholder="dd-mm-yyyy" style="padding-left:5px;padding-right:5px;" id="tmt_jabatan"');?>
	</td>
	<td style="padding:0px;">
	<div style="clear:both;">
			<span><div style="display:table;"><input type="text" class="form-control row-fluid" id="kode_pangkat" name="kode_pangkat" value="<?=(!isset($val->kode_pangkat))?'':$val->kode_pangkat;?>" style="height:30px;padding:1px 0px 0px 5px;"></div></span>
		</div>
		</td>
	<td style="padding:0px;">
		<?=form_dropdown('kode_golongan',$this->dropdowns->kode_golongan_pangkat(),(!isset($val->kode_golongan))?'':$val->kode_golongan,'class="form-control" style="padding-left:2px; padding-right:2px; float:left;"');?>
	</td>
	<td>
	<div style="clear:both;">
			<span><div style="display:table;"><input type="text" class="form-control row-fluid" id="nama_golongan" name="nama_golongan" value="<?=(!isset($val->nama_golongan))?'':$val->nama_golongan;?>" style="height:30px;padding:1px 0px 0px 5px;"></div></span>
		</div>
	</td>
	<td id="ipt_jabatan">
		
		<div style="clear:both;">
			<div style="float:left; width:130px;">No. SK</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><input type="text" class="form-control row-fluid" id="sk_nomor" name="sk_nomor" value="<?=(!isset($val->sk_nomor))?'':$val->sk_nomor;?>" style="height:30px;padding:1px 0px 0px 5px;"></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Tanggal SK</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><input type="text" class="form-control" id="sk_tanggal" name="sk_tanggal" value="<?=(!isset($val->sk_tanggal))?'':$val->sk_tanggal;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		
	</td>
</tr>

			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
<?php if(isset($val->id_peg_golongan)){	?>
			<input type=hidden name="id_peg_golongan" id="id_peg_golongan" value="<?=$val->id_peg_golongan;?>">
<?php	}	?>
			<div class="btn btn-primary btn-danger btn-xs" onclick="hapus();"><i class="fa fa-save fa-fw"></i> Hapus</div>
			<button class="btn batal btn-default btn-xs" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>