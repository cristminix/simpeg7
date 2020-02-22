<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsagenda/hapus_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS AGENDA</th>
        </tr>
        <tr>
          <td width="20%">Judul Agenda</td>
          <td colspan="3"><b><?=@$isi[0]->judul;?></b></td>
        </tr>
        <tr>
          <td width="20%">Isi Agenda</td>
          <td colspan="3"><b><?=@$isi[0]->isi_artikel;?></b></td>
        </tr>
        <tr>
          <td width="20%">Tempat</td>
          <td colspan="3"><b><?=@$isi[0]->sub_judul;?></b></td>
        </tr>
        <tr>
          <td>Rubrik Agenda</td>
          <td colspan="3"><b><?=@$isi[0]->nama_kategori;?></b></td>
        </tr>
        <tr>
          <td>Tanggal Mulai</td>
          <td colspan="3"><b><?=@$isi[0]->tgl_mulai;?></td>
        </tr>
        <tr>
          <td>Tanggal Selesai</td>
          <td colspan="3"><b><?=@$isi[0]->tgl_selesai;?></b></td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type=hidden name=idd value='<?=@$isi[0]->id_konten;?>'>
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
                } else {
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
				loadDialogTutup();
            });
			return false;
}
</script>