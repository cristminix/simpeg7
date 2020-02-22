<tr id='row_<?=(!isset($idd))?'xx':$idd;?>'>
<td>
<?=$nomor;?></td>
<td align=center>...</td>
<td>
<?=form_input('target',(!isset($isi[0]->pekerjaan))?'':$isi[0]->pekerjaan,'size=50 style="float:left;"');?>
<div style="float:left;text-align:right; width:40px;">
	<div>Jan :</div>
	<div>Feb :</div>
	<div>Mar :</div>
	<div>Apr :</div>
	<div>Mei :</div>
	<div>Jun :</div>
	<div>Jul :</div>
	<div>Agt :</div>
	<div>Sep :</div>
	<div>Okt :</div>
	<div>Nov :</div>
	<div>Des :</div>
</div>
<?=form_hidden('id_target',(!isset($isi[0]->id_target))?'':$isi[0]->id_target);?>
<?=form_hidden('id_skp',$id_skp);?>
<div style="clear:both;">
<button class="btn simpan btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>">Simpan</button>
<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>">Batal...</button>
</div>
</td>
<td>
<?=form_input('ak',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_jan',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_feb',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_mar',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_apr',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_mei',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_jun',(!isset($isi[0]->ak))?'':$isi[0]->ak,'size=4');?>
<?=form_input('ak_jul',(!isset($isi[0]->ak_jul))?'':$isi[0]->ak_jul,'size=4');?>
<?=form_input('ak_agt',(!isset($isi[0]->ak_agt))?'':$isi[0]->ak_agt,'size=4');?>
<?=form_input('ak_sep',(!isset($isi[0]->ak_sep))?'':$isi[0]->ak_sep,'size=4');?>
<?=form_input('ak_okt',(!isset($isi[0]->ak_okt))?'':$isi[0]->ak_okt,'size=4');?>
<?=form_input('ak_nov',(!isset($isi[0]->ak_nov))?'':$isi[0]->ak_nov,'size=4');?>
</td>
<td>
<?=form_input('volume',(!isset($isi[0]->volume))?'':$isi[0]->volume,'size=4');?>
</td>
<td>
<?=form_input('satuan',(!isset($isi[0]->satuan))?'':$isi[0]->satuan,'size=6');?>
</td>
<td>
<?=form_input('kualitas',(!isset($isi[0]->kualitas))?'':$isi[0]->kualitas,'size=2');?>
</td>
<td>
<?=form_input('biaya',(!isset($isi[0]->biaya))?'':$isi[0]->biaya,'size=10');?>
</td>
</tr>
