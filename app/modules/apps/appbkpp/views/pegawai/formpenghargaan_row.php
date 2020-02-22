<tr id='row_<?=$val->id_peg_penghargaan;?>'>
<td id='nomor_<?=$val->id_peg_penghargaan;?>'><?=$val->no;?></td>
<td align=center>
	<div class="btn-group" id="btMenu<?=$val->id_peg_penghargaan;?>">
		<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_peg_penghargaan;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('edit','<?=$val->id_peg_penghargaan;?>','<?=$val->no;?>');"><i class="fa fa-edit fa-fw"></i>Edit Data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('hapus','<?=$val->id_peg_penghargaan;?>','<?=$val->no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus Data</a></li>
		</ul>
	</div>
</td>
		<td align=center>
		<div>
			<span><div style="display:table;"><?=$val->nomor_sk;?></div></span>
		</div>
		</td>
		<td align=center>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->tanggal_sk;?></div></span>
		</div>
		</td>
		<td align=center>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->uraian;?></div></span>
		</div>
		</td>
</tr>
