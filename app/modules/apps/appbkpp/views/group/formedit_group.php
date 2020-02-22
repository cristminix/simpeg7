<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/group/edit_group_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT GRUP PENGGUNA</th>
        </tr>
        <tr>
          <td width="20%">Nama Grup Pengguna</td>
          <td colspan="3">
		  <input type="text" id="nama_grup" name="nama_grup"  class="ipt_text" style="width:400px;" value="<?=$group_name;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Theme</td>
          <td colspan="3">
		  <input type="text" id="nama_section" name="nama_section"  class="ipt_text" style="width:400px;" value="<?=$section_name;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Back Office</td>
          <td colspan="3">
		  <input type="text" id="backoffice" name="backoffice"  class="ipt_text" style="width:400px;" value="<?=$backoffice;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3">
		  <input type="text" id="keterangan" name="keterangan"  class="ipt_text" style="width:400px;" value="<?=$keterangan;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name=idd value="<?=$group_id;?>"/>
				<input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					loadIsiGrid();
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
			var nama = $.trim($("#nama_grup").val());
			var nmsc = $.trim($("#nama_section").val());
			var bbck = $.trim($("#backoffice").val());
			var kket = $.trim($("#keterangan").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"NAMA GROUP tidak boleh kosong\n";	}
			if( nmsc =="Wajib diisi"){	dati=dati+"NAMA SECTION tidak boleh kosong\n";	}
			if( bbck =="Wajib diisi"){	dati=dati+"BACK OFFICE tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>