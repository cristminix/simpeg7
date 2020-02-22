<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmssetting/wrapper_kanal/edit_setting_aksi');?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Manage Setting Kanal Wrapper</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Kanal</td>
          <td colspan="3"><b><?=$kanal;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Wrapper</td>
          <td colspan="3"><b><?=ucfirst($wrapper);?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Posisi Wrapper</td>
          <td colspan="3"><b><?=ucfirst($posisi);?></b><br/></td>
        </tr>
<?php
 foreach($kl AS $kk=>$vv){
?>
        <tr>
          <td valign=top><?=$vv->label;?></td>
          <td colspan=3>
		  <input type=hidden name="label[]" value="<?=$vv->label;?>">
		  <input type=hidden name="nama[]" value="<?=$vv->nama;?>">
		  <input type=text name="nilai[]" value="<?=$vv->nilai;?>" class="ipt_text" style="width:200px;">
		  </td>
        </tr>
<?php
}
?>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
			    <input type="hidden" name="id_item" id="id_item" value="<?=$id_item;?>"  />
			    <input type="hidden" name="posisi" id="posisi" value="<?=$posisi;?>"  />
			    <input type="hidden" name="id_wrapper" id="id_wrapper" value="<?=$id_wrapper;?>"  />
				<input type="hidden" name="kanal" id="kanal" value="<?=$id_kanal;?>" />
				<input type="hidden" name="asli" id="asli" value='<?=$asli;?>' />
			  <input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
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