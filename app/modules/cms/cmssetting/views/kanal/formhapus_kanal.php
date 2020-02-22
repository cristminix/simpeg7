<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/menu/hapus_menu_aksi/1');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS KANAL</th>
        </tr>
        <tr>
          <td width="150">Nama Kanal</td>
          <td colspan="3"><div class="ipt_text" style="width:400px"><b><?=$nama_kanal; ?></b></div></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><div class="ipt_text" style="width:400px"><b><?=$keterangan; ?></b></div></td>
        </tr>
        <tr>
          <td>Tipe</td>
          <td colspan="3"><div class="ipt_text" style="width:200px"><b><?=$tipe;?></b></div></td>
        </tr>
        <tr>
          <td>Theme</td>
          <td colspan="3"><div class="ipt_text" style="width:200px"><b><?=$theme;?></b></div></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name='idd' id='idd' value='<?=$idd;?>'>
				<input type="hidden" name='idparent' id='idparent' value='<?=$idparent;?>'>
				<input type="button" onclick="simpan();" value="Hapus" class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
function simpan(){
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					$("[id^='row_<?=$rowparent;?>']").remove();
					loadIsiGrid("<?=$parent;?>",<?=$level;?>);
					batal();
                }else{
					var status=arr_result[1];
					alert('Data gagal disimpan! \n '+status+'');
                }
            });
			return false;
}
</script>