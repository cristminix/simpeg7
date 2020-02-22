<script type="text/javascript" src="<?=site_url('assets/js/vue.min.js')?>"></script>
<script type="text/javascript" src="<?=site_url('assets/js/axios.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=site_url('assets/css/snackbar.css')?>">
<script type="text/javascript">
	function snackbar(text,tm) {
	  tm = tm || 3000;
	  // Get the snackbar DIV
	  var x = document.getElementById("snackbar");
	  x.innerHTML=text;
	  // Add the "show" class to DIV
	  x.className = "show";

	  // After 3 seconds, remove the show class from DIV
	  setTimeout(function(){ x.className = x.className.replace("show", ""); }, tm);
	}
</script>
<div id="snackbar"></div>
<div class="row grid">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$title;?></h3>
		 
		 <?php if(isset($periode) && $periode!=""){ ?>
				<form class="form-inline">
				<span>Periode :</span>
				  <div class="form-group">
					<label class="sr-only" for="month">Bulan</label>
					<select class="form-control" id="month" name="month" onChange="changeTitle(1)">
					  <?php foreach($this->month as $key=>$val){
						  echo '<option value="'.$key.'" '.(date("n", mktime(0, 0, 0, date("n")+$param, 10))==$key?'selected':'').'>'.strtoupper($val).'</option>';
					  }?>
					</select>
				  </div>
				  <div class="form-group">
					<label class="sr-only" for="year">Tahun</label>
					<select class="form-control" id="year" name="year" onChange="changeTitle(1)">
					  <?php 
					  $year = range(date("Y")-2,date("Y")+2);
					  foreach($year as $keys=>$vals){
						  echo '<option value="'.$vals.'" '.(date("Y", mktime(0, 0, 0, date("n")+$param, 10))==$vals?'selected':'').'>'.strtoupper($vals).'</option>';
					  }?>
					</select>
				  </div>
				</form>
		<?php } ?>
		<hr>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row form" id="myform"></div>
<div id="content-wrapper" style="padding-bottom:30px;">


<div class="row">
		<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-arrows fa-fw"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuT">
											<li><a href="#" onClick="cetak_excel();return false;"><i class="fa fa-print fa-fw"></i> Cetak Daftar</a></li>
											<?php if(isset($act)){ ?>
											<li><?php echo $act;?></li>
											<?php } ?>
										</ul>
										Daftar <?=$title;?>
									</div>
								</div>
								<div class="col-lg-6">
								
								<?php if(isset($search) && $search!=""){ ?>
									<div class="btn-group pull-right" style="padding-left:5px;">
										<button class="btn btn-primary btn-xs" type="button" id="bt_opsi" onclick="buka_div_opsi();"><i class="fa fa-caret-down fa-fw"></i></button>
									</div>
								<?php } ?>
								
								
								</div>
						</div>
					<?php echo $search;?>
		</div>
<div class="panel-body" style="padding-left:5px;padding-right:5px;">

<div class="row">
<div class="col-lg-6" style="margin-bottom:5px;">
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
<option value="10" <?=($batas==10)?"selected":"";?>>10</option>
<option value="25" <?=($batas==25)?"selected":"";?>>25</option>
<option value="50" <?=($batas==50)?"selected":"";?>>50</option>
<option value="100" <?=($batas==100)?"selected":"";?>>100</option>
</select>



</div>
<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="margin-bottom:5px;">
                            <div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
                                <input id="a_caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="<?=$cari;?>">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
<div style="float:right; margin:7px 0px 0px 0px;">Cari:</div>
</div>
<div class="col-lg-12" id="form_anak"></div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<form id="form_sub" method="post" enctype="multipart/form-data" onSubmit="return false;">

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<?php 
echo '<th id="no" align="center">No</th><th id="aksi" align="center">Aksi</th>';
$colsEx=[];
foreach($columns as $cols){
	if($cols["display"]!=false){
		if(isset($cols["name"]) && $cols["title"]){
			echo '<th id="'.$cols["name"].'">'.$cols["title"].'</th>';
			$colsEx[]=$cols["name"].":".$cols["title"];
		}
	}
}	
?>
</tr>
</thead>
<tbody id=list>
</tbody>
</table>
</form>

<input type="hidden" name="cols" id="cols" value="<?php echo implode(",",$colsEx); ?>"></input>
</div>
			<!-- table-responsive --->
	<div id=paging></div>

	<div id="paging_print" style="display:none;"></div>


	</div>
