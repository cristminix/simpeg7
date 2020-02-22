  <div class="row">
	<div class="col-lg-6">
<form id="content-form" method="post" action="<?=site_url("apppenggajian/tunjangan_kelompok/tambah_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Tambah Data Master Tunjangan Kelompok</b></div>
			<div class="panel-body">


				  <div class="row">
					<div class="col-lg-12">
							
							<div class="form-group">
								<label>Tunjangan Kelompok</label>
								<input  style="text-align: left" type="text" id="tunjangan_kelompok" name="tunjangan_kelompok" size="70" align="right" value="" class="form-control">
							</div>
							
							<label>Status</label>
							<div class="form-group">
							
							 <label class="radio-inline">
								  <input type="radio" name="optradio" id="optradio" checked="" value="aktif">Aktif
								</label>
								<label class="radio-inline">
								  <input type="radio" name="optradio" id="optradio" value="tidak aktif">Tidak Aktif
								</label>
							</div>
							
							<div class="form-group" style="text-align:right;">
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
					alert('Data gagal disimpan!');
                }
            });
			return false;
	} //endif Hasil
}
////////////////////////////////////////////////////////////////////////////

function numberFormat(objek, separator) {
	a = objek.value;
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
		  c = b.substr(i-1,1) + separator + c;
		} else {
		  c = b.substr(i-1,1) + c;
		}
	}
	objek.value = c;
};

function validasi_isian(){
	var data="";
	var dati="";
			var tunjangan_kelompok = $.trim($("#tunjangan_kelompok").val());
			data=data+""+tunjangan_kelompok+"*";
			if( tunjangan_kelompok ==""){	dati=dati+"TUNJANGAN KELOMPOK tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>