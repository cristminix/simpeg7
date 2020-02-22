<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsgaleri/hapus_rubrik_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS RUBRIK BERITA FOTO</th>
        </tr>
        <tr>
          <td width="20%">Nama Rubrik</td>
          <td colspan="3"><b><?=$hslquery[0]->nama_kategori;?></b></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><b><?=$hslquery[0]->keterangan;?></b></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" id="idd" name="idd" value="<?=$hslquery[0]->id_kategori;?>">
				<input type="button" onclick="simpan();" value="Hapus" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
function simpan(){
	loadDialogBuka();
			var status= $('#notification-artikel');
			var interval;
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
				//alert(data);
                if(arr_result[0]=='sukses'){
					if(arr_result[1] == 'add'){
						jQuery('#back-button').click();
					}
					gridpaging("end");
					batal();
                }else{
					status.html('');
					status.html('<ul><li>' + arr_result[1] + '</li></ul>');
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
			loadDialogTutup();
            });
			return false;
}
</script>