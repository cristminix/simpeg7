<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/kategori/hapus_kategori_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS RUBRIK</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Kanal</td>
          <td colspan="3"><b><?=strtoupper($kanal);?></b></td>
        </tr>
        <tr>
          <td>Komponen</td>
          <td colspan="3"><div class='ipt_text' style="width:200px;"><b><?=$komponen;?></b></div></td>
        </tr>
        <tr>
          <td width="150">Nama Rubrik</td></b>
          <td colspan="3"><div class='ipt_text' style="width:400px;"><b><?=$nama_kategori;?></div></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><div class='ipt_text' style="width:400px;"><b><?=$keterangan;?></b></div></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type=hidden name='idd' id='idd' value=<?=$idd;?>>
				<input type="button" onclick="simpan();" value="Hapus" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
function simpan(){
			var status= $('#notification-artikel');
			var interval;
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
				//alert(data);
                if(arr_result[0]=='sukses'){
					if(arr_result[1] == 'add'){
						jQuery('#back-button').click();
					}
					loadFragment('#main_panel_container','<?=site_url();?>cmssetting/kategori');
					batal();
                } else {
					status.html('');
					status.html('<ul><li>' + arr_result[1] + '</li></ul>');
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
            });
			return false;
}
////////////////////////////////////////////////////////////////////////////
</script>