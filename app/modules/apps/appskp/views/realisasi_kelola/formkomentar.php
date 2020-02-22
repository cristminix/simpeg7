	<td colspan=10>


<table width="100%" class="table info table-striped table-bordered table-hover" style="background-color:#ffffff;margin-bottom:0px;">
<thead id=gridhead>
<tr height=20>
<th width=75>No.</th>
<th width=450>KOMENTAR</th>
<th align=center>PEMBERI KOMENTAR</th>
<th width=160>JEJAK WAKTU</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach($komentar as $key=>$val){
?>
	<tr>
	<td><?=$no;?></td>
	<td><?=$val->komentar;?></td>
	<td>...</td>
	<td><?=$val->last_updated;?></td>
	</tr>
<?php
$no++;
}
if($no==1)
{
?>
	<tr>
	<td colspan=4><p align="center">TIDAK ADA KOMENTAR UNTUK KEGIATAN INI</p></td>
	</tr>
<?php
}
?>
	<tr>
	<td colspan=4><button class="btn batal btn-primary btn-xs" id="<?=$idx;?>_<?=$idd;?>" data-nomor="<?=$idd;?>" type="button"><i class="fa fa-close"></i> Tutup</button></td>
	</tr>
</tbody>
</table>

		
	<div style="display:none;" id='idd'><?=$idd;?></div>
	</td>
