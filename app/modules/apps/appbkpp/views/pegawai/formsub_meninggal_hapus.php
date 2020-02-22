<tr id="brow_tt" class="success prinsip">
	<td><?=$nomor;?></td>
	<td>...</td>
	<td id="ipt_nama">
		<?php
				echo $val->nama_pegawai." (".$val->gender.")<br/>";
				echo $val->nip_baru."<br/>";
				echo $val->nama_pangkat." / ".$val->nama_golongan;
		?>
	</td>
	<td id="ipt_jabatan">
		<?php
				echo $val->nomenklatur_jabatan."<br/><u>pada</u><br/>";
				echo $val->nomenklatur_pada;
		?>
	</td>
	<td id="ipt_keterangan">
		<div>
			<div style="float:left; width:130px;">Tempat meninggal</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=(!isset($val->tempat_meninggal))?'':$val->tempat_meninggal;?></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Tanggal meninggal</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=(!isset($val->tanggal_meninggal))?'':$val->tanggal_meninggal;?></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Sebab meninggal</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=(!isset($val->sebab_meninggal))?'':$val->sebab_meninggal;?></div></span>
		</div>
	</td>
</tr>

			<tr id="brow_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
<input type="hidden" name="sub" value="meninggal">
			<input type=hidden id="tanggal_meninggal" value="tanggal">
			<input type=hidden id="tempat_meninggal" value="tempat">
			<input type=hidden name="id_pegawai" id="id_pegawai" value="<?=$val->id_pegawai;?>">
			<div class="btn btn-danger bt_simpan" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Hapus</div>
			<button class="btn batal btn-default" type="button"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
			</tr>