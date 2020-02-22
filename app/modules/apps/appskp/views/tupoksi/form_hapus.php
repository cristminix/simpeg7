                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">FORM HAPUS <?=strtoupper($tipe);?></h4>
                                        </div>
                                        <div class="modal-body">

  <div class="row">
	<div class="col-lg-12">
				<div class="table-responsive">

    <form id="content-form" method="post" action="<?=site_url("appskp/tupoksi/hapus_aksi");?>" enctype="multipart/form-data">
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
          <td colspan="3"><?=$detail[0]->isi_tupoksi;?>
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
                                            <button type="button" class="btn btn-primary" onclick="javascript:void(0);simpan();"  data-dismiss="modal">Hapus</button>
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
}
</script>