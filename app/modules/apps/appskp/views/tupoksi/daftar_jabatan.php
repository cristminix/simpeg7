                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><?=$jform;?></h4>
                                        </div>
                                        <div class="modal-body">

  <div class="row">
	<div class="col-lg-12">
				<div class="table-responsive">
<table cellspacing=0 width=100% style="border-bottom: 1px dotted #3399CC;">
<thead id=gridhead2>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=30>Pilih</th>
<th class=gridhead>KODE<br /><b>NAMA UNIT ORGANISASI</b><br />KUNCI PENCARIAN</th>
<th class=gridhead width=400>ESELON<br /><b>JABATAN STRUKTURAL</b></th>
</tr>
</thead>
<tr height=20>
<td align=right colspan=8 class='gridcell left' id=pg2>&nbsp;</td>
</tr>
</table>
				</div>
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
<script type="text/javascript">
$(document).ready(function(){
	gridpaging(1,0,0);
});
////////////////////////////////////////////////////////////////////////////
function gridpaging(hal,level,id_parent){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/skpd/getskpdutama/",
				data:{"hal": hal, "batas": 10, "level":level, "id_parent":id_parent},
				beforeSend:function(){	
					if(level == 0){
						$("<tr id=spp class=gridrow><td colspan=6 align=center><b><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></p></b></td></tr>").insertAfter("#gridhead2");
					} else {
						$("<tr id=spp class=gridrow><td colspan=6 align=center><b><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></p></b></td></tr>").insertAfter($("#rw_"+id_parent+""));
					}
				},
				success:function(data){

if((data.hslquery.length)>0){   // start klo ada ada
			if(id_parent==0){var ni="";} else{var ni=$("#nomer_"+id_parent+"").html()+".";}
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=25 class='gridrow "+seling+"' id=rw_"+ item.idchild +">";
				table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.idchild+"'>"+ni+no+"</div></b></td>";
//tombol aksi-->
				table = table+ "<td class=gridcell valign=top style=\"padding-top:10px;\">";
					table = table+ "<button class=\"btn btn-primary dropdown-toggle btn-xs\" type=\"button\" onclick=\"iniJabatan('"+item.id_unor +"');\" data-dismiss=\"modal\" title='Klik untuk memilih jabatan'><span class=\"fa fa-check\"></span>";
				table = table+ "</td>";
//tombol aksi<--
////////////////tombol treegrid && variabel kunci-->
				table = table+ "<td class=gridcell style='padding-left: "+ item.spare +"px;'>";
				if(item.toggle == "tutup"){
					table = table+ "<div style=\"float:left; padding:1px 5px 0px 0px;\"><span class=\"fa tree fa-chevron-circle-right\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"no\"  id='"+item.idchild+"' onclick=\"gridpaging('"+hal+"','"+item.level+"','"+item.idchild+"');\"></span></div>";
				} else {
					table = table+ "<div style=\"float:left; padding:1px 5px 0px 0px;\"><span class=\"fa tree fa-file-o\" style=\"font-size:16px;\" data-expand=\"no\"  id='"+item.idchild+"'></span></div>";
				}
				table = table+ "<span style=\"display:table;\" id='nama_jenis_"+item.id_unor+"'>"+item.kode_unor+"<br /><b>"+item.nama_unor+ "</b><br />"+item.nomenklatur_cari+"</span>";
				table = table+ "</td>";
////////////////tombol treegrid && variabel kunci<--
				table = table+ "<td class=gridcell align=left><div id='kol_2_"+item.id_unor+"'>" +item.nama_ese+"<br /><b>"+item.nomenklatur_jabatan+"</b><br /><u>pada</u><br />"+item.nomenklatur_pada+"</div></td>";
				table = table+ "</tr>"; 
			no++;
			}); //endeach
}  //tutup:: if data>0	
					$("#spp").remove();
					if(level == 0){
						$("<tr id=isi2 class=gridrow><td colspan=6 align=center><b>TIDAK ADA DATA</b></td></tr>").insertAfter("#gridhead2");
						if(data.hslquery.length>0){$('#isi2').replaceWith(table); $('#pg2').html(data.pager);}
					} else {
						$(table).insertAfter($("#rw_"+id_parent+""));
						$("#"+id_parent).replaceWith("<span class=\"fa tree fa-chevron-circle-down\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"yes\"  id='"+id_parent+"'></span>");
					}
//					loadDialogTutup();
            }, //tutup::success
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.fa.tree',function(){
	var lvl = $(this).attr("data-expand");
	var idp = $(this).attr("id");
	if(lvl=='yes'){
		$("[id^='rw_"+idp+"_']").hide();
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-right\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"no\"  id='"+idp+"'></span>");
	} else {
		$("[id^='"+idp+"_']").each(function(key,val) {
			var ini = $(this).attr("id");
			var status_ini = $(this).attr("data-expand");
			$("#rw_"+ini+"").show();
			if(status_ini == "yes"){	$(this).removeClass("fa tree fa-chevron-circle-down").addClass("fa tree fa-chevron-circle-right").attr("data-expand","no");	}
		});
		$("[id^='"+idp+"_']").each(function(key,val) {	var ini = $(this).attr("id");	$("[id^='rw_"+ini+"_']").hide();	});
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-down\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"yes\"  id='"+idp+"'></span>");
	}
});
////////////////////////////////////////////////////////////////////////////
</script>