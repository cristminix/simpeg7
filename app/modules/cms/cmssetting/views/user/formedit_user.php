<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_konten" id="id_konten" value=""  />
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT PENGGUNA</th>
        </tr>
        <tr>
          <td width="20%">Nama Pengguna</td>
          <td colspan="3">
		  <input type="text" id="nama_user" name="nama_user" class=ipt_text style="width:250px;" value="<?=$hslquery[0]->nama_user;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Username</td>
          <td colspan="3">
		  <input type="text" id="user_name" name="user_name" class=ipt_text style="width:250px;" value="<?=$hslquery[0]->username;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Grup Pengguna</td>
          <td colspan="3">
		  <select id='group_id' name='gorup_id' class=ipt_text style="width:250px;">
		  	<option value="">-- Pilih --</option>
			<?php
			foreach($hslqueryb as $key=>$val){
				if($val->group_id==$hslquery[0]->group_id){
					echo "<option value='".$val->group_id."' selected id='gr_".$val->group_id."'>".$val->group_name."</option>";
				} else {
					echo "<option value='".$val->group_id."' id='gr_".$val->group_id."'>".$val->group_name."</option>";
				}
			}
			?>  
		  </select>
		  </td>
        </tr>
<!--
        <tr>
          <td>Password 1</td>
          <td colspan="3">
		  <input type="password" id="pw1" name="pw1" size="70" value="<?=$hslquery[0]->user_password;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Password 2</td>
          <td colspan="3">
		  <input type="password" id="pw2" name="pw2" size="70" value="<?=$hslquery[0]->user_password;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
-->
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
				<input type="hidden" name='user_id' id='user_id' value='<?=$user_id;?>'>
		  <input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="javascript:batal();" class='tombol_aksi' />
		</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function validasi_tambah(){
	var data="";
	var dati="";
			var nnm = $.trim($("#nama_user").val());
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
			var user_id = $("#user_id").val();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmssetting/user/edit_aksi/",
				data:{	"user_id":user_id, "nama_user":hasil	},
				success:function(data){
					gopaging();
					batal();
				},//tutup::success
				dataType:"html"
			});//tutup ajax
		} //tutup if::hasil
	} //tutup::simpan
	function langsung(){
			var user_id = $("#user_id").val();
			var nnm = $.trim($("#nama_user").val());
			var icn = $.trim($("#user_name").val());
			var nnp = $.trim($("#group_id").val());
			var nnk = $("#gr_"+nnp+"").html();
		$( "#nama_user_"+user_id+"" ).html(nnm);
		$( "#user_name_"+user_id+"" ).html(icn);
		$( "#group_name_"+user_id+"" ).html(nnk);
	}
</script>
