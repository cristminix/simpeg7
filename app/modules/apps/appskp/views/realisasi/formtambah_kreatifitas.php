<?php
if($avail=="no")
{
?>
<tr id='row_<?=(!isset($idd))?'cc':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td colspan=9 align=center>Mohon Maaf, SKP sedang dalam proses Pejabat Penilai / Verifikatur, KEGIATAN TUGAS JABATAN tidak dapat di-TAMBAH, di-EDIT atau di-HAPUS</td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'cc':$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
else
{
?>
<tr id='row_<?=(!isset($idd))?'cc':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td style="padding:0px;">
		<?=form_textarea('kreatifitas',(!isset($isi[0]->kreatifitas))?'':$isi[0]->kreatifitas,'class="form-control row-fluid" style="height:90px;"');?>
	</td>
	<td style="padding:0px;"><?=form_input('no_sk',(!isset($isi[0]->ak))?'':$isi[0]->ak,'class="form-control row-fluid"');?>
	<?=form_hidden('id_skp',$id_skp);?>
	</td>
	<td style="padding:0px;"><?=form_input('tanggal_sk',(!isset($isi[0]->volume))?'':$isi[0]->volume,'class="form-control row-fluid" placeholder="dd-mm-yyyy"');?></td>
	<td style="padding:0px;"><?=form_input('penandatangan_sk',(!isset($isi[0]->satuan))?'':$isi[0]->satuan,'class="form-control row-fluid"');?></td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn simpan_xx btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>" data-lembar="kreatifitas" data-aksi="<?=site_url('appskp/realisasi/kreatifitas_tambah_aksi');?>"><i class="fa fa-save"></i> Simpan</button>
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'cc':$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
?>
