<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/kategori/tambah_kategori_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM TAMBAH RUBRIK</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Kanal</td>
          <td colspan="3"><b><?=strtoupper($kanal);?></b></td>
        </tr>
        <tr>
          <td>Komponen</td>
          <td colspan="3"><?=$komponen;?></td>
        </tr>
        <tr>
          <td width="150">Nama Rubrik</td>
          <td colspan="3"><input type="text" id="nama_kategori" name="nama_kategori" class="ipt_text" style="width:400px;" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';"></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><input type="text" id="keterangan" name="keterangan" class="ipt_text" style="width:400px;" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';"></td>
        </tr>
       <tr id="tombol">
			<td>&nbsp;</td>
			<td colspan="3">
				<input type=hidden name='idd_kanal' id='idd_kanal' value=<?=$id_kanal;?>>
				<input type="button" onclick="simpan();" value="Simpan" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	lanjut();
});

function lanjut(){
	var kpn = $("#komponen").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>cms"+kpn+"/custom_kategori/",
		beforeSend:function(){	loadDialogBuka();$(".custom").remove(); },
		success:function(data){	
			$(data).insertBefore("#tombol");
			loadDialogTutup();
		}, 
	dataType:"html"});
}


function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
			var status= $('#notification-artikel');
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
					status.html('');
					status.html('<ul><li>' + arr_result[1] + '</li></ul>');
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
            });
			return false;
	} //endif Hasil
}
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(opsi){
	var data="";
	var dati="";
			var nama = $.trim($("#nama_kategori").val());
			var kket = $.trim($("#keterangan").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"NAMA RUBRIK tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>