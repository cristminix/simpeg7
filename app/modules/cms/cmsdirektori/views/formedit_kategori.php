<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=base_url();?>cmsdirektori/save_kategori_aksi" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM EDIT KATEGORI DIREKTORI</th>
        </tr>
        <tr>
          <td width="20%">Nama Kategori</td>
		  <td width=10>:</td>
          <td colspan="2">
		  <input type="text" id="nama_kategori" name="nama_kategori" size="70" value="<?=$hslquery[0]->nama_kategori;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
        </tr>
        <tr>
          <td>Keterangan</td>
		  <td>:</td>
          <td colspan="2">
		  <input type="text" id="keterangan" name="keterangan" size="70" value="<?=$hslquery[0]->keterangan;?>" onblur="if(this.value=='') this.value='Wajib diisi';" onfocus="if(this.value=='Wajib diisi') this.value='';">
		  </td>
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
				<div id='no_<?=$nomor;?>' style='width:35px; float:left; margin-top:2px;'><?=$nomor;?></div>
				<div style='width:80px; float:left; display:table; padding-right:15px;'>
					<div class=grid_icon onclick="hapusFoto(<?=$nomor;?>);" id='tb_hapus_<?=$nomor;?>' title='Klik untuk menghapus atribut'><span class='ui-icon ui-icon-trash'></span></div>
					<div id="tb_naik_<?=$nomor;?>" class="grid_icon" title="Klik untuk menurunkan urutan atribut" onclick="urutFotoDb('naik',<?=$nomor;?>);"><span class="ui-icon ui-icon-arrowthick-1-n"></span></div>
					<div id="tb_turun_<?=$nomor;?>" class="grid_icon" title="Klik untuk menurunkan urutan atribut" onclick="urutFotoDb('turun',<?=$nomor;?>);"><span class="ui-icon ui-icon-arrowthick-1-s"></span></div>
				</div>
				<input type=hidden id='asli_urutan_<?=$nomor;?>' name=asli_urutan_[] value='<?=$val->urutan;?>'>
				<input type=hidden id='urutan_<?=$nomor;?>' name=urutan[] value='<?=$val->urutan;?>'>
				<input type=text id='atribut_<?=$nomor;?>' name=atribut[] value="<?=$val->nama_atribut;?>" size=70 style='float:left; margin-bottom:2px; padding:2px; display:table;'>
			</div>
			<?php
			$nomor++;
			}
			?>
			<div style='display:table;' id="rUpload">
				<div id='nomax' style='width:35px; float:left; margin-top:2px;'><?=$nomor;?></div>
				<div style='width:80px; float:left; display:table; padding-right:15px;'>&nbsp;</div>
				<div id="uploader" class="tombol_aksi2" onClick="insUpload();">Tambah Atribut</div>
			</div>
		  </td>
        </tr>
       <tr >
			<td>&nbsp;</td>
			<td colspan="3">
				<input type="hidden" id="idd" name="idd" value="<?=$hslquery[0]->id_kategori;?>">
				<input type="button" onclick="simpan();" value="Simpan" class="tombol_aksi" />
				<input type="button" onclick="batal();" value="Batal..."  class='tombol_aksi'/>
			</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
		$("#tb_naik_1").hide();
		$("#tb_turun_<?=($nomor-1);?>").hide();
});

