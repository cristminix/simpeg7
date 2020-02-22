<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsbanner/edit_foto" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">DAFTAR BANNER</th>
        </tr>
        <tr>
          <td width="20%">Album Banner</td>
          <td colspan="3"><b><?=$isi[0]->nama_kategori;?></b></td>
        </tr>
        <tr>
          <td width="20%">Keterangan</td>
          <td colspan="3"><b><?=$isi[0]->keterangan;?></b></td>
        </tr>
<?php
$no=1;
foreach($foto as $key=>$val){
echo "<tr id='rwft_$no'><td valign=top><b><div style=\"float:left\">Banner No.</div><div id='no_$no' style=\"float:left\">$no</div></b><br>";
echo "<div style='float:left; margin-top:3px;'><div class=grid_icon onclick=\"hapusFoto($no);\" id='tombol_$no' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>";
echo "<div class=grid_icon onclick=\"urutFotoDb('naik',$no);\" id='tb_naik_$no' title='Klik untuk menaikkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
echo "<div class=grid_icon onclick=\"urutFotoDb('turun',$no);\" id='tb_turun_$no' title='Klik untuk menurunkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div></div></td>";
echo "<td id='gmbr_$no' width=270><img src='assets/media/file/banner/".$val->foto."'></td>";
echo "<td colspan=2>Link<br><input type=text id=link_$no name=link[] size=40 value='".$val->foto_thumbs."'><br><br>";
echo "Keterangan<br><input type=text id=keterangan_$no name=keterangan[] size=40 value='".$val->judul_foto."'><br><br>";
echo "<input type=hidden id=urutan_$no name=urutan[] value='".$val->foto_urutan."'></td></tr>";
$no++;
}
?>		  
        <tr id="rUpload">
          <td width="20%"><div style="float:left ">Banner No. </div><div id="nomax" style="float:left "><?=$nomax;?></div></td>
          <td colspan="3">
<div id="stuploader" style="float:left; margin:5px 5px 0px 0px; font-weight:800"></div>
<div id="uploader" class="tombol_aksi2" onClick="uppl('uploader','stuploader','negara_peserta');">Upload Banner</div>
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
		$("#tb_naik_1").hide();
		$("#tb_turun_<?=$nomax-1;?>").hide();
});

function uppl(bttn,stts,dokumen){	
		var btnUpload=$('#'+bttn+'') , interval;
		var status=$('#'+stts+'');
		new AjaxUpload(btnUpload, {
			action: '<?=base_url();?>cmsbanner/saveupload',
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
	var tt= "<tr id='rwft_"+noIns+"'><td valign=top><b><div style=\"float:left\">Banner No.</div><div id='no_"+noIns+"' style=\"float:left\">"+noIns+"</div></b><br>";
	tt+= "<div style=\"float:left\"><div class=grid_icon onclick=\"hapusFoto("+noIns+");\" id='tombol_"+noIns+"' title='Klik untuk menghapus foto'><span class='ui-icon ui-icon-trash'></span></div>";
	tt+= "<div class=grid_icon onclick=\"urutFotoDb('naik',"+noIns+");\" id='tb_naik_"+noIns+"' title='Klik untuk menaikkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
	tt+= "<div class=grid_icon onclick=\"urutFotoDb('turun',"+noIns+");\" id='tb_turun_"+noIns+"' title='Klik untuk menurunkan urutan foto'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div></div></td>";
	tt+= "<td id='gmbr_"+noIns+"' width=270><img src='assets/media/file/banner/"+file+"'></td>";
	tt+= "<td colspan=2>Link<br><input type=text id=link_"+noIns+" name=link[] size=40><br><br>";
	tt+= "Keterangan<br><input type=text id=keterangan_"+noIns+" name=keterangan[] size=40><br><br>";
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
				url:"<?=base_url();?>cmsbanner/reurut_foto/",
				data:{"idd": <?=$idd;?>,"urutan_ini":urutan,"urutan_lawan":urutan_lawan },
				success:function(data){	urut(aksi,urutan);	loadDialogTutup();	}, 
				dataType:"html"});
	return false;
}	
function hapusFotoDb(urutan){	
loadDialogBuka();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsbanner/hapus_foto_aksi/",
				data:{"idd": <?=$idd;?>,"urutan":urutan },
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
		var newNo=1;	$("#[id^='link_']").each(function() {	$(this).attr("id","link_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='keterangan_']").each(function() {	$(this).attr("id","keterangan_"+newNo+"");	newNo++;	});
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
			var jdl = $("#link_"+idx+"").val();
			var ket = $("#keterangan_"+idx+"").val();
			data=data+jdl+ket;
			if( jdl ==""){	dati=dati+"LINK No."+idx+" tidak boleh kosong\n";	}
			if( ket ==""){	dati=dati+"KETERANGAN No."+idx+" tidak boleh kosong\n";	}
		});

	if( data ==""){
		alert("DATA BANNER TIDAK BOLEH KOSONG");
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