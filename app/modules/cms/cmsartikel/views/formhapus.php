<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmsartikel/hapusartikel');?>" enctype="multipart/form-data">
    <input type="hidden" name="id_konten" id="id_konten" value="<?=@$isi[0]->id_konten;?>"  />
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Form Hapus <?=ucfirst(@$isi[0]->komponen);?></th>
        </tr>
        <tr>
          <td width="12%">Judul Artikel *</td>
          <td colspan="3"><b><?=@$isi[0]->judul;?></b></td>
        </tr>
        <tr>
          <td width="12%">Sub Judul</td>
          <td colspan="3"><b><?=@$isi[0]->sub_judul;?></b></td>
        </tr>
        <tr>
          <td>Rubrik *</td>
          <td width="29%"><b><?=@$isi[0]->nama_kategori;?></b></td>
          <td width="8%">Penulis *</td>
          <td width="51%"><b><?=@$isi[0]->nama_penulis;?></b></td>
        </tr>
        <tr>
          <td>Tanggal *</td>
          <td colspan="3"><b><?=@$isi[0]->tanggal;?></b></td>
        </tr>
        <tr>
          <td valign="top">Isi Artikel</td>
          <td colspan="3"><?=@$isi[0]->isi_artikel;?></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
			  <input type="button" onclick="simpan();" value="Hapus" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="batal();" class="tombol_aksi" />      </td>
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
					gopaging("end");
					batal();
                }
            });
			return false;
}
</script>