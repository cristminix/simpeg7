  <div class="row">
	<div class="col-lg-12">
<form id="content-form" method="post" action="<?=site_url("appbkpp/unor/hapus_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-danger">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Hapus Data Unit Kerja</b></div>
			<div class="panel-body">


				  <div class="row">
					<div class="col-lg-6">
							<div class="form-group">
								<label>Kode unor</label>
								<input type="text" id="kode_unor" name="kode_unor" size="70" value="<?=@$unit->kode_unor;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
								<label>Nama unor</label>
								<input type="text" id="nama_unor" name="nama_unor" size="70" value="<?=@$unit->nama_unor;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
								<label>Jenis unor</label>
								<input type="text" id="jenis" name="jenis" size="70" value="<?=@$unit->jenis;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
								<label>Jabatan nomenklatur</label>
								<input type="text" id="nomenklatur_jabatan" name="nomenklatur_jabatan" size="70" value="<?=@$unit->nomenklatur_jabatan;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
								<label>pada</label>
								<input type="text" id="nomenklatur_pada" name="nomenklatur_pada" size="70" value="<?=@$unit->nomenklatur_pada;?>" class="form-control" disabled="">
							</div>
					</div>
					<!-- /.col-lg-6 -->
					<div class="col-lg-6">
							
							<div class="form-group">
								<label>Indeks pencarian</label>
								<input type="text" id="nomenklatur_cari" name="nomenklatur_cari" size="70" value="<?=@$unit->nomenklatur_cari;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
								<label>Masa berlaku</label>
								<input type="text" id="tmt_berlaku" name="tmt_berlaku" size="10" value="<?=@$unit->tmt_berlaku;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
								<label>s.d.</label>
								<input type="text" id="tst_berlaku" name="tst_berlaku" size="10" value="<?=@$unit->tst_berlaku;?>" class="form-control" disabled="">
							</div>
							<div class="form-group">
									<?php
										if(!empty($cekPegUnor)){ echo "<h3>Unit Kerja Ini Sudah Dipakai, Tidak Bisa Dihapus</h3>"; }
									?>
							</div>
							<div class="form-group" style="text-align:right;">
								<input type="hidden" id="idd" name="idd" value="<?=@$unit->id_unor;?>">
									<?php
										if(empty($cekPegUnor)){
									?>
									<button type="button" class="btn btn-danger" onclick="javascript:void(0);simpan();"><i class="fa fa-trash fa-fw"></i> Hapus</button>
									<?php
									}
									?>
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
			var kode = $.trim($("#kode_unor").val());
			var tmtb = $.trim($("#tmt_berlaku").val());
			var tstb = $.trim($("#tst_berlaku").val());
			data=data+""+nunr+"*"+nkjb+"**";
			if( nunr ==""){	dati=dati+"NAMA SKPD tidak boleh kosong\n";	}
			if( jens ==""){	dati=dati+"JENIS tidak boleh kosong\n";	}
			if( nkjb ==""){	dati=dati+"JABATAN (nomenklatur) tidak boleh kosong\n";	}
			if( pada ==""){	dati=dati+"LOKASI JABATAN (pada) tidak boleh kosong\n";	}
			if( cari ==""){	dati=dati+"INDEX PENCARIAN tidak boleh kosong\n";	}
			if( kode ==""){	dati=dati+"KODE UNOR tidak boleh kosong\n";	}
			if( tmtb ==""){	dati=dati+"TMT BERLAKU tidak boleh kosong\n";	}
			if( tstb ==""){	dati=dati+"TST BERLAKU tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>