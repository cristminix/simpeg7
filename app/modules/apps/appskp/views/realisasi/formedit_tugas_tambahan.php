<?php
date_default_timezone_set('UTC');

if($avail=="no")
{
?>
<tr id='row_tugas_tambahan_<?=(!isset($idd))?'xx':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td><?=$tambahan->pekerjaan;?></td>
	<td><?=$tambahan->no_sp;?><?=form_hidden('idd',$idd);?></td>
	<td><?=$tambahan->tanggal_sp;?></td>
	<td><?=$tambahan->penandatangan_sp;?></td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		Mohon Maaf, SKP sedang dalam proses Pejabat Penilai / Verifikatur, KEGIATAN TUGAS JABATAN tidak dapat di-TAMBAH, di-EDIT atau di-HAPUS
		<div style="clear:both;">
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':'tugas_tambahan_'.$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
else
{
?>
<tr id='row_tugas_tambahan_<?=(!isset($idd))?'xx':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td style="padding:0px;">
		<?=form_textarea('pekerjaan',(!isset($tambahan->pekerjaan))?'':$tambahan->pekerjaan,'class="form-control row-fluid" style="height:90px;"');?>
	</td>
	<td style="padding:0px;"><?=form_input('no_sp',(!isset($tambahan->no_sp))?'':$tambahan->no_sp,'class="form-control row-fluid"');?>
		<?=form_hidden('idd',$idd);?>
	</td>
	<td style="padding:0px;"><?=form_input('tanggal_sp',(!isset($tambahan->tanggal_sp))?'':date("d-m-Y", strtotime($tambahan->tanggal_sp)),'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('penandatangan_sp',(!isset($tambahan->penandatangan_sp))?'':$tambahan->penandatangan_sp,'class="form-control row-fluid"');?></td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn simpan_xx btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>" data-lembar="tugas_tambahan" data-aksi="<?=site_url('appskp/realisasi/tugas_tambahan_edit_aksi');?>"><i class="fa fa-save"></i> Simpan</button>
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':'tugas_tambahan_'.$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
?>
