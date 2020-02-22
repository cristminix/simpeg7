<?php
if($avail=="no")
{
?>
<tr id='row_<?=(!isset($idd))?'xx':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td colspan=9 align=center>Mohon Maaf, SKP sedang dalam proses Pejabat Penilai / Verifikatur, KEGIATAN TUGAS JABATAN tidak dapat di-TAMBAH, di-EDIT atau di-HAPUS</td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
else
{
?>
<tr id='row_<?=(!isset($idd))?'xx':$idd;?>' class=info>
	<td><?=$nomor;?></td>
	<td align=center>...</td>
	<td style="padding:0px;">
		<?=form_textarea('target',(!isset($isi[0]->pekerjaan))?'':$isi[0]->pekerjaan,'class="form-control row-fluid" style="height:90px;"');?>
		<?=form_hidden('id_target',(!isset($isi[0]->id_target))?'':$isi[0]->id_target);?>
		<?=form_hidden('id_skp',$id_skp);?>
		<?=form_hidden('nomor',$nomor);?>
	</td>
	<td style="padding:0px;"><?=form_input('ak',(!isset($isi[0]->ak))?'':$isi[0]->ak,'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('volume',(!isset($isi[0]->volume))?'':$isi[0]->volume,'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('satuan',(!isset($isi[0]->satuan))?'':$isi[0]->satuan,'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('kualitas',(!isset($isi[0]->kualitas))?'':$isi[0]->kualitas,'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('waktu_lama',(!isset($isi[0]->waktu_lama))?'':$isi[0]->waktu_lama,'class="form-control row-fluid"');?></td>
	<td style="padding:0px;"><?=form_input('waktu_satuan',(!isset($isi[0]->waktu_satuan))?'':$isi[0]->waktu_satuan,'class="form-control row-fluid"');?></td>
	<td align="right" style="padding:0px;"><?=form_input('biaya',(!isset($isi[0]->biaya))?'':number_format($isi[0]->biaya,2,"."," "),'id=biaya style="text-align:right;" class="form-control  row-fluid"');?></td>
</tr>
<tr id='row_tt' class=info>
	<td colspan=2>&nbsp;</td>
	<td colspan=8>
		<div style="clear:both;">
		<button class="btn simpan btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-save"></i> Simpan</button>
		<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>"><i class="fa fa-close"></i> Batal...</button>
		</div>
	</td>
</tr>
<?php
}
?>
<script>
  $(function() {
    $('#biaya').maskMoney({thousands:' ', decimal:'.', allowZero:true});
  })
</script>
<style>
.form-control {	padding:0px 3px 0px 3px;	}
</style>