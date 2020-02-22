<tr id='row_<?=$val->id;?>'>
<td id='nomor_<?=$val->id;?>'><?=$val->no;?></td>
<td align=center>
	<div class="btn-group" id="btMenu<?=$val->id;?>">
		<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('edit','<?=$val->id;?>','<?=$val->no;?>');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('hapus','<?=$val->id;?>','<?=$val->no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
		</ul>
	</div>
</td>
		<td align=center>
		<div>
			<span><div style="display:table;"><?=$val->tmt_kontrak;?></div></span>
		</div>
		</td>
		<td align=center>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->mk_th;?></div></span>
		</div>
		</td>
		<td align=center>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->mk_bl;?></div></span>
		</div>
		</td>
		<td align="left">
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->sk_nomor;?></div></span>
		</div>
		</td>
		<td align="right">
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->sk_tanggal;?></div></span>
		</div>
		</td><td align="left">
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->sk_pejabat;?></div></span>
		</div>
		</td>
</tr>
