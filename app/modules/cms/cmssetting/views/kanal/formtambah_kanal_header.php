<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/kanal/tambah_header_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM INPUT SETTING KANAL</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="150">Nama Kanal</td>
          <td colspan="3"><b><?=$nama_kanal; ?></b></td>
        </tr>
        <tr>
          <td>Judul Header</td>
          <td colspan="3">
		  <input type="text" id="judul_header" name="judul_header" class="ipt_text" style="width:400px;" value='Wajib diisi' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Sub Judul</td>
          <td colspan="3">
		  <input type="text" id="sub_judul" name="sub_judul" class="ipt_text" style="width:400px;" value='Wajib diisi' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Tinggi header</td>
          <td colspan="3">
		  <input type="text" id="height" name="height" class="ipt_text" style="width:40px;" value='<?=$height;?>' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Margin atas</td>
          <td colspan="3">
		  <input type="text" id="margin_top" name="margin_top" class="ipt_text" style="width:40px;" value='<?=$margin_top;?>' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Margin bawah</td>
          <td colspan="3">
		  <input type="text" id="margin_bottom" name="margin_bottom" class="ipt_text" style="width:40px;" value='<?=$margin_bottom;?>' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Padding atas</td>
          <td colspan="3">
		  <input type="text" id="padding_top" name="padding_top" class="ipt_text" style="width:40px;" value='<?=$padding_top;?>' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Padding bawah</td>
          <td colspan="3">
		  <input type="text" id="padding_bottom" name="padding_bottom" class="ipt_text" style="width:40px;" value='<?=$padding_bottom;?>' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name='path_kanal' id='path_kanal' value='<?=$path_kanal;?>'>
				<input type="hidden" name='idd' id='idd' value='<?=$idd;?>'>
				<input type="hidden" name='root' value="<?=$root;?>" />
				<input type="hidden" name='level' value="<?=$level;?>" />
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
			var nama = $.trim($("#judul_header").val());
			var kket = $.trim($("#sub_judul").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"JUDUL HEADER tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"SUB JUDUL tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>