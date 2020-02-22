<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/wrapper_kanal/hapus_wrapper_aksi');?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Manage Kanal Wrapper</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Kanal</td>
          <td colspan="3"><b><?=$kanal;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Posisi Wrapper</td>
          <td colspan="3"><b><?=ucfirst($posisi);?></b></td>
        </tr>
        <tr>
          <td valign=top>Wrapper</td>
          <td colspan=3><?=$pilisi;?></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
			    <input type="hidden" name="posisi" id="posisi" value="<?=$posisi;?>"  />
			    <input type="hidden" name="idd" id="idd" value="<?=$idd;?>"  />
				<input type="hidden" name="kanal" id="kanal" value="<?=$id_kanal;?>" />
			  <input type="button" onclick="simpan();" value="Hapus" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="batal();" class="tombol_aksi" />      </td>
        </tr>
      </table>
	</form>
</div>


<script type="text/javascript">
function simpan(){
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					gridpaging("end");
					batal();
                } else {

                }
            });
			return false;
}
</script>