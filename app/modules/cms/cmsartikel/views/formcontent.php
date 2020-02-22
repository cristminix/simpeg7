<script language="javascript">	
$(document).ready(function(){
	getWIKategori();		
	tinyMCE.idCounter=0;
	tinyMCE.execCommand('mceAddControl', true, 'catatan');	
});	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {	$( "#tanggal" ).datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" });  });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getWIKategori(){
		$("#tbl_back").hide();
		var rbrk=$("#rubrikl").val();
		$('#wi-media-box-content').load('<?=base_url();?>cmsgaleri/getWIKategori/'+rbrk+'');
	}
	
	function getWIImageDetails(id_cat){
		$("#tbl_back").show();
		$('#wi-media-box-content').load('<?=base_url();?>cmsgaleri/getWIImageDetails/'+id_cat);
	}
</script>
<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="<?=site_url('cmsartikel/saveartikel');?>" enctype="multipart/form-data">
    <input type="hidden" name="komponen" id="komponen" value="<?=$komponen;?>"  />
    <input type="hidden" name="id_konten" id="id_konten" value="<?=$id_konten;?>"  />
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Manage Konten</th>
        </tr>
        <tr>
          <td width="12%">Judul Artikel *</td>
          <td colspan="3"><input type="text" name="judul" id="judul" value="<?=$judul;?>" style="width:400px" class="ipt_text"/></td>
        </tr>
        <tr>
          <td width="12%">Sub Judul</td>
          <td colspan="3"><input type="text" name="sub_judul" id="sub_judul" value="<?=$sub_judul;?>" style="width:400px" class="ipt_text"/></td>
        </tr>
        <tr>
          <td>Rubrik *</td>
          <td width="29%">
		  <select name="id_kategori" id="id_kategori" class="ipt_text" style="width:350px;">
            <option  value="">--Pilih Rubrik--</option>
            <?=$rubrik_options;?>
          </select>
		  </td>
          <td width="8%">Penulis *</td>
          <td width="51%"><select name="id_penulis" id="id_penulis"  class="ipt_text" style="width:200px;">
            <option  value="">--Pilih Penulis--</option>
            <?=$penulis_options;?>
          </select></td>
        </tr>
        <tr>
          <td>Tanggal *</td>
          <td colspan="3"><input type="text" name="tanggal" id="tanggal" value="<?=$tanggal;?>" style="width:100px;" class="dpicker-artikel ipt_text" readonly="readonly" /></td>
        </tr>
        <tr>
          <td valign="top">Isi Artikel</td>
          <td colspan="3"><textarea name="catatan" id="catatan" style="width:500px; height:200px"><?=$isi_artikel;?></textarea></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
			  <input type="button" onclick="javascript:tinyMCE.execCommand('mceRemoveControl',false,'catatan');simpan();" value="Simpan" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="javascript:tinyMCE.execCommand('mceRemoveControl',false,'catatan');batal();" class="tombol_aksi" />      </td>
        </tr>
      </table>
	</form>
</div>


<!-- WIDGET GALERI FOTO -->
<div id="wi-media-box">	
<form id="jkk">
	<div class="toolbar">
		<select name="rubrikl" id="rubrikl" onchange="getWIKategori();" style="width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;">
		<option value="xx">Semua Rubrik Berita Foto</option>
<? 
echo Modules::run("web/kategori_options","","galeri");
?>
		</select>
    	<a href="javascript:void(0);" onclick="getWIKategori();" class="bt-flat-yh" id='tbl_back' style='display:none'><< Kembali...</a>
	</div>
</form>    
	<div id="wi-media-box-content"></div>
    
</div>    

<script type="text/javascript">
function validasi_pengikut(){
	var data="";
	var dati="";
			var judl = $.trim($("#judul").val());
			var rbrk = $.trim($("#id_kategori").val());
			var tngl = $.trim($("#tanggal").val());
			var pnls = $.trim($("#id_penulis").val());
			data=data+""+judl+"";
			if( judl ==""){	dati=dati+"JUDUL ARTIKEL tidak boleh kosong\n";	}
			if( rbrk ==""){	dati=dati+"RUBRIK tidak boleh kosong\n";	}
			if( tngl ==""){	dati=dati+"TANGGAL tidak boleh kosong\n";	}
			if( pnls ==""){	dati=dati+"PENULIS tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
	tinyMCE.idCounter=0;
	tinyMCE.execCommand('mceAddControl', true, 'catatan');	
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					gridpaging(1);
					batal();
                } else {
	tinyMCE.idCounter=0;
	tinyMCE.execCommand('mceAddControl', true, 'catatan');	
                }
            });
			return false;
	} //endif Hasil
}
</script>


<style>
#wi-media-box {	float:right;	width:210px;	height:555px;	border:7px solid #EDEDED;		overflow-x:hidden;	overflow-y:auto;}
#wi-media-box ul {	margin:0;	padding:0;	list-style:none;}
#wi-media-box ul li {	float:left;	margin:2px;	text-align:center;}
#wi-media-box ul li a {}
#wi-media-box ul li img, #wi-media-box ul li a img {	width:90px;	height:90px;	background:#fff;	padding:1px;	border:solid 1px #ccc;	opacity:0.8;}
#wi-media-box ul li img:hover, #wi-media-box ul li a img:hover {	opacity:1;}
#wi-media-box .toolbar {}
</style>