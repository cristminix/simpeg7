  <div class="row">
	<div class="col-lg-6">
<form id="content-form" method="post" action="<?=site_url("apppenggajian/pendapatan_lain/hapus_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Hapus Data Master Pendapatan Lain</b></div>
			<div class="panel-body">
							<div class="form-group">
								<label>Pendapatan Lain</label>
								<input type="text" style="text-align: left"  id="pendapatan_lain" name="pendapatan_lain" size="70" value="<?=@$unit->pendapatan_lain;?>" class="form-control"  disabled="">
							</div>
							
							<label>Status</label>
							<div class="form-group">
							
						<?php
							if (@$unit->status == "aktif")
							{
								echo '<label class="radio-inline"><input type="radio" name="optradio" id="optradio"  checked="" value="aktif" disabled="">Aktif</label>';
								echo '<label class="radio-inline"><input type="radio" name="optradio" id="optradio"  value="tidak aktif" disabled="">Tidak Aktif</label>';
							}
							else
							{
								echo '<label class="radio-inline"><input type="radio" name="optradio" id="optradio"  value="aktif" disabled="">Aktif</label>';
								echo '<label class="radio-inline"><input type="radio" name="optradio" id="optradio" checked="" value="tidak aktif" disabled="">Tidak Aktif</label>';
							}
                        ?>
								
							<div class="form-group" style="text-align:right;">
							<input type="hidden" id="idd" name="idd" value="<?=@$unit->id_pendapatan_lain;?>">
									<button type="button" class="btn btn-danger" onclick="javascript:void(0);simpan();"><i class="fa fa-save fa-fw"></i> Hapus</button>
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


$( document ).ready(function() {
	// var gapok = $("#masa_kerja").val();
   // jQuery("#masa_kerja").val(getNumFormat(gapok,"."));
});

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


function getNumFormat(objek, separator) {
	// alert(separator);
	a = objek;
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
	 // jQuery("#gaji_pokok").val(11111);
	// $("#gaji_pokok").val("111");
	// alert (c);
	// objek.value = c;
	
	// objek = c;
	return c;
};

function numberFormat(objek, separator) {
	// alert(objek);
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
			var pendapatan_lain = $.trim($("#pendapatan_lain").val());
			data=data+""+pendapatan_lain+"*";
			if( pendapatan_lain ==""){	dati=dati+"PENDAPATAN LAIN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>