<tr id="row_tt" class="success">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td id="ipt_jabatan">
			<div>Tanggal BUP</div>
			<div>No. SK Pensiun</div>
			<div>Tanggal SK Pensiun</div>
			<div>Jenis Pensiun</div>
	</td>
	<td id="ipt_keterangan">
		<div><input type="text" class="form-control" id="tanggal_pensiun" name="tanggal_pensiun" value="<?=(!isset($val->tanggal_pensiun))?'':$val->tanggal_pensiun;?>" placeholder="dd-mm-yyyy" style="width:150px;height:20px;padding:1px 0px 0px 5px;"></div>
		<div><input type="text" class="form-control" id="no_sk" name="no_sk" value="<?=(!isset($val->no_sk))?'':$val->no_sk;?>" style="width:200px;height:20px;padding:1px 0px 0px 5px;"></div>
		<div><input type="text" class="form-control" id="tanggal_sk" name="tanggal_sk" value="<?=(!isset($val->tanggal_sk))?'':$val->tanggal_sk;?>" placeholder="dd-mm-yyyy" style="width:150px;height:20px;padding:1px 0px 0px 5px;"></div>
		<div><?=form_dropdown('jenis_pensiun',$this->dropdowns->jenis_pensiun(),(!isset($val->jenis_pensiun))?'':$val->jenis_pensiun,'id="jenis_pensiun"  class="form-control" style="width:200px;height:20px;padding:1px 0px 0px 5px;"');?></div>
	</td>
</tr>
<tr id="row_tt" class="success bt_simpan">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="3">
		<input type=hidden name="id_pegawai" id="id_pegawai" value="<?=$idd;?>">
		<input type=hidden name="nama_pegawai" id="nama_pegawai" value="<?=$peg->nama_pegawai;?>">
		<input type=hidden name="nip_baru" id="nip_baru" value="<?=$peg->nip_baru;?>">
		<div class="btn btn-primary bt_simpan" onclick="simpan();"><i class="fa fa-save fa-fw"></i> Simpan</div>
		<button class="btn batal btn-default" type="button"><i class="fa fa-close fa-fw"></i> Batal...</button>
	</td>
</tr>
<script type="text/javascript">
function simpan(){
		var hasil=validasi_isian();
		if (hasil!=false) {
				$.ajax({
					type:"POST",
					url: $("#form_sub").attr('action'),
					data: $("#form_sub").serialize(),
					beforeSend:function(){	
						$('.bt_simpan').remove();
					},
					success:function(data){
						gopaging();
					}, // end success
					dataType:"html"}); // end ajax
		} //endif Hasil
}

function validasi_isian(){
	var data="";
	var dati="";
			var tgmg = $.trim($("#tanggal_pensiun").val());
			var tpmg = $.trim($("#no_sk").val());
			var tgsk = $.trim($("#tanggal_sk").val());
			var jnps = $.trim($("#jenis_pensiun").val());
			data=data+""+tpmg+"*"+tgmg+"**";
			if( tgmg ==""){	dati=dati+"TANGGAL PENSIUN tidak boleh kosong\n";	}
			if( tpmg ==""){	dati=dati+"NO SK PENSIUN tidak boleh kosong\n";	}
			if( tgsk ==""){	dati=dati+"TANGGAL SK PENSIUN tidak boleh kosong\n";	}
			if( jnps ==""){	dati=dati+"JENIS PENSIUN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>
