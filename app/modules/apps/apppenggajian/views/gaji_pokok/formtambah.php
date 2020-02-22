  <div class="row">
	<div class="col-lg-6">
<form id="content-form" method="post" action="<?=site_url("apppenggajian/gaji_pokok/tambah_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Tambah Data Master Gaji Pokok</b></div>
			<div class="panel-body">


				  <div class="row">
					<div class="col-lg-12">
							<div class="form-group">
									<label>Pangkat</label>
									 
									<?=form_dropdown('kode_golongan',$this->dropdowns->getKodeGolPangkat(),(!isset($val->kode_golongan))?'':$val->kode_golongan,'class="form-control" style="padding-left:2px; padding-right:2px; float:left;" id="kode_golongan" ');?>
								 
							</div>
							<div class="form-group">
									<label>Masa Kerja</label>
									<?=form_dropdown('masa_kerja',$this->dropdowns->getMasaKerja(),(!isset($val->masa_kerja))?'':$val->masa_kerja,'class="form-control" style="padding-left:2px; padding-right:2px; float:left;" id="masa_kerja" ');?>
							</div>
							
							<div class="form-group">
								<label>Gaji Pokok</label>
								<input  style="text-align: right" type="text" id="gaji_pokok" name="gaji_pokok" size="70" align="right" value="" onkeyup="numberFormat(this, '.')" class="form-control">
							</div>
							
							<div class="form-group">
								<label>Tahun</label>
								<input  style="text-align: right" type="text" id="tahun" name="tahun" size="70" align="right" value="" onkeyup="numberFormat(this, '')" class="form-control">
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
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
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
			var kd_gol = $.trim($("#kode_golongan").val());
			var ms_kerja = $.trim($("#masa_kerja").val());
			var gapok = $.trim($("#gaji_pokok").val());
			var thn = $.trim($("#tahun").val());
			data=data+""+kd_gol+"*"+ms_kerja+"**";
			if( kd_gol ==""){	dati=dati+"NAMA PANGKAT tidak boleh kosong\n";	}
			if( ms_kerja ==""){	dati=dati+"MASA KERJA tidak boleh kosong\n";	}
			if( gapok ==""){	dati=dati+"GAJI POKOK tidak boleh kosong\n";	}
			if( thn ==""){	dati=dati+"TAHUN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>