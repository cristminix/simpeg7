  <div class="row">
	<div class="col-lg-6">
<form id="content-form" method="post" action="<?=site_url("appbkpp/user/edit_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-success">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Edit Data Pengguna</b></div>
			<div class="panel-body">


				  <div class="row">
					<div class="col-lg-12">
							<div class="form-group">
								<label>Nama Pengguna</label>
								<input type="text" id="" name="nama_user" size="70" value="<?=@$unit->nama_user;?>" class="form-control">
							</div>
							<div class="form-group">
								<label>User Name</label>
								<input type="text" id="" name="username" size="70" value="<?=@$unit->username;?>" class="form-control">
							</div>
							 <div class="form-group">
								<label>Status</label>
								<?=form_dropdown('status', $this->dropdowns->status(), @$unit->status,' class="form-control" id="status"');?>
							  </div>
							 <div class="form-group">
								<label>Grup Pengguna</label>
								<?=form_dropdown('group', $this->dropdowns->group(), @$unit->group,' class="form-control" id="group"');?>
							  </div> 
							<div class="form-group" style="text-align:right;">
								<input type="hidden" id="idd" name="idd" value="<?=@$unit->user_id;?>">
									<button type="button" class="btn btn-success" onclick="javascript:void(0);simpan();"><i class="fa fa-save fa-fw"></i> Simpan</button>
									<button type="button" class="btn btn-default" onclick="batal();"><i class="fa fa-close fa-fw"></i>Batal...</button>
							</div>
					</div>
					<!-- /.col-lg-6 -->
				  </div>
				<!-- /.row -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
</form>
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->


<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_isian();
	if (hasil!=false) {
			var interval;
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
				//alert(data);
                if(arr_result[0]=='sukses'){
					if(arr_result[1] == 'add'){
						gopaging();
						batal();
					}
                } else {
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
            });
			return false;
	} //endif Hasil
}
////////////////////////////////////////////////////////////////////////////
function validasi_isian(){
	var data="";
	var dati="";
			var nunr = $.trim($("#kode_bkn").val());
			var jens = $.trim($("#nama_jabatan").val());
			data=data+""+nunr+"*"+jens+"**";
			// if( nunr ==""){	dati=dati+"KODE JABATAN FUNGSIONAL tidak boleh kosong\n";	}
			// if( jens ==""){	dati=dati+"NAMA JABATAN FUNGSIONAL tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>