</div>
		</div>
		<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.content -->
<div id="form-wrapper" style="padding-bottom:30px; display:none;"></div>

 <div class="row" id="detailpegawai" style="display:none;">
	<div class="col-lg-12">
     <div class="panel panel-default">
     <div class="panel-body" style="padding:0px;">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist" id="myTab">
			<li class="active"><a href="#dropdown0" role="tab" data-toggle="tab">
				<i class="fa fa-user fa-fw"></i> Profil</a></li>
			<li class="dropdown">
				<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-book fa-fw"></i> Biodata <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a href="#dropdown11" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('utama','dropdown11');return false;">
						<i class="fa fa-briefcase fa-fw"></i> Data Utama</a></li>
					<li><a href="#dropdown16" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('foto','dropdown16');return false;">
						<i class="fa fa-file-picture-o fa-fw"></i> Foto</a></li>
					<li><a href="#dropdown12" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('alamat','dropdown12');return false;">
						<i class="fa fa-home fa-fw"></i> Alamat</a></li>
					<li><a href="#dropdown13" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('pernikahan','dropdown13');return false;">
						<i class="fa fa-institution fa-fw"></i> Pernikahan</a></li>
					<li><a href="#dropdown14" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('anak','dropdown14');return false;">
						<i class="fa fa-child fa-fw"></i> Anak</a></li>
						
					<li><a href="#dropdown151" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('orangtua','dropdown151');return false;">
						<i class="fa fa-user fa-fw"></i> Orang Tua</a></li>
					
					<li><a href="#dropdown15" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('pendidikan','dropdown15');return false;">
						<i class="fa fa-graduation-cap fa-fw"></i> Pendidikan</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" id="myTabDrop2" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-list-alt fa-fw"></i> Data Kepegawaian<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a href="#dropdown21" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('kontrak','dropdown21');return false;">
						<i class="fa fa-star-half-o fa-fw"></i> KONTRAK</a></li>
					<li><a href="#dropdown22" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('capeg','dropdown22');return false;">
						<i class="fa fa-star fa-fw"></i> CAPEG</a></li>
					<li><a href="#dropdown222" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('tetap','dropdown222');return false;">
						<i class="fa fa-star fa-fw"></i> TETAP</a></li>
					<li><a href="#dropdown23" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('kepangkatan','dropdown23');return false;">
						<i class="fa fa-signal fa-fw"></i> Kepangkatan</a></li>
					<li><a href="#dropdown24" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('jabatan','dropdown24');return false;">
						<i class="fa fa-tasks fa-fw"></i> Jabatan</a></li>
					<li><a href="#dropdown25" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('kediklatan','dropdown25');return false;">
						<i class="fa fa-graduation-cap fa-fw"></i> Kediklatan</a></li>
				</ul>
			<li><a href="#dropdown99" role="tab" data-toggle="tab" onclick="viewDaftarPegawai();return false;">
				<i class="fa fa-chevron-circle-left fa-fw"></i> Kembali ke Daftar Pegawai</a></li>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content" style="padding:5px;">
		  <div class="tab-pane fade in active" id="dropdown0">...</div>
		  <div class="tab-pane fade" id="dropdown11">Data Utama</div>
		  <div class="tab-pane fade" id="dropdown12">12</div>
		  <div class="tab-pane fade" id="dropdown16">16</div>
		  <div class="tab-pane fade" id="dropdown13">13</div>
		  <div class="tab-pane fade" id="dropdown14">14</div>
		  <div class="tab-pane fade" id="dropdown151">151</div>
		  <div class="tab-pane fade" id="dropdown15">15</div>
		  <div class="tab-pane fade" id="dropdown21">21</div>
		  <div class="tab-pane fade" id="dropdown22">22</div>
		  <div class="tab-pane fade" id="dropdown222">222</div>
		  <div class="tab-pane fade" id="dropdown23">23</div>
		  <div class="tab-pane fade" id="dropdown24">24</div>
		  <div class="tab-pane fade" id="dropdown25">25</div>
		  <div class="tab-pane fade" id="dropdown3">3</div>
		</div>
	</div>
	<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->


<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
		<div id="modalWrapper"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

