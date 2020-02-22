<?php
date_default_timezone_set('UTC');
if($avail=="no")
{
?>
<tr id='row_kreatifitas_<?=(!isset($idd))?'xx':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td><?=$kreatifitas->kreatifitas;?></td>
	<td><?=$kreatifitas->no_sk;?><?=form_hidden('idd',$idd);?></td>
	<td><?=$kreatifitas->tanggal_sk;?></td>
	<td><?=$kreatifitas->penandatangan_sk;?></td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
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
<tr id='row_kreatifitas_<?=(!isset($idd))?'xx':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td style="padding:0px;">
		<?=form_textarea('kreatifitas',(!isset($kreatifitas->kreatifitas))?'':$kreatifitas->kreatifitas,'class="form-control row-fluid" style="height:90px;"');?>
	</td>
	<td style="padding:0px;"><?=form_input('no_sk',(!isset($kreatifitas->no_sk))?'':$kreatifitas->no_sk,'class="form-control row-fluid"');?>
		<?=form_hidden('idd',$idd);?>
	</td>
	<td style="padding:0px;"><?=form_input('tanggal_sk',(!isset($kreatifitas->tanggal_sk))?'':date("d-m-Y", strtotime($kreatifitas->tanggal_sk)),'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('penandatangan_sk',(!isset($kreatifitas->penandatangan_sk))?'':$kreatifitas->penandatangan_sk,'class="form-control row-fluid"');?></td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn simpan_xx btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>" data-lembar="kreatifitas" data-aksi="<?=site_url('appskp/realisasi/kreatifitas_edit_aksi');?>"><i class="fa fa-save"></i> Simpan</button>
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':'kreatifitas_'.$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
?>
