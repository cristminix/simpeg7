                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">FORM EDIT MASTER SKPD</h4>
                                        </div>
                                        <div class="modal-body">

  <div class="row">
	<div class="col-lg-12">
				<div class="table-responsive">

    <form id="content-form" method="post" action="<?=site_url("appskp/skpd/editutama_aksi");?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <td width="20%">Nama Unor</td>
          <td colspan="3">
		  <input type="text" id="nama_unor" name="nama_unor" size="70" value="<?=@$isi[0]->nama_unor;?>">
		  </td>
        </tr>
        <tr>
          <td width="20%">Jenis Unor</td>
          <td colspan="3">
		  <input type="text" id="jenis" name="jenis" size="70" value="<?=@$isi[0]->jenis;?>">
		  </td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <td width="20%">Jabatan (nomenklatur)</td>
          <td colspan="3">
		  <input type="text" id="nomenklatur_jabatan" name="nomenklatur_jabatan" size="70" value="<?=@$isi[0]->nomenklatur_jabatan;?>">
		  </td>
        </tr>
        <tr>
          <td width="20%">pada</td>
          <td colspan="3">
		  <input type="text" id="nomenklatur_pada" name="nomenklatur_pada" size="70" value="<?=@$isi[0]->nomenklatur_pada;?>">
		  </td>
        </tr>
        <tr>
          <td width="20%">Index Pencarian</td>
          <td colspan="3">
		  <input type="text" id="nomenklatur_cari" name="nomenklatur_cari" size="70" value="<?=@$isi[0]->nomenklatur_cari;?>">
		  </td>
        </tr>
        <tr>
          <td>Eselon</td>
          <td colspan="3">
		  <?=form_dropdown('kode_ese',$this->dropdowns->kode_ese(),(!isset($isi[0]->kode_ese))?'':$isi[0]->kode_ese,'id="kode_ese"');?>
		  </td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <td>Kode Unor</td>
          <td colspan="3">
		  <input type="text" id="kode_unor" name="kode_unor" size="70" value="<?=@$isi[0]->kode_unor;?>">
		  </td>
        </tr>
      </table>
				<input type=hidden name=idd value='<?=$idd;?>'>
	</form>
				</div>
				<!-- /.table-responsive -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->
                                        </div>
	                                    <!-- /.modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="javascript:void(0);simpan();"  data-dismiss="modal">Simpan</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal...</button>
                                        </div>
	                                    <!-- /.modal-footer -->
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->

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
					$("[id^='row_<?=$rowparent;?>']").remove();
					gridpaging(1,<?=$level;?>,"<?=$parent;?>");
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