function viewDetailPegawai(id_pegawai){
  $("div.tab-content div.tab-pane").html('');
	$("#dropdown0").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></p>');
  loadDetailPegawai(id_pegawai);
  $('#myTab a:first').tab('show');
	$("#detailpegawai").toggle();
	$("#content-wrapper").toggle();
}
function loadDetailPegawai(id_pegawai){
	$.ajax({
        url: '<?php echo site_url('datapegawai/getprofile');?>',
        data: {id_pegawai:id_pegawai},
        type: 'post',
        dataType: 'html',
        success: function(response) {
          $("#dropdown0").html(response);
        },
        error: function(response) {
           alert('Gagal koneksi ke server'); 
        }
    });
}

function getForm(id,name_id){
	var cari = $('#a_caripaging').val();
	var batas = $('#item_length').val();
	var hal=$("#inputpaging").val();
	var name_id = (name_id?name_id:"idd");
	//console.log(name_id);
	$.ajax({
		type:"POST",
		url:"<?=$action;?>",
		data:{"hal": hal, "batas": batas,"cari":cari,[name_id]:id},
		beforeSend:function(){	
			$('#content-wrapper').hide();
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>').show();
		},
		success:function(data){
			$('#form-wrapper').html(data);
		}, // end success
	dataType:"html"}); // end ajax
}

function setSub(aksi,idd,no){
		//$('.btn.batal').click();
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/formsub_"+aksi,
		data:{"sub":aksi,"idd": idd,"nomor":no },
		beforeSend:function(){
			$('#row_'+no).addClass('success');
			$('<tr id="row_tt" class="success"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td></tr>').insertAfter('#row_'+no);
		},
        success:function(data){
			$('#form_sub').attr('action','<?=site_url("appbkpp/pegawai/formsub_");?>'+aksi+'_aksi');
			$('#row_tt').replaceWith(data);
		},
        dataType:"html"});
}

function viewTabPegawai(section,targetArea){
	$("#"+targetArea).html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></p>');
	var id_pegawai = false;
	id_pegawai = $("#dropdown0 #id_pegawai").val();
	if(!id_pegawai){
		alert('kesalahan.reload kembali');
		return false;
	}
	$.ajax({
        url: '<?php echo site_url('datapegawai/gettab');?>',
        data: {id_pegawai:id_pegawai,m:section,f:'view'},
        type: 'post',
        dataType: 'html',
        success: function(response) {
			$("#"+targetArea).html(response);
        },
        error: function(response) {
           alert('Gagal koneksi ke server'); 
        }
    });
}
function viewDaftarPegawai(){
//	$("#subtext-pegawai").html('');
	var gohal=$("#inputpaging").val();
	var page = (!gohal?1:gohal);
	gridpaging(page);
	$("#detailpegawai").toggle();
	$("#content-wrapper").toggle();
}

function loadForm(id_pegawai,ID,m,f,targetID){
	$('#'+targetID).html('');
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('datapegawai/getform');?>",
		cache: false,
		data: { id_pegawai: id_pegawai ,ID: ID, m: m, f: f}
		}).done(function( html ) {
			$('#'+targetID).html(html);
	});
}
function cancelForm(targetID){
	$('#'+targetID).html('');
}
function submitForm(id_pegawai,ID,m,f,targetID){
	$('#'+targetID).html('');
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('datapegawai/getform');?>",
		cache: false,
		data: { id_pegawai: id_pegawai ,ID: ID, m: m, f: f}
		}).done(function( html ) {
			$('#'+targetID).html(html);
	});
}


$(document).ready(function(){
	var gohal=$("#inputpaging").val();
	var page = (!gohal?1:gohal);
	gridpaging(page);
	
});

function changeTitleData(){
	var str = "";
    $( ".srch option:selected" ).each(function() {
		if($( this ).text()!='Semua...'){
			str +=$(this).parent().parent().find('label').text() +$( this ).text() + ", ";
		}
    });
	$('.detail').text(str);
	gridpaging(1);
}

function changeTitle(){
	$(".periodName").text("Bulan "+$("#month option:selected").text()+" "+$("#year").val());
	gridpaging(1);
}

