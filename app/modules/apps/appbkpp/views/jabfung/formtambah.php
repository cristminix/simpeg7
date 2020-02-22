  <div class="row">
	<div class="col-lg-6">
<form id="content-form" method="post" action="<?=site_url("appbkpp/jabfung/tambah_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Tambah Data Jabatan Fungsional</b></div>
			<div class="panel-body">


				  <div class="row">
					<div class="col-lg-12">
							<div class="form-group">
								<label>Kode jabatan fungsional</label>
								<input type="text" id="kode_bkn" name="kode_bkn" size="70" value="<?=@$unit->kode_bkn;?>" class="form-control">
							</div>
							<div class="form-group">
								<label>Nama jabatan fungsional</label>
								<input type="text" id="nama_jabatan" name="nama_jabatan" size="70" value="<?=@$unit->nama_jabatan;?>" class="form-control">
							</div>
							<div class="form-group" style="text-align:right;">
								<input type="hidden" id="jab_type" name="jab_type" value="<?=$tipe;?>">
									<button type="button" class="btn btn-primary" onclick="javascript:void(0);simpan();"><i class="fa fa-save fa-fw"></i> Simpan</button>
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
						gridpaging('end');
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
			if( nunr ==""){	dati=dati+"KODE JABATAN FUNGSIONAL tidak boleh kosong\n";	}
			if( jens ==""){	dati=dati+"NAMA JABATAN FUNGSIONAL tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>