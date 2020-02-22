<?php
if($avail=="no")
{
?>
<tr id='row_tt' class=warning>
	<td colspan=2>&nbsp;</td>
	<td colspan=9>
	Mohon Maaf, SKP sedang dalam proses Pejabat Penilai / Verifikatur, KEGIATAN TUGAS JABATAN tidak dapat di-TAMBAH, di-EDIT atau di-HAPUS
		<div style="clear:both;">
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':'kreatifitas_'.$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
else
{
?>
<tr id='row_tt' class=warning>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>		<?=form_hidden('idd',$idd);?>
		<div style="clear:both;">
		<button class="btn simpan_xx btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>" data-lembar="kreatifitas" data-aksi="<?=site_url('appskp/realisasi/kreatifitas_hapus_aksi');?>"><i class="fa fa-save"></i> Hapus</button>
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':'kreatifitas_'.$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
?>
