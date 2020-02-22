<tr id='row_<?=$val->id_peg_pengalaman;?>'>
<td id='nomor_<?=$val->id_peg_pengalaman;?>'><?=$val->no;?></td>
<td align=center>
	<div class="btn-group" id="btMenu<?=$val->id_peg_pengalaman;?>">
		<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_peg_pengalaman;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('edit','<?=$val->id_peg_pengalaman;?>','<?=$val->no;?>');"><i class="fa fa-edit fa-fw"></i>Edit Data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('hapus','<?=$val->id_peg_pengalaman;?>','<?=$val->no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus Data</a></li>
		</ul>
	</div>
</td>
		<td align=left>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->perusahaan;?></div></span>
		</div>
		</td>
		<td align=left>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->pekerjaan;?></div></span>
		</div>
		</td>
		<td align=center>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->tanggal_awal;?></div></span>
		</div>
		</td>
		<td align=center>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->tanggal_akhir;?></div></span>
		</div>
		</td>
		<td align=left>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->jabatan;?></div></span>
		</div>
		</td>
</tr>
