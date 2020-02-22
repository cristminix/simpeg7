<?php
if($avail=="no")
{
?>
<tr id='row_<?=(!isset($idd))?'xx':$idd;?>' class=danger>
	<td><?=$nomor;?></td>
	<td colspan=9 align=center>Mohon Maaf, SKP sedang dalam proses Pejabat Penilai / Verifikatur, KEGIATAN TUGAS JABATAN tidak dapat di-TAMBAH, di-EDIT atau di-HAPUS</td>
</tr>
<tr id='row_tt' class=danger>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
else
{
?>
<tr id='row_<?=$idd;?>' class=danger>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td>
		<?=$isi[0]->pekerjaan;?>
		<?=form_hidden('id_target',$isi[0]->id_target);?>
		<?=form_hidden('id_skp',$id_skp);?>
		
	</td>
	<td><?=$isi[0]->ak;?></td>
	<td><?=$isi[0]->volume;?></td>
	<td><?=$isi[0]->satuan;?></td>
	<td><?=$isi[0]->kualitas;?></td>
	<td><?=$isi[0]->waktu_lama;?></td>
	<td><?=$isi[0]->waktu_satuan;?></td>
	<td><?=$isi[0]->biaya;?></td>
</tr>
<tr id='row_tt' class=danger>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div id='idhapus' style="display:none;"><?=$idd;?></div>
		<div style="clear:both;">
		<button class="btn btn-primary btn-xs" type="button" id="<?=$idd;?>" data-nomor="<?=$nomor;?>" onclick="hapus();"><i class="fa fa-trash"></i> Hapus</button>
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
?>
