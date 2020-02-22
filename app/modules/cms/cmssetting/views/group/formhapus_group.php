<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/group/hapus_group_aksi');?>" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS GRUP PENGGUNA</th>
        </tr>
        <tr>
          <td width="20%">Nama Grup Pengguna</td>
          <td colspan="3"><div class="ipt_text" style="width:400px;"><b><?=$group_name;?></b></div></td>
        </tr>
        <tr>
          <td>Theme</td>
          <td colspan="3"><div class="ipt_text" style="width:400px;"><b><?=$section_name;?></b></div></td>
        </tr>
        <tr>
          <td>Back Office</td>
          <td colspan="3"><div class="ipt_text" style="width:400px;"><b><?=$backoffice;?></b></div></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><div class="ipt_text" style="width:400px;"><b><?=$keterangan;?></b></div></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" name=idd value="<?=$group_id;?>"/>
				<input type="button" onclick="simpan();" value="Hapus" class='tombol_aksi' />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
function simpan(){
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					loadIsiGrid();
					batal();
                }else{
					var status=arr_result[1];
					alert('Data gagal disimpan! \n '+status+'');
                }
            });
			return false;
}
</script>