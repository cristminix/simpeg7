<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsdirektori/hapus_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS ITEM DIREKTORI</th>
        </tr>
        <tr bgcolor="#FFFF99">
          <td>Kategori</td>
          <td colspan="3"><b><?=$pilrb;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Nama Item Direktori</td>
          <td colspan="3"><b><?=@$ini[0]->judul;?></b></td>
        </tr>
<?php
foreach($atribut as $key=>$val){
?>
        <tr>
          <td  id='nama_atribut_<?=$val->urutan;?>'><?=$val->nama_atribut;?></td>
          <td colspan="3"><b><?=$val->isi_atribut;?></b></td>
        </tr>
<?php
}
?>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="button" onclick="simpan();" value="Hapus" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function simpan(){
	loadDialogBuka();
			var interval;
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
				//alert(data);
                if(arr_result[0]=='sukses'){
					if(arr_result[1] == 'add'){
						jQuery('#back-button').click();
					}
					gopaging();
					batal();
                } else {
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
				loadDialogTutup();
            });
			return false;
}
////////////////////////////////////////////////////////////////////////////
</script>