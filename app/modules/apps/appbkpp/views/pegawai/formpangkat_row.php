<tr id='row_<?=$val->id_peg_golongan;?>'>
<td id='nomor_<?=$val->id_peg_golongan;?>'><?=$val->no;?></td>
<td align=center>
	<div class="btn-group" id="btMenu<?=$val->id_peg_golongan;?>">
		<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_peg_golongan;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('edit','<?=$val->id_peg_golongan;?>','<?=$val->no;?>');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('hapus','<?=$val->id_peg_golongan;?>','<?=$val->no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
		</ul>
	</div>
</td>
<td><?=$val->tmt_golongan;?></td>
<td><?=$val->kode_pangkat;?></td>
<td><?=$val->nama_pangkat;?></td>
<td><?=$val->nama_golongan;?></td>
<td><?=$val->mk_peringkat;?></td>
<td>

		<div>
			<div style="float:left; width:130px;">No. SK</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=$val->sk_nomor;?></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Tanggal SK</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=$val->sk_tanggal;?></div></span>
		</div>
</td>
</tr>
