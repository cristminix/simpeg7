<tr id='row_<?=$val->id_peg_jab;?>'>
<td id='nomor_<?=$val->id_peg_jab;?>'><?=$val->no;?></td>
<td align=center>
	<div class="btn-group" id="btMenu<?=$val->id_peg_jab;?>">
		<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_peg_jab;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('edit','<?=$val->id_peg_jab;?>','<?=$val->no;?>');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm('hapus','<?=$val->id_peg_jab;?>','<?=$val->no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
		</ul>
	</div>
</td>
<td><?=$val->tmt_jabatan;?></td>
<td><?=$val->nama_unor;?> <br/><u>pada</u><br/> <?=$val->nomenklatur_pada;?></td>
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
			<span><div style="display:table;">
			<?php
				if($val->nama_jenis_jabatan=="js"){
					echo "Jabatan Struktural";
				} elseif($val->nama_jenis_jabatan=="jfu"){
					echo "Jabatan Fungsional Umum";
				} elseif($val->nama_jenis_jabatan=="jft"){
					echo "Jabatan Fungsional Tertentu";
				} 
			?>
			</div></span>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Jabatan</div>
			<div style="float:left; width:10px;">:</div>
			<span><div style="display:table;"><?=$val->nama_jabatan;?></div></span>
		</div>
		
</td>
</tr>
