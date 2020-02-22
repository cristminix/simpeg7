<tr id="brow_tt" class="success prinsip">
	<td><?=$nomor;?></td>
	<td>...</td>
	<td id="ipt_nama">
		<?php
			if(isset($val->id_pegawai)){
				echo $val->nama_pegawai." (".$val->gender.")<br/>";
				echo $val->nip_baru."<br/>";
				echo $val->nama_pangkat." / ".$val->nama_golongan;
			} else {
		?>
			<div class="form-group input-group" id="ipt_nip">
			<?=form_input('nip_baru',(!isset($val->nip_baru))?'':$val->nip_baru,'class="form-control row-fluid" placeholder="Masukkan NIP..." style="padding-left:5px;padding-right:5px;" id="nip_baru"');?>
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" onclick="cari_nip();"><i class="fa fa-search"></i></button>
			</span>
			</div>
			<div id="ipt_spin" style="display:none;"><p class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i><p></div>
		<?php
			}
		?>
	</td>
	<td id="ipt_jabatan">
		<?php
			if(isset($val->id_pegawai)){
				echo $val->nomenklatur_jabatan."<br/><u>pada</u><br/>";
				echo $val->nomenklatur_pada;
			}
		?>
	</td>
	<td id="ipt_keterangan">
		<div>
			<div style="float:left; width:130px;">Tanggal BUP</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><input type="text" class="form-control" id="tanggal_pensiun" name="tanggal_pensiun" value="<?=(!isset($val->tanggal_pensiun))?'':$val->tanggal_pensiun;?>" placeholder="dd-mm-yyyy" style="width:150px;height:20px;padding:1px 0px 0px 5px;"></div>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">No. SK Pensiun</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><input type="text" class="form-control" id="no_sk" name="no_sk" value="<?=(!isset($val->no_sk))?'':$val->no_sk;?>" style="width:200px;height:20px;padding:1px 0px 0px 5px;"></div>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Tanggal SK Pensiun</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><input type="text" class="form-control" id="tanggal_sk" name="tanggal_sk" value="<?=(!isset($val->tanggal_sk))?'':$val->tanggal_sk;?>" placeholder="dd-mm-yyyy" style="width:150px;height:20px;padding:1px 0px 0px 5px;"></div>
		</div>
		<div style="clear:both;">
			<div style="float:left; width:130px;">Jenis Pensiun</div>
			<div style="float:left; width:10px;">:</div>
			<div style="float:left;"><?=form_dropdown('jenis_pensiun',$this->dropdowns->jenis_pensiun(),(!isset($val->jenis_pensiun))?'':$val->jenis_pensiun,'id="jenis_pensiun"  class="form-control" style="width:200px;height:20px;padding:1px 0px 0px 5px;"');?></div>
		</div>
	</td>
</tr>

			<tr id="brow_tt" class="success bt_simpan">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="7">
<input type="hidden" name="sub" value="pensiun">
<?php if(isset($val->id)){	?>
			<input type=hidden name="id_pegawai" id="id_pegawai" value="<?=$val->id_pegawai;?>">
<?php	}	?>
			<div class="btn btn-primary bt_simpan" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Simpan</div>
			<button class="btn batal btn-default" type="button"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</td>
			</tr>
<script type="text/javascript">
function cari_nip(){
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/mutasi/cari_nip",
		data: {"nip":$("#nip_baru").val()},
		beforeSend:function(){	
			$('#ipt_nip').hide();
			$('#ipt_spin').show();
		},
		success:function(data){
			if(data.id_pegawai){
				var isi = data.nama_pegawai+' ('+data.gender+')<br/>';
				isi = isi + data.nip_baru+' / '+data.nama_pangkat+'('+data.nama_golongan+')';
				isi = isi + '<input type="hidden" id="id_pegawai" name="id_pegawai" value="'+data.id_pegawai+'">';
				isi = isi + '<input type="hidden" name="nip_baru" value="'+data.nip_baru+'">';
				isi = isi + '<input type="hidden" name="nama_pegawai" value="'+data.nama_pegawai+'">';
				$('#ipt_nama').html(isi);
				var jab = data.nomenklatur_jabatan+'<br/><u>pada</u><br/>'+data.nomenklatur_pada;
				$('#ipt_jabatan').html(jab);
			} else {
				alert("Pegawai dengan NIP tersebut TIDAK DITEMUKAN... Masukkan NIP Lain!!");
				$('#ipt_nip').show();
				$('#ipt_spin').hide();
			}
		}, // end success
	dataType:"json"}); // end ajax
}
</script>
