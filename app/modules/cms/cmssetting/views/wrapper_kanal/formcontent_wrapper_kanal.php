<div style="float:left;width:80%;">
<style>
.kepTb{background-color:#D3F3FE; border-top: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-bottom: 1px dotted #3399CC; FONT-WEIGHT: normal; FONT-SIZE: 12px; FONT-FAMILY: arial, verdana, helvetica, serif; text-align:center;}
.kepTb.left { background-color:#D3F3FE; border: 1px dotted #3399CC; font-weight:bold; FONT-SIZE: 12px; FONT-FAMILY: arial, verdana, helvetica, serif;}
.cellTb { color:#666666; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}
.cellTb.left {  color:#000000; background-color:#D3F3FE; border-left: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}
</style>
    <form id="content-form" method="post" action="<?=site_url('cmssetting/wrapper_kanal/save_wrapper_aksi');?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Manage Kanal Wrapper</th>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Kanal</td>
          <td colspan="3"><b><?=$kanal;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td>Posisi Wrapper</td>
          <td colspan="3"><b><?=ucfirst($posisi);?></b></td>
        </tr>
        <tr>
          <td valign=top>Wrapper</td>
          <td colspan=3>
		  	<table width="100%" cellspacing=0 cellpadding=0 style="border-bottom: 1px dotted #3399CC;">
				<thead id=gridhead>
					<tr height=35>
						<td width=50  class='kepTb left'><b>No.</b></td>
						<td width=25 class=kepTb><b>OPSI</b></td>
						<td width=410 class=kepTb><b>WRAPPER</b><br/>Rubrik Pengisi</td>
						<td class=kepTb><b>WIDGET</b><br/>Komponen</td>
					</tr>
				</thead>
				<tbody id=pilmenu>
		  <?=$pilisi;?>
				</tbody>
				<tr><td colspan=4 class='gridcell left'>&nbsp;</td></tr>
			</table>
		  </td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
			    <input type="hidden" name="posisix" id="posisix" value="<?=$posisi;?>"  />
			    <input type="hidden" name="id_kanalx" id="id_kanalx" value="<?=$id_kanal;?>"  />
			    <input type="hidden" name="path_kanalx" id="path_kanalx" value="<?=$path_kanal;?>"  />
			  <input type="button" onclick="simpan();" value="Simpan" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="batal();" class="tombol_aksi" />      </td>
        </tr>
      </table>
	</form>
</div>


<script type="text/javascript">
function validasi_pengikut(){
	var data="";
	var dati="";
		$("[id^='pilisi_']").each(function(index,item) {
			var idx = item.checked;
			var idn = item.value;
			if(idx==true){
				data=data+""+idn+"_";
			}
		});
	if( data ==""){
		alert("WRAPPER tidak boleh kosong");
		return false;
	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
/*
	var data="";
	var dati="";
			var publ = $('input:checkbox[name=pilisi]:checked').val();
			data=data+""+publ+"";
			if( publ ==undefined){	dati=dati+"WRAPPER tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
*/
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					gridpaging("end");
					batal();
                } else {

                }
            });
			return false;
	} //endif Hasil
}
</script>