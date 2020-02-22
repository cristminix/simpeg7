<tr id="row_tt" class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
	<td>
		
		<div style="clear:both;">
			
			<div style="float:left;"><input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?=(!isset($val->tanggal_mulai))?'':$val->tanggal_mulai;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		<div style="clear:both;">
			
			<div style="float:left;"><input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?=(!isset($val->tanggal_selesai))?'':$val->tanggal_selesai;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		
	</td>
	
	<td>
	<div style="clear:both;">
		<?=form_textarea('nama_diklat',(!isset($val->nama_diklat))?'':$val->nama_diklat,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
	</td>
	<td>
	<div style="clear:both;">
			<?=form_textarea('tempat_diklat',(!isset($val->tempat_diklat))?'':$val->tempat_diklat,'class="form-control row-fluid" style="height:90px;"');?>
		</div>
	</td>
	<td>
		
		<div style="clear:both;">
			<div style="float:left; width:90px;">No. SK</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><input type="text" class="form-control row-fluid" id="nomor_sk" name="nomor_sk" value="<?=(!isset($val->nomor_sk))?'':$val->nomor_sk;?>" style="height:30px;padding:1px 0px 0px 5px;"></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:90px;">Tanggal SK</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><input type="text" class="form-control" id="tanggal_sk" name="tanggal_sk" value="<?=(!isset($val->tanggal_sk))?'':$val->tanggal_sk;?>" placeholder="dd-mm-yyyy" style="height:30px;padding:1px 0px 0px 5px;"></div>
		</div>
		
			<div style="clear:both;">
			<div style="float:left; width:90px;">Jenis Diklat</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;">
			<select class="form-control" id="jenis_diklat" name="jenis_diklat" style="height:30px;widht:100px;padding:1px 0px 0px 5px;" <?=(!isset($val->jenis_diklat));?> >
				<option value="">Pilih...</option>
				<option value="umum" <?=(isset($val->jenis_diklat) && $val->jenis_diklat=="umum")?"selected":"";?>>Umum</option>
				<option value="teknik" <?=(isset($val->jenis_diklat) && $val->jenis_diklat=="teknik")?"selected":"";?>>Teknik</option>
				<option value="seminar_umum" <?=(isset($val->jenis_diklat) && $val->jenis_diklat=="seminar_umum")?"selected":"";?>>Seminar Umum</option>
				<option value="seminar_teknik" <?=(isset($val->jenis_diklat) && $val->jenis_diklat=="seminar_teknik")?"selected":"";?>>Seminar Teknik</option>
				<option value="workshop_umum" <?=(isset($val->jenis_diklat) && $val->jenis_diklat=="workshop_umum")?"selected":"";?>>Workshop Umum</option>
				<option value="workshop_teknik" <?=(isset($val->jenis_diklat) && $val->jenis_diklat=="workshop_teknik")?"selected":"";?>>Workshop Teknik</option>
			</select>
			</div></span>
		</div>
		
	</td>
</tr>

			<tr id="row_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
<?php if(isset($val->id_peg_diklat)){	?>
			<input type=hidden name="id_peg_diklat" id="id_peg_diklat" value="<?=$val->id_peg_diklat;?>">
<?php	}	?>
			<div class="btn btn-primary" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Simpan</div>
			<button class="btn batal btn-default" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
</tr>
