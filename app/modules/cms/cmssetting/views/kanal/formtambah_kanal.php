<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/kanal/tambah_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM TAMBAH KANAL</th>
        </tr>
        <tr>
          <td width="150">Nama Kanal</td>
          <td colspan="3">
		  <input type="text" id="nama_kanal" name="nama_kanal" class="ipt_text" style="width:400px;" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3">
		  <input type="text" id="keterangan" name="keterangan" class="ipt_text" style="width:400px;" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Tipe</td>
          <td colspan="3">
		  <select name=tipe id=tipe class="ipt_text" style="width:200px;">
		  <option value='biasa' selected>Biasa</option>
		  <option value='liputan'>Liputan</option>
		  </select>
		  </td>
        </tr>
        <tr>
          <td>Theme</td>
          <td colspan="3"><?=$theme;?></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name='idparent' value="<?=$idparent;?>" />
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
					$("#tombol_hapus_<?=$parent;?>").hide();
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
			var kket = $.trim($("#keterangan").val());
			data=data+""+nama+"*"+kket+"**";
			if( nama =="Wajib diisi"){	dati=dati+"NAMA KANAL tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>