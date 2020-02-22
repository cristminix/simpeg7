<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmsartikel/savepenulis');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Form Edit Penulis</th>
        </tr>
        <tr>
          <td width="12%">Nama Penulis *</td>
          <td colspan="3"><input type="text" name="nama_penulis" id="nama_penulis"  style="width:204px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;" value="<?=@$hslquery[0]->nama_penulis;?>" /></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
		  	<input type=hidden name=id_penulis value="<?=@$hslquery[0]->id_penulis;?>">
			  <input type="button" onclick="javascript:simpan();" value="Simpan" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="javascript:batal();" class="tombol_aksi" />      </td>
        </tr>
      </table>
	</form>
</div>



<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(){
	var data="";
	var dati="";
			var nama = $.trim($("#nama_penulis").val());
			data=data+""+nama+"";
			if( nama ==""){	dati=dati+"NAMA PENULIS tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					batal();
					gridpaging('end');
                } else {
                }
            });
			return false;
	} //endif Hasil
}
</script>
