<style>
.image_view{
	width:350px;
}
.image-list{
	width:100px;
	margin:5px;
	float:left;
}
.image-list a{
	margin-left:15px;
}

</style>
<script language="javascript">	
jQuery(document).ready(function() {
	jQuery("#imgediting-form").submit(function(){
			var status= $('#notif-imgartikel');
			var interval;
            jQuery.post($(this).attr('action'),$(this).serialize(),function(data){
                if(data=='sukses'){
                  	status.html('');
					status.removeClass('msg-box-false');
					status.addClass('msg-box-true');
					status.html('<ul><li>Data telah disimpan</li></ul>');
                }else{
					status.html('');
					status.removeClass('msg-box-true');
					status.addClass('msg-box-false');
					status.html(data);
                }
            });
			return false;
    });
		
		
});	

function Remove_Image(id){
	jQuery.post('<?=site_url('cp/com/jqartikel/removeimage');?>', {id_image: id},function(data){
				var status= $('#notif-imgartikel');
	 			if(data=='sukses'){
                  	status.html('');
					status.removeClass('msg-box-false');
					status.addClass('msg-box-true');
					status.html('<ul><li>Gambar telah di hapus</li></ul>');
					$('#image_' + id ).html('');
					jQuery("#form_editingimage").load("<?=site_url('cp/com/jqartikel/formeditingimage/');?>/" + <?=$id_konten;?>);	
                }else{
					status.html('');
					status.removeClass('msg-box-true');
					status.addClass('msg-box-false');
					status.html(data);
                }
				
			});
			return false;
	}

</script>

<form id="imgediting-form" method="post" action="<?=site_url('cp/com/jqartikel/saveimagedata');?>" enctype="multipart/form-data">
<input type="hidden" name="id_konten" value="<?=$id_konten;?>"  />
<div  style="background-color:#FFFFFF">
  <table width="100%" cellspacing="1" cellpadding="5" class="table-form">
  <tr><th colspan="2">Edit Data Gambar</th></tr>
  <tr><td colspan="2"><input type="submit" name="save_data" value="Simpan Perubahan" />&nbsp;
     <input type="button" value="Batal" name="cancel" onclick="javascript:showgrid2();" /></td></tr>
    <?=$tr_list_image;?>
     <tr><td colspan="2" ><input type="submit" name="save_data" value="Simpan Perubahan" />&nbsp;
     <input type="button" value="Batal" name="cancel" onclick="javascript:showgrid2();" /></td></tr>
  </table>
</div>
</form>