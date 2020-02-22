                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">FORM EDIT <?=strtoupper($tipe);?></h4>
                                        </div>
                                        <div class="modal-body">

  <div class="row">
	<div class="col-lg-12">
				<div class="table-responsive">

    <form id="content-form" method="post" action="<?=site_url("appskp/tupoksi/edit_aksi");?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <td width="150">Unit organisasi</td>
          <td colspan="3"><b><?=$hslquery[0]->nomenklatur_pada;?></b></td>
        </tr>
        <tr>
          <td>Jenis jabatan</td>
          <td colspan="3"><b><?=ucfirst($jj);?></b></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td colspan="3"><b><?=$hslquery[0]->nomenklatur_jabatan;?></b></td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <td valign=top><?=ucfirst($tipe);?></td>
          <td colspan="3">
		  <textarea rows="4"  style="width:600px;" name="isi_tupoksi" id="isi_tupoksi"><?=$detail[0]->isi_tupoksi;?></textarea>
				<input type=hidden name=idt value='<?=$idt;?>'>
				<input type=hidden name=idd value='<?=$idd;?>'>
				<input type=hidden name=tipe value='<?=$tp;?>'>
				<input type=hidden name=jab_type value='<?=$jenis_jabatan;?>'>
		  </td>
        </tr>
      </table>
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
					gettupoksi();
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
			var isi = $.trim($("#isi_tupoksi").val());
			data=data+""+isi+"**";
			if( isi ==""){	dati=dati+"<?=strtoupper($tipe);?> tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
</script>