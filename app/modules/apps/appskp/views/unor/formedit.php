  <div class="row">
	<div class="col-lg-12">
<form id="content-form" method="post" action="<?=site_url("appskp/skpd/editutama_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Edit Data Unit Organisasi</b></div>
			<div class="panel-body">




				  <div class="row">
					<div class="col-lg-6">
							<div class="form-group">
								<label>Kode unor</label>
								<input type="text" id="kode_unor" name="kode_unor" size="70" value="<?=@$isi[0]->kode_unor;?>" class="form-control">
							</div>
							<div class="form-group">
								<label>Nama unor</label>
								<input type="text" id="nama_unor" name="nama_unor" size="70" value="<?=@$isi[0]->nama_unor;?>" class="form-control">
							</div>
							<div class="form-group">
								<label>Jenis unor</label>
								<input type="text" id="jenis" name="jenis" size="70" value="<?=@$isi[0]->jenis;?>" class="form-control">
							</div>
					</div>
					<!-- /.col-lg-6 -->
					<div class="col-lg-6">
							<div class="form-group">
								<label>Jabatan nomenklatur</label>
								<input type="text" id="nomenklatur_jabatan" name="nomenklatur_jabatan" size="70" value="<?=@$isi[0]->nomenklatur_jabatan;?>" class="form-control">
							</div>
							<div class="form-group">
								<label>pada</label>
								<input type="text" id="nomenklatur_pada" name="nomenklatur_pada" size="70" value="<?=@$isi[0]->nomenklatur_pada;?>" class="form-control">
							</div>
							<div class="form-group">
								<label>Eselon</label>
								<?=form_dropdown('kode_ese',$this->dropdowns->kode_ese(),(!isset($isi[0]->kode_ese))?'':$isi[0]->kode_ese,'id="kode_ese"  class="form-control"');?>
							</div>
							<div class="form-group">
								<label>Indeks pencarian</label>
								<input type="text" id="nomenklatur_cari" name="nomenklatur_cari" size="70" value="<?=@$isi[0]->nomenklatur_cari;?>" class="form-control">
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
						jQuery('#back-button').click();
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
			var nunr = $.trim($("#nama_unor").val());
			var jens = $.trim($("#jenis").val());
			var nkjb = $.trim($("#nomenklatur_jabatan").val());
			var pada = $.trim($("#nomenklatur_pada").val());
			var cari = $.trim($("#nomenklatur_cari").val());
			var ides = $.trim($("#kode_ese").val());
			var kode = $.trim($("#kode_unor").val());
			data=data+""+nunr+"*"+nkjb+"**";
			if( nunr ==""){	dati=dati+"NAMA SKPD tidak boleh kosong\n";	}
			if( jens ==""){	dati=dati+"JENIS tidak boleh kosong\n";	}
			if( nkjb ==""){	dati=dati+"JABATAN (nomenklatur) tidak boleh kosong\n";	}
			if( pada ==""){	dati=dati+"LOKASI JABATAN (pada) tidak boleh kosong\n";	}
			if( cari ==""){	dati=dati+"INDEX PENCARIAN tidak boleh kosong\n";	}
			if( ides ==""){	dati=dati+"ESELON tidak boleh kosong\n";	}
			if( kode ==""){	dati=dati+"KODE UNOR tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>