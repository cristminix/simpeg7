<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsgaleri/edit_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT BERITA FOTO</th>
        </tr>
        <tr>
          <td width="150">Judul Berita Foto</td>
          <td colspan="3">
		  <input type="text" id="judul" name="judul" class="ipt_text" style="width:400px;" value="<?=@$isi[0]->judul;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Rubrik Berita Foto</td>
          <td colspan="3"><?=$pilrb;?></td>
        </tr>
        <tr>
          <td>Tanggal Berita</td>
          <td colspan="3">
		  <input type="text" id="tgl_buat" name="tgl_buat" class="ipt_text" style="width:100px;" value="<?=@$isi[0]->tanggal;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3">
		  <input type='text' id='keterangan' name='keterangan' class="ipt_text" style="width:400px;" value='<?=@$isi[0]->isi_artikel;?>' onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type=hidden name=idd value='<?=@$isi[0]->id_konten;?>'>
				<input type="button" onclick="simpan();" value="Simpan" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
$(function() {	$( "#tgl_buat" ).datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" });  });
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
	loadDialogBuka();
			var interval;
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
				//alert(data);
                if(arr_result[0]=='sukses'){
					if(arr_result[1] == 'add'){
						jQuery('#back-button').click();
					}
					gridpaging("end");
					batal();
                } else {
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
				loadDialogTutup();
            });
			return false;
	} //endif Hasil
}
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(opsi){
	var data="";
	var dati="";
			var nama = $.trim($("#judul").val());
			var kket = $.trim($("#keterangan").val());
			var tglb = $.trim($("#tgl_buat").val());
			var rbrk = $.trim($("#id_kategori").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"JUDUL BERITA FOTO tidak boleh kosong\n";	}
			if( rbrk ==""){	dati=dati+"RUBRIK BERITA FOTO tidak boleh kosong\n";	}
			if( kket =="Wajib diisi" || kket ==""){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
			if( tglb =="Wajib diisi"){	dati=dati+"TANGGAL BERITA tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>