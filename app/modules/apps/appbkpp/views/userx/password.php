<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM GANTI PASSWORD</th>
        </tr>
        <tr>
          <td width="20%">Nama Pengguna</td>
          <td colspan="3"><b><?=$nama_user;?></b></td>
        </tr>
        <tr>
          <td>Username</td>
          <td colspan="3"><b><?=$username;?></b></td>
        </tr>
        <tr>
          <td>Grup Pengguna</td>
          <td colspan="3"><b><?=$group_name;?></b></td>
        </tr>
        <tr>
          <td>Password Baru</td>
          <td colspan="3"><input type="password" id="pw1" name="pw1" class=ipt_text style="width:250px;"></td>
        </tr>
        <tr>
          <td>Ulangi Password</td>
          <td colspan="3"><input type="password" id="pw2" name="pw2" class=ipt_text style="width:250px;"></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
				<input type="hidden" name='user_id' id='user_id' value='<?=$user_id;?>'>
		  <input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
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
			var nn1 = $.trim($("#pw1").val());
			var nn2 = $.trim($("#pw2").val());
			data=nn1+"*"+nn2;
			if( nn1 ==""){	dati=dati+"PASSWORD 1 tidak boleh kosong\n";	}
			if( nn2 ==""){	dati=dati+"PASSWORD 2 tidak boleh kosong\n";	}
			if( nn1 != nn2){	dati=dati+"PASSWORD 1 dan PASSWORD 2 harus sama\n";	}
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
				url:"<?=site_url();?>cmssetting/user/edit_pw/",
				data:{	"idd":<?=$user_id;?>, "hasil":hasil	},
				success:function(data){
						loadFragment('#main_panel_container', '<?=site_url('login/out');?>');
				},//tutup::success
				dataType:"html"
			});//tutup ajax
		} //tutup if::hasil
	} //tutup::simpan
</script>
