<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM TAMBAH PENGGUNA</th>
        </tr>
        <tr>
          <td width="20%">Nama Pengguna</td>
          <td colspan="3">
		  <input type="text" id="nm_pengguna" name="nm_pengguna" class=ipt_text style="width:250px;" value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Username</td>
          <td colspan="3">
		  <input type="text" id="user_name" name="user_name" class=ipt_text style="width:250px;"  value="Wajib diisi" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Grup Pengguna</td>
          <td colspan="3"><?=$pilgr;?></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3"><input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
            &nbsp;
            <input type="button" name="cancel" value="Batal..." onclick="javascript:batal();" class='tombol_aksi' />      </td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function validasi_tambah(){
	var data="";
	var dati="";
			var nnm = $.trim($("#nm_pengguna").val());
			var icn = $.trim($("#user_name").val());
			var nnp = $.trim($("#group_id").val());
			data=data+""+nnm+"*"+icn+"*"+nnp+"**";
			if( nnm =="Wajib diisi"){	dati=dati+"NAMA PENGGUNA tidak boleh kosong\n";	}
			if( icn =="Wajib diisi"){	dati=dati+"USERNAME tidak boleh kosong\n";	}
			if( nnp ==""){	dati=dati+"GRUP PENGGUNA tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
	function simpan(){
		var hasil=validasi_tambah();
		if (hasil!=false) {
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmssetting/user/tambah_aksi/",
				data:{	"nama_user":hasil	},
				success:function(data){
			gridpaging("end");
			batal();
				},//tutup::success
				dataType:"html"
			});//tutup ajax
		} //tutup if::hasil
	} //tutup::simpan
</script>
