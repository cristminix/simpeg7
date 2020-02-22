<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/kanal/edit_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT KANAL</th>
        </tr>
        <tr>
          <td width="150">Nama Kanal</td>
          <td colspan="3">
		  <input type="text" id="nama_kanal" name="nama_kanal" class="ipt_text" style="width:400px;" value="<?=$nama_kanal; ?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3">
		  <input type="text" id="keterangan" name="keterangan" class="ipt_text" style="width:400px;" value="<?=$keterangan; ?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Tipe</td>
          <td colspan="3">
		  <select name='tipe' id='tipe' class="ipt_text" style="width:200px;"><?=$tipe;?></select>
		  </td>
        </tr>
        <tr>
          <td>Theme</td>
          <td colspan="3"><?=$theme;?></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name='idd' id='idd' value='<?=$idd;?>'>
				<input type="hidden" name='root' value="<?=$root;?>" />
				<input type="hidden" name='level' value="<?=$level;?>" />
				<input type="hidden" name='path_lama' value="<?=$path_lama;?>" />
				<input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					$("[id^='row_<?=$rowparent;?>']").remove();
					loadIsiGrid("<?=$parent;?>",<?=$level;?>);
					batal();
                }else{
					var status=arr_result[1];
					alert('Data gagal disimpan! \n '+status+'');
                }
            });
			return false;
	} //endif Hasil
}
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(opsi){
	var data="";
	var dati="";
			var nama = $.trim($("#nama_kanal").val());
			var kket = $.trim($("#kanal_path").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"NAMA KANAL tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"PATH KANAL tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>