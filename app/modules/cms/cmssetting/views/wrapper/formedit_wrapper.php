<div style="float:left;width:80%;">
<style>
.kepTb{background-color:#D3F3FE; border-top: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-bottom: 1px dotted #3399CC; FONT-WEIGHT: normal; FONT-SIZE: 12px; FONT-FAMILY: arial, verdana, helvetica, serif; text-align:center;}
.kepTb.left { background-color:#D3F3FE; border: 1px dotted #3399CC; font-weight:bold; FONT-SIZE: 12px; FONT-FAMILY: arial, verdana, helvetica, serif;}
.cellTb { color:#666666; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}
.cellTb.left {  color:#000000; background-color:#D3F3FE; border-left: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}
</style>
    <form id="content-form" method="post" action="<?=site_url('cmssetting/wrapper/edit_wrapper_aksi');?>" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4">Form Edit Wrapper</th>
        </tr>
        <tr>
          <td width="20%">Nama Wrapper</td>
          <td colspan="3"><input type="text" name="nama_wrapper" id="nama_wrapper" class="ipt_text" style="width:400px;" value="<?=$nama_wrapper;?>"/></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td colspan="3"><input type="text" name="keterangan" id="keterangan" class="ipt_text" style="width:400px;"  value="<?=$keterangan;?>"/></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Widget</td>
          <td colspan="3"><b><?=$nama_widget;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Posisi widget</td>
          <td colspan="3"><b><?=$posisi;?></b></td>
        </tr>
        <tr bgcolor="#99CCCC">
          <td width="20%">Komponen</td>
          <td colspan="3"><b><?=$komponen;?></b></td>
        </tr>
        <tr>
          <td valign=top>Isi Wrapper</td>
          <td colspan=3>
		  	<table width="100%" cellspacing=0 cellpadding=0 style="border-bottom: 1px dotted #3399CC;">
				<thead id=gridhead>
					<tr height=35>
						<td width=50  class='kepTb left'><b>No.</b></td>
						<td width=25 class=kepTb><b>OPSI</b></td>
						<td width=230 class=kepTb><b>WRAPPER</b></td>
						<td class=kepTb><b>KETERANGAN</b></td>
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
		  <input type=hidden name=idd value="<?=$idd;?>">
		  <input type=hidden name=id_widget value="<?=$id_widget;?>">
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
	var dasi=""

		$("[id^='widget_i']").each(function(index,item) {
			var idx = item.checked;
			var idn = item.value;
			if(idx==true){
				dasi=dasi+""+idn+"";
			}
		});


			var judl = $.trim($("#nama_wrapper").val());
			var rbrk = $.trim($("#keterangan").val());
			data=data+""+judl+"*"+dasi+"";
			if( judl ==""){	dati=dati+"NAMA WRAPPER tidak boleh kosong\n";	}
			if( rbrk ==""){	dati=dati+"KETERANGAN tidak boleh kosong\n";	}
			if( dasi ==""){	dati=dati+"ISI WRAPPER tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
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
					gridpaging("end");
					batal();
                } else {

                }
            });
			return false;
	} //endif Hasil
}
</script>