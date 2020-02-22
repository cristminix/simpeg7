<tr id="row_tt"class="success prinsip">
	<td><?=$no;?></td>
	<td>...</td>
<td><div id='pekerjaan_<?=$val->id_peg_jab;?>'><?=$val->tmt_jabatan;?></div></td>
<td><?=$val->nomenklatur_pada;?></td>
<td>
		<div>
			<div style="float:left; width:130px;">No SK</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><?=$val->sk_nomor;?></div>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Tanggal SK</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><?=$val->sk_tanggal;?></div>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Penandatangan SK</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><?=$val->sk_pejabat;?></div>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Jenis jabatan</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;">...</div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Jabatan</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=$val->nama_jabatan;?></div></span>
		</div>
</td>
</tr>
</tr>
			<tr id="row_tt" class="success">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
			<input type=hidden name="id_peg_jab" id="id_peg_jab" value="<?=$idd;?>">
			<div class="btn btn-danger" onclick="hapus();"><i class="fa fa-trash fa-fw"></i> Hapus</div>
			<button class="btn batal btn-default" type="button" id="'+ini+'" data-nomor="'+nomor+'"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
			</tr>
