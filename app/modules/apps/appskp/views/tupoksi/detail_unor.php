<div>
		<div style="float:left; width:150px;">Unit organisasi</div>
		<div style="float:left; width:15px;">:</div>
		<div style="float:left; width:650px" class="ipt_text"><?=$hslquery[0]->nomenklatur_cari;?></div>
</div>
<div style="clear:both"></div>
<div>
		<div style="float:left; width:150px;">Jenis jabatan</div>
		<div style="float:left; width:15px;">:</div>
		<div style="float:left;">
			<select id="jenis_jabatan" onchange="gantijenis();" style="width:200px; padding-top:5px; padding-bottom:5px;"  class="ipt_text">
<?php
$jt['kode'][0]="js";
$jt['kode'][1]="jfu";
$jt['kode'][2]="jft";
$jt['kode'][3]="guru";
$jt['nama'][0]="Jabatan Struktural";
$jt['nama'][1]="Jabatan Fungsional Umum";
$jt['nama'][2]="Jabatan Fungsional Tertentu";
$jt['nama'][3]="Guru";
$jtt=array();$j=0;
foreach($jabatan AS $key=>$val){$jtt[$j]=$val->jab_type;$j++;}
for($i=0;$i<count($jt['kode']);$i++){
	$slt=($i==0)?"selected":"";
	if(in_array($jt['kode'][$i],$jtt) || $i==0){
?>
			<option value=<?=$jt['kode'][$i];?> <?=$slt;?>><?=$jt['nama'][$i];?></option>
<?php
	}
}
?>
			</select>
		</div>
</div>
<div style="clear:both"></div>
<div>
		<div style="float:left; width:150px;">Jabatan</div>
		<div style="float:left; width:15px;">:</div>
		<div style="float:left; width:650px" class="ipt_text" id="ini_jabatan"><?=$hslquery[0]->nomenklatur_jabatan;?></div>
</div>
<!--/////////////////////////////////////////////////-->
<div id='idd' style="display:none"><?=$idd;?></div>
<div id='idj' style="display:none">x</div>
<!--/////////////////////////////////////////////////-->

<script type="text/javascript">
function gantijenis(){
	$("[id^='row_']").hide();
	var jj = $("#jenis_jabatan").val();
//////////////////////////////
	var idu = $("#idd").html();
	if(jj=="js"){
		iniJabatan(idu);
		$("#idj").html("x");
	} else {
		non_eselon(jj,idu);
	}
//////////////////////////////
}

function non_eselon(jj,idu){
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appskp/tupoksi/get_jab_unor",
		data:{"id_unor":idu,"jenis":jj},
//		beforeSend:function(){	loadDialogBuka(); },
		success:function(data){

			var table="<select id=\"pil_jabatan\" onchange=\"gantijabatan();\" style=\"width:656px; padding-top:5px; padding-bottom:5px;\"  class=\"ipt_text\">";
			var i =0;
			$.each( data, function(index, item){
//				if(item.id_jabatan!=null){
				if(i==0){
					$("#idj").html(item.id_jabatan);
					table = table+ "<option value='"+item.id_jabatan+"' selected>"+item.nomenklatur_jabatan+"</option>"; 
				} else {
					table = table+ "<option value='"+item.id_jabatan+"'>"+item.nomenklatur_jabatan+"</option>"; 
				}
				i++;
//				}
			}); //endeach
			table = table+ "</select>"; 

			$("#ini_jabatan").replaceWith("<div style=\"float:left;\" id=\"ini_jabatan\">"+table+"</div>");
			gettupoksi();
//			loadDialogTutup();
		}, //tutup::success
	dataType:"json"});
}
function gantijabatan(){
	var ijabatan = $("#pil_jabatan").val();
	$("#idj").html(ijabatan);
	gettupoksi();
}
</script>
