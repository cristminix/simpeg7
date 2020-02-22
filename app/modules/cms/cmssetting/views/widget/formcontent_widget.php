<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('wwidget/saveaksi');?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Manage Master Widget</th>
        </tr>
        <tr>
          <td width="20%">Nama Widget</td>
          <td colspan="3"><input type="text" name="nama_widget" id="nama_widget" size="70" value="<?=$nama_widget;?>" /></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><input type="text" name="keterangan" id="keterangan" size="70" value="<?=$keterangan;?>" /></td>
        </tr>
        <tr colspan=3>
          <td>Posisi Widget</td>
          <td>
		  <select name="lokasi_widget" id="lokasi_widget">
            <option  value="">--Pilih Posisi--</option>
            <?=$lokasi_options;?>
          </select>
		</td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
			    <input type="hidden" name="idd" id="idd" value="<?=$idd;?>"  />
			  <input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="batal();" class="tombol_aksi" />      </td>
        </tr>
      </table>
	</form>
</div>


<script type="text/javascript">
function validasi_pengikut(){
	var data="";
	var dati="";
			var judl = $.trim($("#nama_widget").val());
			var rbrk = $.trim($("#keterangan").val());
			var tngl = $.trim($("#lokasi_widget").val());
			data=data+""+judl+"";
			if( judl ==""){	dati=dati+"NAMA WIDGET tidak boleh kosong\n";	}
			if( rbrk ==""){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
			if( tngl ==""){	dati=dati+"LOKASI WIDGET tidak boleh kosong\n";	}
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
					gopaging();
					batal();
                } else {

                }
            });
			return false;
	} //endif Hasil
}
</script>