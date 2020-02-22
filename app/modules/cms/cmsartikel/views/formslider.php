<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsartikel/edit_slider" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">SLIDER BERITA</th>
        </tr>
        <tr>
          <td width="20%">Judul Berita</td>
          <td colspan="3"><b><?=$isi[0]->judul;?></b></td>
        </tr>
        <tr>
          <td width="20%">Tanggal Berita</td>
          <td colspan="3"><b><?=$isi[0]->tanggal;?></b></td>
        </tr>
<?php
$no=1;
foreach($foto as $key=>$val){
echo "<tr id='rwft_$no'><td valign=top><b><div style=\"float:left\">Slider</div><div id='no_$no' style=\"display:none\">$no</div></b><br>";
echo "<div style='float:left; margin-top:3px;'><div class=grid_icon onclick=\"hapusFoto($no);\" id='tombol_$no' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>";
echo "<td id='gmbr_$no' width=270><img src='assets/media/file/slider/".$val->id_konten."/".$val->file_thumb."'></td>";
echo "<td colspan=2>Keterangan Foto<br><input type=text id=keterangan_$no name=keterangan[] size=40 value='".$val->keterangan."'><br><br>";
echo "<input type=hidden id=urutan_$no name=urutan[] value='$no'></td></tr>";
$no++;
}
if($no==2){ $dsp="style='display:none;'";} else {$dsp="";}
?>		  
        <tr id="rUpload" <?=$dsp;?>>
          <td width="20%"><div style="float:left ">Slider </div><div id="nomax" style="display:none"><?=$nomax;?></div></td>
          <td colspan="3">
<div id="stuploader" style="float:left; margin:5px 5px 0px 0px; font-weight:800"></div>
<div id="uploader" class="tombol_aksi2" onClick="uppl('uploader','stuploader','negara_peserta');">Upload Slider</div>
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type=hidden name=idd value='<?=$idd;?>'>
				<input type="button" onclick="simpan();" value="Simpan" class="tombol_aksi" />
				<input type="button" onclick="batal();gopaging();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
		uppl("uploader","stuploader","negara_peserta");
});

function uppl(bttn,stts,dokumen){	
		var btnUpload=$('#'+bttn+'') , interval;
		var status=$('#'+stts+'');
		new AjaxUpload(btnUpload, {
			action: '<?=base_url();?>cmsartikel/saveuploadslider',
			name: 'artikel_file',
			data: { "id_kategori": <?=$idd;?>  },
			onSubmit: function(file, ext){
				status.html('');
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Hanya File dengan ext JPG, PNG or GIF yang dapat diupload !');
					return false;
				}
				//status.text('Uploading...'); tambahan anim proses
				btnUpload.text('Uploading');
				interval = window.setInterval(function(){
					var text = btnUpload.text();
					if (text.length < 19){
						btnUpload.text(text + '.');					
					} else {
						btnUpload.text('Uploading');				
					}
				}, 200);
			},
			onComplete: function(file, response){
				//On completion clear the status
//				btnUpload.replaceWith("<div id='uploader' class='tombol_aksi2' onClick=\"uppl('uploader','stuploader','negara_peserta');\"><div>Upload Foto</div></div>");
				btnUpload.text("Upload Foto");
				status.html('');
				window.clearInterval(interval);
				status.text('');
				 var arr_result = response.split("-");
				//Add uploaded file to list
				if(arr_result[0]==="success"){
					status.removeClass('notification-error');
					file = file.replace(/%20/g, "");
//					status.html(file  + ", success di upload !" ).addClass('notification-ok');
//					status.html(file  + ", sukses di upload !" );
					insUpload(file);					
				} else{
//					status.html(file  + ", gagal di upload ! <br />" + arr_result[1] ).addClass('notification-error');					
					status.html(file  + ", gagal di upload ! <br />" + arr_result[1] );					
				}
//				loadFormImageEditing();
			}
		});
}

function insUpload(file){
	var noIns=parseInt($("#nomax").html());
	noInsp=noIns+1;
	$("#nomax").html(noInsp);
	var tt= "<tr id='rwft_"+noIns+"'><td valign=top><b><div style=\"float:left\">Slider</div><div id='no_"+noIns+"' style=\"display:none\">"+noIns+"</div></b><br>";
	tt+= "<div style=\"float:left\"><div class=grid_icon onclick=\"hapusFoto("+noIns+");\" id='tombol_"+noIns+"' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>";
	tt+= "<td id='gmbr_"+noIns+"' width=270><img src='assets/media/file/slider/<?=$idd;?>/thumbs_"+file+"'></td>";
	tt+= "<td colspan=2>Keterangan Foto<br><input type=text id=keterangan_"+noIns+" name=keterangan[] size=40><br><br>";
	tt+= "<input type=hidden id=urutan_"+noIns+" name=urutan[] value='"+noIns+"'></td></tr>";
	$(tt).insertBefore("#rUpload");
	$("#rUpload").hide();
}
////////////////////////////////////////////////////////////////////////////
function hapusFotoDb(urutan){	
loadDialogBuka();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsartikel/hapus_slider_aksi/",
				data:{"idd": <?=$idd;?>,"urutan":urutan },
				success:function(data){	okHapus(urutan);	loadDialogTutup();	}, 
				dataType:"html"});
	return false;
}	

function okHapus(idd){
		$("#rwft_"+idd+"").remove();
		$("#rUpload").show();
		var baru=parseInt($("#nomax").html())-1;
		$("#nomax").html(baru);
}

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
	loadDialogBuka();
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
				//alert(data);
                if(arr_result[0]=='sukses'){
					gopaging();
					batal();
                } else {
					alert('Data gagal disimpan! \n Lihat pesan diatas form');
                }
				loadDialogTutup();
            });
			return false;
	} //endif Hasil
}
function validasi_pengikut(opsi){
	var data="";
	var dati="";
		$("#[id^='urutan']").each(function(index,item) {
			var idx = item.value;
			var ket = $("#keterangan_"+idx+"").val();
			data=data+ket;
			if( ket ==""){	dati=dati+"KETERANGAN FOTO tidak boleh kosong\n";	}
		});

	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
function hapusFoto(idd){
		var isiHapus = "<div>Gambar ini benar-benar ingin dihapus..?!</div><br><div>";
		isiHapus+= $("#gmbr_"+idd+"").html();
		isiHapus+="</div><br><div class=tombol_aksi onclick=\"loadHapusTutup();hapusFotoDb("+idd+");\">Ya...</div>";
		isiHapus+="<div class=tombol_aksi onclick=\"loadHapusTutup();\">Batal...</div>";
	
		$("<div id='dialogHapus'  style=\"text-align:center\"></div>").appendTo("body");
		$('#dialogHapus').html(isiHapus);
		$("#dialogHapus").dialog({	autoOpen: false, height: 300, width: 400, modal: true, });
		$(".ui-dialog-titlebar").hide();
		$(".ui-resizable-se").remove();
		$('#dialogHapus').dialog('open');	
}

function loadHapusTutup(){ 
		$( "#dialogHapus" ).remove();
		$( "#dialogHapus" ).dialog( "close" );
}
</script>