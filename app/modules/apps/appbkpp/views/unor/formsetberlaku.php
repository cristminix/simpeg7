  <div class="row">
	<div class="col-lg-6">
<form id="content-form" method="post" action="<?=site_url("appbkpp/unor/setberlaku_aksi");?>" enctype="multipart/form-data" role="form">
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa fa-edit fa-fw"></i> <b>Form Reset Masa Berlaku</b></div>
			<div class="panel-body">


				  <div class="row">
					<div class="col-lg-12">
							<div class="form-group">
								<label>Masa berlaku</label>
								<input type="text" id="tmt_berlaku" name="tmt_berlaku" value="01-01-2008" class="form-control">
							</div>
							<div class="form-group">
								<label>s.d.</label>
								<input type="text" id="tst_berlaku" name="tst_berlaku" value="31-12-2014" class="form-control">
							</div>
							<div class="form-group" style="text-align:right;">
								<input type="hidden" id="idd" name="idd" value="<?=$idd;?>">
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
			var tmtb = $.trim($("#tmt_berlaku").val());
			var tstb = $.trim($("#tst_berlaku").val());
			data=data+""+tmtb+"*"+tstb+"**";
			if( tmtb ==""){	dati=dati+"TMT BERLAKU tidak boleh kosong\n";	}
			if( tstb ==""){	dati=dati+"TST BERLAKU tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>