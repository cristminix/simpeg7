	<td colspan=2 align=right>KOREKSI</td>
	<td colspan=8>
	<div><b>Isi Komentar :</b></div>
	<textarea class=form-control name=komentar cols=60 style="height:50px;"></textarea>
	<?=form_hidden('idd',$idd);?>
	<?=form_hidden('lembar',$idx);?>
	<div style="clear:both;margin-top:5px;">
		<button class="btn simpan_xx btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$idd;?>" data-lembar="<?=$idx;?>" data-aksi="<?=site_url('appskp/realisasi_kelola/koreksi_aksi');?>"><i class="fa fa-save"></i> Simpan</button>
		<button class="btn batal btn-primary btn-xs" id="<?=$idx;?>_<?=$idd;?>" data-nomor="<?=$idd;?>" type="button"><i class="fa fa-close"></i> Batal...</button>
	</div>
	<div style="display:none;" id='idd'><?=$idd;?></div>
	</td>