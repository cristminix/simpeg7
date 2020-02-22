                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">FORM HAPUS MASTER SKPD</h4>
                                        </div>
                                        <div class="modal-body">

  <div class="row">
	<div class="col-lg-12">
				<div class="table-responsive">

    <form id="content-form" method="post" action="<?=site_url("appskp/skpd/hapusutama_aksi");?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <td width="20%">Nama Unor</td>
          <td colspan="3"><b><?=@$isi[0]->nama_unor;?></b></td>
        </tr>
        <tr>
          <td width="20%">Jenis Unor</td>
          <td colspan="3"><b><?=@$isi[0]->jenis;?></b></td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <td width="20%">Jabatan (nomenklatur)</td>
          <td colspan="3"><b><?=@$isi[0]->nomenklatur_jabatan;?></b></td>
        </tr>
        <tr>
          <td width="20%">pada</td>
          <td colspan="3"><b><?=@$isi[0]->nomenklatur_pada;?></b></td>
        </tr>
        <tr>
          <td width="20%">Index Pencarian</td>
          <td colspan="3"><b><?=@$isi[0]->nomenklatur_cari;?></b></td>
        </tr>
        <tr>
          <td>Eselon</td>
          <td colspan="3">
		  <?=form_dropdown('kode_ese',$this->dropdowns->kode_ese(),(!isset($isi[0]->kode_ese))?'':$isi[0]->kode_ese,'id=kode_ese');?>
		  </td>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
          <td>Kode Unor</td>
          <td colspan="3"><b><?=@$isi[0]->kode_unor;?></b></td>
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
					$("[id^='row_<?=$rowparent;?>']").remove();
					gridpaging(1,<?=$level;?>,"<?=$parent;?>");
                } else {
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
            });
			return false;
}
</script>