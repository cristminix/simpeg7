<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsdirektori/hapus_kategori_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS KATEGORI DIREKTORI</th>
        </tr>
        <tr>
          <td width="20%">Nama Kategori</td>
		  <td width=10>:</td>
          <td colspan="2"><b><?=$hslquery[0]->nama_kategori;?></b></td>
        </tr>
        <tr>
          <td>Keterangan</td>
		  <td>:</td>
          <td colspan="2"><b><?=$hslquery[0]->keterangan;?></b></td>
        </tr>
        <tr>
          <td valign=top style='padding-top:7px;'>Atribut</td>
		  <td valign=top style='padding-top:7px;'>:</td>
          <td colspan="2">
			<?php
			$nomor=1;
			foreach($atribut as $key=>$val){
			?>
			<div style='display:table;' id='rwft_<?=$nomor;?>'>
				<div id='no_<?=$nomor;?>' style='width:35px; float:left; margin-top:2px;'><?=$nomor;?>.</div>
				<div style='float:left; margin-bottom:2px; padding:2px; display:table;'><b><?=$val->nama_atribut;?></b></div> 
			</div>
			<?php
			$nomor++;
			}
			?>
		  </td>
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
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					gridpaging('end');
					batal();
                }else{
					var status=arr_result[1];
					alert('Data gagal disimpan! \n '+status+'');
                }
			loadDialogTutup();
            });
			return false;
}
</script>