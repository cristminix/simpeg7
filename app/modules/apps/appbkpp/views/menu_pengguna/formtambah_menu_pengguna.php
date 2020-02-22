<div style="float:left;width:80%;margin-bottom:50px;">
<style>
.kepTb{background-color:#D3F3FE; border-top: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-bottom: 1px dotted #3399CC; FONT-WEIGHT: normal; FONT-SIZE: 12px; FONT-FAMILY: arial, verdana, helvetica, serif; text-align:center;}
.kepTb.left { background-color:#D3F3FE; border: 1px dotted #3399CC; font-weight:bold; FONT-SIZE: 12px; FONT-FAMILY: arial, verdana, helvetica, serif;}
.cellTb { color:#666666; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}
.cellTb.left {  color:#000000; background-color:#D3F3FE; border-left: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}
</style>
    <form id="content-form" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_konten" id="id_konten" value=""  />
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM TAMBAH MENU PENGGUNA</th>
        </tr>
        <tr>
          <td width="20%">Grup Pengguna</td>
          <td colspan="3"><div class="ipt_text" style="width:200px;"><b><?=$nama_group;?></b></div></td>
        </tr>
        <tr>
          <td valign=top>Menu Pengguna</td>
          <td colspan="3">
		  	<table width="100%" cellspacing=0 cellpadding=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
				<thead id=gridhead>
					<tr height=35>
						<td width=50  class='kepTb left'><b>No.</b></td>
						<td width=25 class=kepTb><b>OPSI</b></td>
						<td width=230 class=kepTb><b>MENU</b></td>
						<td class=kepTb><b>KETERANGAN</b></td>
					</tr>
				</thead>
				<tbody id=pilmenu>

				</tbody>
				<tr><td colspan=4 class='gridcell left'>&nbsp;</td></tr>
			</table>
		</td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3"><input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
            &nbsp;
            <input type="button" name="cancel" value="Batal..." onclick="javascript:batal();" class='tombol_aksi' />      </td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
//	var group_id=$("#group_pil").val();
//	var group_ini=$("#gr_"+group_id+"").html();
//	$("#nama_group").replaceWith(group_ini);
	loadmenuAll(0);
});
function loadmenuAll(idp){
	var group_id=$("#group_pil").val();
		$.ajax({
        type:"POST",
        url:"<?=site_url();?>cmssetting/menu_pengguna/getmenuuserAll/",
		data:{"idparent": idp,"id_setting":"<?=$id_setting;?>","id_setting_ref":"<?=$id_setting_ref;?>","group_id":"<?=$group_id;?>" },
        success:function(data){
			$("#pilmenu").html(data);
		},
        dataType:"html"});
}

function validasi_tambah(){
	var data="";
	var dati="";
		$("[id^='ccshdk']").each(function(index,item) {
			var idx = item.checked;
			var idn = item.value;
			if(idx==true){
				data=data+""+idn+"_";
			}
		});
	if( data ==""){
		alert("MENU tidak boleh kosong");
		return false;
	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
	function simpan(){
		var hasil=validasi_tambah();
		var group_id=$("#group_pil").val();
		if (hasil!=false) {
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/menu_pengguna/tambah_menu_pengguna_aksi/",
				data:{	"menu":hasil,"id_setting":"<?=$id_setting;?>","id_setting_ref":"<?=$id_setting_ref;?>","group_id":"<?=$group_id;?>"	},
				success:function(data){
					$("[id^='row_']").remove();
					loadIsiGrid(0,0);
					batal();
				},//tutup::success
				dataType:"html"
			});//tutup ajax
		} //tutup if::hasil
	} //tutup::simpan
</script>
