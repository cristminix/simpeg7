<div class="row">
<div class="col-xs-12 text-center" ><h3>DASHBOARD ABSENSI PEGAWAI</h3></div>
</div>
<div class="row">
	<?php foreach($panel as $row){ ?>
	<div class="col-sm-3 col-xs-12">
		<div id="tile0" class="tile tile1">
			<div class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
				<div class="item active">
				<a class="uk-panel custom-box" data-mod="<?php echo $row['mod'];?>" init="<?php echo $row["init"];?>"  href="http://localhost/project/dashboard/admin/module/widget/absensi/dashboard">
					<div class="tile-stats tile-aqua" style="background:rgb(12, 93, 197)">
						<div class="icon"><i class="fa fa-user"></i></div>
						<h3 class="tilecaption"><?php echo $row["title"];?></h3><hr>
						<h2 class="tilecaption"><?php echo $row["content"];?></h2>
					</div>
				</a>
				</div>
				</div>
			</div>
		</div>
	</div>
	<?php  } ?>
</div>

<div class="row">
	<div class="col-xs-12" id="grid-attendance">
	</div>
</div>

<script>
var base_url = "<?php echo base_url();?>";

$(document).ready(function(){
	var active = $(".custom-box[init='1']").attr("data-mod");
	loadViewGrid(active);
});

$(".custom-box").click(function(){
	var active = $(this).attr("data-mod");
	loadViewGrid(active);
	return false;
});

function loadViewGrid(mod=false){
	$.ajax({
		type:"POST",
		url:base_url+mod,
		data:{ref:mod},
		beforeSend:function(){	
			$('#grid-attendance').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></h3>');
		},
		success:function(data){
			$('#grid-attendance').html(data);
			gridpaging(1);
		}
	});
}

function gridpaging(hal){
	var ref = $("#mainTable").attr("data-ref");
	var limit = $("#item_length").val(),
		page  = hal,
		key   = $("#a_caripaging").val(),
		str   = $("#iptTanggal").val(),
		end   = $("#iptTanggal2").val();
	$.ajax({
		type:"POST",
		url:base_url+ref+'/true',
		data:{ref:ref,page:page,limit:limit,key:key,str:str,end:end},
		beforeSend:function(){	
			$('#grid-data').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></h3>');
		},
		dataType:"json",
		success:function(data){
			//$('#grid-data').html(data);
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					table = table+ "<tr id='row_"+(index+1)+"'>";
					for(i=0;i<$('th').length;i++){
						var dataIndex = $('th').eq(i).attr("id");
						if(data.hslquery[index][dataIndex]){
							table = table+ "<td style='padding:3px;' "+(dataIndex == "no" || dataIndex=="aksi"? 'align="center"':'')+">"+data.hslquery[index][dataIndex]+"</td>";
						}
					}
					table = table+ "</tr>";
					no++;
				});
					$('#grid-data').html(table);
					$('#paging').html(data.pager);
					
					var ini="";
						for(i=0;i<data.seg_print;i++){
							var jj = (i*data.bat_print)+1;
							var kk = (i+1)*data.bat_print;
							ini = ini + '<div onclick="cetak('+(i+1)+');"  class="btn btn-success btn-xs" style="margin-right:10px;margin-top:5px;">Hal. '+(i+1)+' (item no.'+jj+' - '+kk+')</div><br/>';
						}
					$('#paging_print').html(ini);
			}else{
				$('#grid-data').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");
				$('#paging_print').html("");
			}
		}
	});
}


function cetak_excel(){
	var ini = $('#paging_print').html();
	ini = ini + '<div onclick="batal(1,2);" class="btn btn-primary" style="margin-top:25px;"><i class="fa fa-fast-backward fa-fw"></i> Kembali</div>';
			$('#main-wrapper').hide();
			$('#form-wrapper').html(ini).show();
}

function cetak(hal){
	var __data = new Object();
		ref = $("#mainTable").attr("data-ref");
		__data.limit = $("#item_length").val();
		__data.page  = hal;
		__data.key   = $("#a_caripaging").val();
		__data.str   = $("#iptTanggal").val();
		__data.end   = $("#iptTanggal2").val();
		__data.cols = $('#cols').val(); 

	 __data.hal 	= hal;
	 __data.export  = true;
	$.ajax({
		type:"POST",
		url:"<?=base_url();?>"+ref+'/true',
		data:__data,
		dataType:"json",
		beforeSend:function(){	
			$('#form-wrapper').append('<p class="text-center" id="loadingBar"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
		},
		success:function(output){
			$("#loadingBar").remove();
			//document.location.href =output.url;
			window.open(output.url,'_blank' );
		}
	});
	//window.open("<?=site_url();?>appbkpp/cetak/index/"+hal,"_blank");
}

function batal(aksi,idd){
	$('#main-wrapper').show();
	var gohal=$("#inputpaging").val();
	gridpaging(1);
	$('#form-wrapper').hide();
}

</script>