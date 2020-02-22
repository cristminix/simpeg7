<div style="float:left;width:80%;">
    <form>
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT MENU</th>
        </tr>
        <tr>
          <td width=170>Nama Menu</td>
          <td colspan="3">
		  <input type="text" id="menu_name" name="menu_name" size="70" value="<?=$hslquery[0]->menu_name; ?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';" style="width:400px;" class="ipt_text">
		  </td>
        </tr>
        <tr>
          <td>Icon Menu</td>
          <td colspan="3"><input type="text" name="icon_menu" id="icon_menu" size="70" value="<?=$hslquery[0]->icon_menu; ?>" style="width:400px;" class="ipt_text" /></td>
        </tr>
        <tr>
          <td>Path Menu</td>
          <td colspan="3">
		  <input type="text" id="menu_path" name="menu_path" size="70" value="<?=$hslquery[0]->menu_path; ?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';" style="width:400px;" class="ipt_text">
		  </td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3">
		  <input type="text" id="keterangan" name="keterangan" size="70" value="<?=$hslquery[0]->keterangan; ?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';" style="width:400px;" class="ipt_text">
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name='idd' id='idd' value='<?=$id_menu;?>'>
				<input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(opsi){
	var data="";
	var dati="";
			var nnm = $.trim($("#menu_name").val());
			var icn = $.trim($("#icon_menu").val());
			var nnp = $.trim($("#menu_path").val());
			var kket = $.trim($("#keterangan").val());
			data=data+""+nnm+"*"+icn+"*"+nnp+"*"+kket+"**";
			if( nnm =="Wajib diisi"){	dati=dati+"NAMA MENU tidak boleh kosong\n";	}
			if( nnp =="Wajib diisi"){	dati=dati+"PATH MENU tidak boleh kosong\n";	}
			if( kket =="Wajib diisi"){	dati=dati+"KETERANGAN MENU tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
	function simpan(){
		var hasil=validasi_pengikut();

		if (hasil!=false) {
			var idd = $("#idd").val();
			var PENGIKUT = hasil;
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/menu/edit_menu_aksi/",
				data:{	"idd":idd,"nama_menu":hasil	},
				success:function(data){
					$("[id^='row_<?=$rowparent;?>']").remove();
					loadIsiGrid("<?=$parent;?>",<?=$level;?>);
					batal();
				},//tutup::success
				dataType:"html"
			});//tutup ajax
		} //tutup if::hasil
	} //tutup::simpan
</script>