<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url();?>cmssetting/edit_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT <?=$setting;?></th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Nama <?=$setting;?></td>
          <td colspan="3">
		  <input type="text" id="nama_item" name="nama_item" size="70"  value="<?=$item[0]->nama_item;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
<?php
foreach($atribut as $key=>$val){
?>
        <tr>
          <td width="12%"><?=$key;?></td>
          <td colspan="3">
		  <input type="text" id='nilai_atribut_<?=$val;?>' name="nilai_atribut[]"  value="<?=$val;?>" size="70" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
<?php
}
?>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name='id_setting' id='id_setting' value='<?=$id_setting;?>'>
				<input type="hidden" name='idd' id='idd' value='<?=$idd;?>'>
				<input type="button" onclick="simpan();" value="Simpan..." class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(opsi){
	var data="";
	var dati="";
			var nama = $.trim($("#tema").val());
			var kket = $.trim($("#isi_agenda").val());
			var tmpt = $.trim($("#tempat").val());
			var tglb = $.trim($("#tgl_mulai").val());
			var tglc = $.trim($("#tgl_selesai").val());
			var rbrk = $.trim($("#id_kategori").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"JUDUL AGENDA tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"ISI AGENDA tidak boleh kosong\n";	}
			if( tmpt =="Wajib diisi"){	dati=dati+"TEMPAT tidak boleh kosong\n";	}
			if( rbrk ==""){	dati=dati+"RUBRIK AGENDA tidak boleh kosong\n";	}
			if( tglb =="Wajib diisi"){	dati=dati+"TANGGAL MULAI tidak boleh kosong\n";	}
			if( tglc =="Wajib diisi"){	dati=dati+"TANGGAL SELESAI tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
	function simpan(){
//		var hasil=validasi_pengikut();
//		if (hasil!=false) {
		loadDialogBuka();
				var interval;
				jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
					var arr_result = data.split("#");
					//alert(data);
					if(arr_result[0]=='sukses'){
						if(arr_result[1] == 'add'){
							jQuery('#back-button').click();
						}
						batal();
						langsung();
					} else {
						alert('Data gagal disimpan! \n Lihat pesan diatas form');
					}
					loadDialogTutup();
				});
				return false;
//		} //endif Hasil
	} //tutup::simpan
	function langsung(){
		if(<?=$lvl;?>!=0){	$("[id^='row_<?=$idp;?>_']").remove(); var idp="<?=$idp;?>";	} else {	$("[id^='row_']").remove(); var idp="0";	}
		loadIsiGrid(idp,<?=$lvl;?>);
	}
</script>