function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
	loadDialogBuka();
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					gopaging();
					batal();
                }else{
					var status=arr_result[1];
					alert('Data gagal disimpan! \n '+status+'');
                }
			loadDialogTutup();
            });
			return false;
	} //endif Hasil
}
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(opsi){
	var data="";
	var dati="";
		var nama = $("#nama_kategori").val();
		var ketr = $("#keterangan").val();
		data=data+nama;
		if( nama =="Wajib diisi"){	dati=dati+"NAMA KATEGORI tidak boleh kosong\n";	}
		if( ketr =="Wajib diisi"){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
		$("#[id^='urutan_']").each(function(index,item) {
			var idx = item.value;
			var jdl = $("#atribut_"+idx+"").val();
			data=data+jdl;
			if( jdl ==""){	dati=dati+"ATRIBUT DIREKTORI No."+idx+" tidak boleh kosong\n";	}
		});

	if( data ==""){
		alert("DATA ATRIBUT TIDAK BOLEH KOSONG");
		return false;
	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}

function insUpload(){
	var noIns=parseInt($("#nomax").html());

	var tt= "<div style='display:table;' id='rwft_"+noIns+"'>";
	tt+= "<div id='no_"+noIns+"' style='width:35px; float:left; margin-top:2px;'>"+noIns+"</div>";
	tt+= "<div style='width:80px; float:left; display:table; padding-right:15px;'>";
	tt+= "<div class=grid_icon onclick=\"hapusFoto("+noIns+");\" id='tb_hapus_"+noIns+"' title='Klik untuk menghapus atribut'><span class='ui-icon ui-icon-trash'></span></div>";
	tt+= "<div id='tb_naik_"+noIns+"' class='grid_icon' title='Klik untuk menurunkan urutan atribut' onclick=\"urutFotoDb('naik',"+noIns+");\"><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
	tt+= "<div id='tb_turun_"+noIns+"' class='grid_icon' title='Klik untuk menurunkan urutan atribut' onclick=\"urutFotoDb('turun',"+noIns+");\"><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
	tt+= "</div>";
	tt+= "<input type=\"hidden\" id=\"asli_urutan_"+noIns+"\" name=\"asli_urutan[]\" value=\""+noIns+"\">";
	tt+= "<input type=\"hidden\" id=\"urutan_"+noIns+"\" name=\"urutan[]\" value=\""+noIns+"\">";
	tt+= "<input type=\"text\" id='atribut_"+noIns+"' name=atribut[] value=\"\" size=\"70\" style=\"float:left; margin-bottom:2px; padding:2px; display:table;\">";
	tt+= "</div>";
	$(tt).insertBefore("#rUpload");

	noInsp=noIns+1;
	$("#nomax").html(noInsp);

	reurut();
}

function urutFotoDb(aksi,urutan){	
	urut(aksi,urutan);
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
		var newNo=1;	$("#[id^='atribut_']").each(function() {	$(this).attr("id","atribut_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='tb_hapus_']").each(function() {	$(this).replaceWith("<div class=grid_icon onclick=\"hapusFoto("+newNo+");\" id='tb_hapus_"+newNo+"' title='Klik untuk menghapus atribut direktori'><span class='ui-icon ui-icon-trash'></span></div>");	newNo++;	});
		var newNo=1;	$("#[id^='tb_naik_']").each(function() {	$(this).replaceWith("<div class=grid_icon onclick=\"urutFotoDb('naik',"+newNo+");\" id='tb_naik_"+newNo+"' title='Klik untuk menaikkan urutan atribut direktori'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>");	newNo++;	});
		var newNo=1;	$("#[id^='urutan_']").each(function() {	$(this).attr("id","urutan_"+newNo+"").attr("value",newNo);	newNo++;	});
		var newNo=1;	$("#[id^='asli_urutan_']").each(function() {	$(this).attr("id","asli_urutan_"+newNo+"");	newNo++;	});
		var newNo=1;	$("#[id^='tb_turun_']").each(function() {	$(this).replaceWith("<div class=grid_icon onclick=\"urutFotoDb('turun',"+newNo+");\" id='tb_turun_"+newNo+"' title='Klik untuk menurunkan urutan atribut direktori'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>");	newNo++;	});
		$("#tb_naik_1").hide();
		$("#tb_turun_"+(newNo-1)+"").hide();
}
function hapusFotoDb(urutan){	
//	loadDialogTutup(); 
	okHapus(urutan);
}	
function hapusFotoDb_ASLI(urutan){	
loadDialogBuka();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsdirektori/hapus_atribut_aksi/",
				data:{"idd": <?=$idd;?>,"urutan":urutan },
				success:function(data){	okHapus(urutan);	loadDialogTutup();	}, 
				dataType:"html"});
	return false;
}	

function okHapus(idd){
		$("#tb_naik_"+idd+"").remove();
		$("#tb_turun_"+idd+"").remove();

		$("input[name=atribut"+[]+"]").val("hapus");
//		$("input.#atribut_"+idd+"").val("hapus");

		$("#rwft_"+idd+"").insertBefore("#rUpload").hide();








		reurut();
		var baru=parseInt($("#nomax").html())-1;
		$("#nomax").html(baru);
}
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
function hapusFoto(idd){
		var isiHapus = "<div>Atribut ini benar-benar ingin dihapus..?!</div><br><div>";
		isiHapus+= $("#atribut_"+idd+"").val();
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