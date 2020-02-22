<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url();?>cmsdirektori/tambah_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM TAMBAH ITEM DIREKTORI</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Kategori</td>
          <td colspan="3"><?=$pilrb;?></td>
        </tr>
        <tr>
          <td>Nama Item Direktori</td>
          <td colspan="3">
		  <input type="text" id="nama_direktori" name="nama_direktori" class="ipt_text" style="width:400px;" value="<?=$nama_direktori;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
<?php
$urutan=1;
foreach($atribut as $key=>$val){
?>
        <tr>
          <td  id='label_atribut_<?=$urutan;?>'><?=$val->label;?></td>
          <td colspan="3">
		  <input type="text" id='isi_atribut_<?=$urutan;?>' name="isi_atribut[]" class="ipt_text" style="width:400px;" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  <input type='hidden' id='label_<?=$urutan;?>'  name="label[]" value="<?=$val->label;?>">
		  <input type='hidden' id='no_atribut_<?=$urutan;?>'  value="<?=$urutan;?>">
		  </td>
        </tr>
<?php
$urutan++;
}
?>
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
		var nama = $("#nama_direktori").val();
		data=data+nama;
		if( nama =="Wajib diisi"){	dati=dati+"NAMA ITEM DIREKTORI tidak boleh kosong\n";	}
		$("[id^='no_atribut_']").each(function(index,item) {
			var idx = item.value;
			var jdl_nm = $("#label_atribut_"+idx+"").html();
			var jdl = $("#isi_atribut_"+idx+"").val();
			data=data+jdl;
			if( jdl =="Wajib diisi"){	dati=dati+jdl_nm+" tidak boleh kosong\n";	}
		});
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>