<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsagenda/tambah_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM TAMBAH AGENDA</th>
        </tr>
        <tr>
          <td width="150">Judul Agenda</td>
          <td colspan="3">
		  <input type="text" id="tema" name="tema" class="ipt_text" style="width:400px;" value="<?=$tema;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Isi Agenda</td>
          <td colspan="3">
		  <input type="text" id="isi_agenda" name="isi_agenda" class="ipt_text" style="width:400px;" value="<?=$isi_agenda;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Tempat</td>
          <td colspan="3">
		  <input type="text" id="tempat" name="tempat" class="ipt_text" style="width:400px;" value="<?=$tempat;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Rubrik Agenda</td>
          <td colspan="3"><?=$pilrb;?></td>
        </tr>
        <tr>
          <td>Tanggal Mulai</td>
          <td colspan="3">
		  <input type="text" id="tgl_mulai" name="tgl_mulai" class="ipt_text" style="width:100px;" value="<?=$tgl_mulai;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Tanggal Selesai</td>
          <td colspan="3">
		  <input type="text" id="tgl_selesai" name="tgl_selesai" class="ipt_text" style="width:100px;" value="<?=$tgl_selesai;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="button" onclick="simpan();" value="Simpan" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
$(function() {	$( "#tgl_mulai" ).datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" });  });
$(function() {	$( "#tgl_selesai" ).datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" });  });
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
</script>