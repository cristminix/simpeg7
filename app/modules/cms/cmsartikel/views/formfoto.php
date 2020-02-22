<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsartikel/edit_info" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">DAFTAR FOTO</th>
        </tr>
        <tr bgcolor="#FFFF99">
          <td width="20%">Kategori</td>
          <td colspan="3"><b><?=$isi[0]->nama_kategori;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Judul Konten</td>
          <td colspan="3"><b><?=$isi[0]->judul;?></b></td>
        </tr>
<?php
$no=1;
foreach($foto as $key=>$val){
echo "<tr id='rwft_$no'><td valign=top><b><div style=\"float:left\">Foto No.</div><div id='no_$no' style=\"float:left\">$no</div></b><br>";
echo "<div style='float:left; margin-top:3px;'><div class=grid_icon onclick=\"hapusFoto($no);\" id='tombol_$no' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>";
echo "<div class=grid_icon onclick=\"urutFotoDb('naik',$no);\" id='tb_naik_$no' title='Klik untuk menaikkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
echo "<div class=grid_icon onclick=\"urutFotoDb('turun',$no);\" id='tb_turun_$no' title='Klik untuk menurunkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div></div></td>";
echo "<td id='gmbr_$no' width=270><img src='assets/media/file/".$isi[0]->komponen."/".$val->id_konten."/".$val->foto_thumbs."'></td>";
echo "<td colspan=2>Judul Foto<br><input type=text id=judul_foto_$no name=judul_foto[] size=40 value='".$val->judul_foto."'><br><br>";
echo "Keterangan Foto<br><input type=text id=ket_foto_$no name=ket_foto[] size=40 value='".$val->ket_foto."'><br><br>";
echo "Fotografer<br><input type=text id=fotografer_$no name=fotografer[] size=40 value='".$val->fotografer."'><br><br>";
echo "Asal foto<br><input type=text id=foto_from_$no name=foto_from[] size=40 value='".$val->foto_from."'><br><br>";
echo "<input type=hidden id=urutan_$no name=urutan[] value='".$val->foto_urutan."'></td></tr>";
$no++;
}
?>		  
        <tr id="rUpload">
          <td width="20%"><div style="float:left ">Foto No. </div><div id="nomax" style="float:left "><?=$nomax;?></div></td>
          <td colspan="3">
<div id="stuploader" style="float:left; margin:5px 5px 0px 0px; font-weight:800"></div>
<div id="uploader" class="tombol_aksi2" onClick="uppl('uploader','stuploader','negara_peserta');">Upload Foto</div>
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type=hidden name=idd value='<?=$isi[0]->id_konten;?>'>
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
		$("#tb_naik_1").hide();
		$("#tb_turun_<?=$nomax-1;?>").hide();
});

function uppl(bttn,stts,dokumen){	
		var btnUpload=$('#'+bttn+'') , interval;
		var status=$('#'+stts+'');
		new AjaxUpload(btnUpload, {
			action: '<?=base_url();?>cmsartikel/saveupload',
			name: 'artikel_file',
			data: { "id_konten": <?=$isi[0]->id_konten;?>,"komponen":"<?=$isi[0]->komponen;?>"    },
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
	var tt= "<tr id='rwft_"+noIns+"'><td valign=top><b><div style=\"float:left\">Foto No.</div><div id='no_"+noIns+"' style=\"float:left\">"+noIns+"</div></b><br>";
	tt+= "<div style=\"float:left\"><div class=grid_icon onclick=\"hapusFoto("+noIns+");\" id='tombol_"+noIns+"' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>";
	tt+= "<div class=grid_icon onclick=\"urutFotoDb('naik',"+noIns+");\" id='tb_naik_"+noIns+"' title='Klik untuk menaikkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
	tt+= "<div class=grid_icon onclick=\"urutFotoDb('turun',"+noIns+");\" id='tb_turun_"+noIns+"' title='Klik untuk menurunkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div></div></td>";
	tt+= "<td id='gmbr_"+noIns+"' width=270><img src='assets/media/file/<?=$isi[0]->komponen;?>/<?=$isi[0]->id_konten;?>/thumbs_"+file+"'></td>";
	tt+= "<td colspan=2>Judul Foto<br><input type=text id=judul_foto_"+noIns+" name=judul_foto[] size=40><br><br>";
	tt+= "Keterangan Foto<br><input type=text id=ket_foto_"+noIns+" name=ket_foto[] size=40><br><br>";
	tt+= "Fotografer<br><input type=text id=fotografer_"+noIns+" name=fotografer[] size=40><br><br>";
	tt+= "Asal foto<br><input type=text id=foto_from_"+noIns+" name=foto_from[] size=40><br><br>";
	tt+= "<input type=hidden id=urutan_"+noIns+" name=urutan[] value='"+noIns+"'></td></tr>";
	$(tt).insertBefore("#rUpload");
	reurut();
}
////////////////////////////////////////////////////////////////////////////
function urutFotoDb(aksi,urutan){	
if(aksi=="naik"){var urutan_lawan=urutan-1;}else{var urutan_lawan=urutan+1;}
loadDialogBuka();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsartikel/reurut_foto/",
				data:{"idd": <?=$isi[0]->id_konten;?>,"urutan_ini":urutan,"urutan_lawan":urutan_lawan },
				success:function(data){	urut(aksi,urutan);	loadDialogTutup();	}, 
				dataType:"html"});
	return false;
}	
function hapusFotoDb(urutan){	
loadDialogBuka();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsartikel/hapus_foto_aksi/",
				data:{"idd": <?=$isi[0]->id_konten;?>,"komponen":"<?=$isi[0]->komponen;?>","urutan":urutan },
				success:function(data){	okHapus(urutan);	loadDialogTutup();	}, 
				dataType:"html"});
	return false;
}	