function gridpaging(hal,output=false){
 var __data = new Object();
	 __data.cari = $('#a_caripaging').val();
	 __data.batas = $('#item_length').val();
	 __data.kode = $('#a_kode_unor').val();
	 __data.pns = $('#a_pns').val();
	 __data.pkt = $('#a_pangkat').val();
	 __data.jbt = $('#a_jabatan').val();
	 __data.ese = $('#a_ese').val();
	 __data.tugas = $('#a_tugas').val();
	 __data.gender = $('#a_gender').val();
	 __data.agama = $('#a_agama').val();
	 __data.status = $('#a_status').val();
	 __data.jenjang = $('#a_jenjang').val(); 
	 __data.kategori = $('#kategori').val(); 
	 
 if ( $('#month').length > 0 ){
	__data.month = $('#month').val();
 }
 if ( $('#year').length > 0 ){
	__data.year = $('#year').val();
 }
 __data.hal = hal;
	$.ajax({
		type:"POST",
		url:"<?=site_url().$url;?>",
		data:__data,
		beforeSend:function(){	
			$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
			$('#paging').html('');
		},
		success:function(data){
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
				}); //endeach
					$('#list').html(table);
					$('#paging').html(data.pager);
var ini="";
for(i=0;i<data.seg_print;i++){
	var jj = (i*data.bat_print)+1;
	var kk = (i+1)*data.bat_print;
	ini = ini + '<div onclick="cetak('+(i+1)+');"  class="btn btn-success btn-xs" style="margin-right:10px;margin-top:5px;">Hal. '+(i+1)+' (item no.'+jj+' - '+kk+')</div><br/>';
}
					$('#paging_print').html(ini);

			} else {
				$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");
			} // end if
		}, // end success
	dataType:"json"}); // end ajax
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
function setForm(aksi,idd){
var cari = $('#a_caripaging').val();
var batas = $('#item_length').val();
var hal=$("#inputpaging").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/form"+aksi,
		data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd},
		beforeSend:function(){	
			$('#content-wrapper').hide();
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>').show();
		},
		success:function(data){
			$('#form-wrapper').html(data);
		}, // end success
	dataType:"html"}); // end ajax
}
function batal(aksi,idd){
	$('#content-wrapper').show();
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
	$('#form-wrapper').hide();
}

function buka_div_opsi(){
	$('#bt_opsi').html('<i class="fa fa-caret-up fa-fw"></i>').attr('onclick','tutup_div_opsi();');
	$('#div_opsi').show();
}

function tutup_div_opsi(){
	$('#bt_opsi').html('<i class="fa fa-caret-down fa-fw"></i>').attr('onclick','buka_div_opsi();');
	$('#div_opsi').hide();
}
function cetak_excel(){
	var ini = $('#paging_print').html();
	ini = ini + '<div onclick="batal(1,2);" class="btn btn-primary" style="margin-top:25px;"><i class="fa fa-fast-backward fa-fw"></i> Kembali</div>';
			$('#content-wrapper').hide();
			$('#form-wrapper').html(ini).show();
}
function cetak(hal){
	var __data = new Object();
	 __data.cari = $('#a_caripaging').val();
	 __data.batas = $('#item_length').val();
	 __data.kode = $('#a_kode_unor').val();
	 __data.pns = $('#a_pns').val();
	 __data.pkt = $('#a_pangkat').val();
	 __data.jbt = $('#a_jabatan').val();
	 __data.ese = $('#a_ese').val();
	 __data.tugas = $('#a_tugas').val();
	 __data.gender = $('#a_gender').val();
	 __data.agama = $('#a_agama').val();
	 __data.status = $('#a_status').val();
	 __data.jenjang = $('#a_jenjang').val(); 
	 __data.kategori = $('#kategori').val(); 
	 __data.cols = $('#cols').val(); 
	 
	 if ( $('#month').length > 0 ){
		__data.month = $('#month').val();
	 }
	 if ( $('#year').length > 0 ){
		__data.year = $('#year').val();
	 }
	 __data.hal 	= hal;
	 __data.export  = true;
	$.ajax({
		type:"POST",
		url:"<?=site_url().$url;?>",
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

function hapusData(id){
	$.ajax({
		type: "POST",
		cache: false,
		data: { id_cut:id,delData:true}
		}).done(function( html ) {
			gopaging();
	});
}

function modalLink(uri){
	$('#myModal').modal();
	$.ajax({
	  url: uri,
	  beforeSend: function( xhr ) {
		$(".modal-title").text("Loading...");
		$( "#modalWrapper" ).html('<p class="text-center" id="loadingBar"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
	  },
	  dataType:"JSON"
	}).done(function( data ) {
			$(".modal-title").text(data.title);
			$("#modalWrapper").html(data.content);
	 });
}

 $(document).on('click', '.btn.batal', function () {
        $("[id='row_tt']").each(function (key, val) {
            $(this).remove();
        });
        $("[id^='row_']").removeClass().show();
        $('#simpan').html('');
    });

</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}

.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>
