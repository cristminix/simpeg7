<tr>
	<td><?=$val->no;?></td>
	<td id='aksi_' style="padding:10px 0px 0px 0px;text-align:center;">
		<div class="dropdown" id="btMenu">
			<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="ddMenu" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu">
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;"  onclick="set_id(<?=isset($val->user_id)?$val->user_id:"";?>,'appskp/sett/lihatDataPegawai','<?=$val->hal;?>','<?=$val->cari;?>','<?=$val->batas;?>');return false;"><i class="fa fa-user fa-fw"></i> Lihat data kepegawaian</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-bullseye fa-fw"></i> Lihat target SKP</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-support fa-fw"></i> Lihat realisasi SKP</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onclick="set_id(<?=isset($val->user_id)?$val->user_id:"";?>,'appskp/sett/reset_password','<?=$val->hal;?>','<?=$val->cari;?>','<?=$val->batas;?>');return false;"><i class="fa fa-recycle fa-fw"></i> Reset password user pegawai</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-bell-slash-o fa-fw"></i> Non-aktifkan user pegawai</a></li>
			</ul>
		</div>
	</td>
	<td>
	<b><?=((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');?></b><br/>
	<?=$val->nip_baru;?><br/>
	<?=$val->tempat_lahir;?>, 
	<?php
		date_default_timezone_set('UTC');
		echo date("d-m-Y", strtotime($val->tanggal_lahir));
	?>
	</td>
	<td>
	<?=$val->nomenklatur_jabatan;?> (<u><?=date("d-m-Y", strtotime($val->tmt_jabatan));?></u>)<br/>
	<?=$val->nama_pangkat;?> / <?=$val->nama_golongan;?> 
	(<u><?=date("d-m-Y", strtotime($val->tmt_pangkat));?></u>)
	</td>
	<td colspan=4>
	<?=$val->kode_unor;?>
	<?=$val->nomenklatur_pada;?><br/><br>
	pid:<?=$val->id_pegawai;?> / uid:<b><?=$val->user_id;?></b> / 
	<?php //$val->username;
	$satu = substr($val->nip_baru,2,6);
	$dua = substr($val->nip_baru,8,6);
	$tiga = substr($val->nip_baru,14,4);
	echo "pwd:".(1001122-($satu-$dua-$tiga));
	?>

	</td>
</tr>