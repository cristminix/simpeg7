<tr id="row_tt" class="success">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td id="ipt_jabatan">
			<div>Tempat meninggal</div>
			<div>Tanggal meninggal</div>
			<div>Sebab meninggal</div>
	</td>
	<td id="ipt_keterangan">
		<div style="float:left;"><input type="text" class="form-control" id="tempat_meninggal" name="tempat_meninggal" value="<?=(!isset($val->tempat_meninggal))?'':$val->tempat_meninggal;?>" style="width:200px;height:20px;padding:1px 0px 0px 5px;"></div>
		<div style="float:left;"><input type="text" class="form-control" id="tanggal_meninggal" name="tanggal_meninggal" value="<?=(!isset($val->tanggal_meninggal))?'':$val->tanggal_meninggal;?>" placeholder="dd-mm-yyyy" style="width:150px;height:20px;padding:1px 0px 0px 5px;"></div>
		<div style="float:left;"><input type="text" class="form-control" id="sebab_meninggal" name="sebab_meninggal" value="<?=(!isset($val->sebab_meninggal))?'':$val->sebab_meninggal;?>" style="width:200px;height:20px;padding:1px 0px 0px 5px;"></div>
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
			var tgmg = $.trim($("#tanggal_meninggal").val());
			var tpmg = $.trim($("#tempat_meninggal").val());
			var tgsk = $.trim($("#sebab_meninggal").val());
			data=data+""+tpmg+"*"+tgmg+"**";
			if( tgmg ==""){	dati=dati+"TANGGAL MENINGGAL tidak boleh kosong\n";	}
			if( tpmg ==""){	dati=dati+"TEMPAT MENINGGAL tidak boleh kosong\n";	}
			if( tgsk ==""){	dati=dati+"SEBAB MENINGGAL tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>