function okHapus(idd){
		$("#rwft_"+idd+"").remove();
		reurut();
		var baru=parseInt($("#nomax").html())-1;
		$("#nomax").html(baru);
}

function urut(operasi,idd){
		if(operasi=="naik"){
			var idxBaru=idd-1; var nomax=$("#nomax").html();
			$("#rwft_"+idd+"").insertBefore("#rwft_"+idxBaru+"");
		} else {
			var idxBaru=idd+1;
			$("#rwft_"+idd+"").insertAfter("#rwft_"+idxBaru+"");
		}
		reurut();
}

function reurut(){
		var newNo=1;	$("#[id^='no_']").each(function() {	$(this).attr("id","no_"+newNo+"").html(newNo);	newNo++;	});
		var newNo=1;	$("#[id^='rwft_']").each(function() {	$(this).attr("id","rwft_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='gmbr_']").each(function() {	$(this).attr("id","gmbr_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='judul_foto_']").each(function() {	$(this).attr("id","judul_foto_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='ket_foto_']").each(function() {	$(this).attr("id","ket_foto_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='foto_from_']").each(function() {	$(this).attr("id","foto_from_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='fotografer_']").each(function() {	$(this).attr("id","fotografer_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='tombol_']").each(function() {	$(this).replaceWith("<div class=grid_icon onclick=\"hapusFoto("+newNo+");\" id='tombol_"+newNo+"' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>");	newNo++;	});
		var newNo=1;	$("#[id^='tb_naik_']").each(function() {	$(this).replaceWith("<div class=grid_icon onclick=\"urutFotoDb('naik',"+newNo+");\" id='tb_naik_"+newNo+"' title='Klik untuk menaikkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>");	newNo++;	});
		var newNo=1;	$("#[id^='tb_turun_']").each(function() {	$(this).replaceWith("<div class=grid_icon onclick=\"urutFotoDb('turun',"+newNo+");\" id='tb_turun_"+newNo+"' title='Klik untuk menurunkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>");	newNo++;	});
		var newNo=1;	$("#[id^='urutan_']").each(function() {	$(this).attr("id","urutan_"+newNo+"").attr("value",newNo);	newNo++;	});
		$("#tb_naik_1").hide();
		$("#tb_turun_"+(newNo-1)+"").hide();
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
			var jdl = $("#judul_foto_"+idx+"").val();
			var ket = $("#ket_foto_"+idx+"").val();
			var fgr = $("#fotografer_"+idx+"").val();
			var frm = $("#foto_from_"+idx+"").val();
			data=data+jdl+ket+fgr+frm;
			if( jdl ==""){	dati=dati+"JUDUL FOTO No."+idx+" tidak boleh kosong\n";	}
			if( ket ==""){	dati=dati+"KETERANGAN FOTO No."+idx+" tidak boleh kosong\n";	}
			if( fgr ==""){	dati=dati+"FOTOGRAFER FOTO No."+idx+" tidak boleh kosong\n";	}
			if( frm ==""){	dati=dati+"ASAL FOTO No."+idx+" tidak boleh kosong\n";	}
		});

	if( data ==""){
		alert("DATA FOTO BERITA TIDAK BOLEH KOSONG");
		return false;
	}
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