<tr id='row_<?=(!isset($idd))?'xx':$idd;?>'>
<td>
<?=$nomor;?></td>
<td align=center>...SS</td>
<td>
<?=form_input('tahun',(!isset($isi->tahun))?'':$isi->tahun,'class="form-control" style="width:50px; padding-left:2px; padding-right:2px;"');?>
<?=form_hidden('id_skp',(!isset($isi->id_skp))?'':$isi->id_skp);?>
</td>
<td>
<?=form_dropdown('bulan_mulai',$this->dropdowns->bulan(),(!isset($isi->bulan_mulai))?'':$isi->bulan_mulai,'class="form-control" style="width:100px; padding-left:2px; padding-right:2px; float:left;"');?>
<div style="float:left; padding-top:5px; margin:0px 2px 0px 2px;">s.d.</div>
<?=form_dropdown('bulan_selesai',$this->dropdowns->bulan(),(!isset($isi->bulan_selesai))?'':$isi->bulan_selesai,'class="form-control" style="width:100px; padding-left:2px; padding-right:2px; float:left;"');?>
</td>
<td>
<?=form_input('penilai',(!isset($isi->penilai))?'':$isi->penilai,'class="form-control" placeholder="Masukkan NIP"');?>
</td>
<td>
<button class="btn simpan btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>">Simpan</button>
<div style="clear:both; margin-top:3px;"></div>
<button class="btn batal btn-primary btn-xs" type="button" id="<?=(!isset($idd))?'xx':$idd;?>" data-nomor="<?=$nomor;?>">Batal...</button>
</td>
</tr>
