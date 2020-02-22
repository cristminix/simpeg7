<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/dashboard/saveaksi');?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Manage Panel Dashboard</th>
        </tr>
        <tr>
          <td width="20%">Text</td>
          <td colspan="3"><input type="text" name="text" id="text" size="70" value="<?=$text;?>" /></td>
        </tr><tr>
          <td>Warna</td>
          <td colspan="3"><input type="text" name="color" class="color" id="color" size="70" value="<?=$color;?>" /></td>
        </tr><tr>
          <td>Modul</td>
          <td colspan="3">
		  <textarea rows="4" name="module" id="module" size="70" rows="4"><?=(isset($module)?$module:'');?></textarea>
		  </td>
        </tr><tr>
          <td>URL</td>
          <td colspan="3"><input type="text" name="path" id="path" size="70" value="<?=$path;?>" /></td>
        </tr><tr>
          <td>Note</td>
          <td colspan="3">
			<textarea rows="4" name="note" id="note" size="70" rows="4"><?=(isset($note)?$note:'');?></textarea>
		  </td>
        </tr>
		<tr colspan=3>
          <td>Icon</td>
          <td>
		  <select name="icon" id="icon">
            <option  value="">--Pilih Icon--</option>
            <?=$icon_options;?>
          </select>
		</td>
        </tr>
        <tr colspan=3>
          <td>Status</td>
          <td>
		  <select name="status" id="status">
            <option  value="">--Pilih Status--</option>
            <?=$status_options;?>
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
$(function(){
	 $('.color').colorPicker(); // that's it
});
function validasi_pengikut(){
	var data="";
	var dati="";
			var judl = $.trim($("#text").val());
			var rbrk = $.trim($("#icon").val());
			var tngl = $.trim($("#path").val());
			data=data+""+judl+"";
			if( judl ==""){	dati=dati+"TEXT tidak boleh kosong\n";	}
			if( rbrk ==""){	dati=dati+"ICON tidak boleh kosong\n";	}
			if( tngl ==""){	dati=dati+"PATH tidak boleh kosong\n";	}
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
					gopaging();
					batal();
                
            });
			return false;
	} //endif Hasil
}
</script>