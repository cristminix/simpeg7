<tr id='row_<?=$val->id_peg_diklat;?>'>
<td id='nomor_<?=$val->id_peg_diklat;?>'><?=$val->no;?></td>
<td align=center>
	<div class="btn-group" id="btMenu<?=$val->id_peg_diklat;?>">
		<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_peg_diklat;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('edit','<?=$val->id_peg_diklat;?>','<?=$val->no;?>');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('hapus','<?=$val->id_peg_diklat;?>','<?=$val->no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
		</ul>
	</div>
</td>
<td>
		<div>
			<span><div style="display:table;"><?=$val->tanggal_mulai;?></div></span>
		</div>
		<div style="clear:both;">
			<span><div style="display:table;"><?=$val->tanggal_selesai;?></div></span>
		</div>
</td>
<td><?=$val->nama_diklat;?></td>
<td><?=$val->tempat_diklat;?></td>
<td>

		<div>
			<div style="float:left; width:130px;">No. SK</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=$val->nomor_sk;?></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Tanggal SK</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=$val->tanggal_sk;?></div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Jenis Diklat</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;">
			<?php
				if($val->jenis_diklat=="umum"){
					echo "Umum";
				} elseif($val->jenis_diklat=="teknik"){
					echo "Teknik";
				} elseif($val->jenis_diklat=="seminar_umum"){
					echo "Seminar Umum";
				} elseif($val->jenis_diklat=="seminar_teknik"){
					echo "Seminar Teknik";
				} elseif($val->jenis_diklat=="workshop_umum"){
					echo "Workshop Umum";
				} elseif($val->jenis_diklat=="workshop_teknik"){
					echo "Workshop Teknik";
				}
			?>
			</div></span>
		</div>
</td>
</tr>
