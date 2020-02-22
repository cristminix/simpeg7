  <div class="row">
	<div class="col-lg-12">
		 <h1 class="page-header">Data Pegawai  <small id="subtext-pegawai"></small></h1>
	</div>
	<!-- /.col-lg-12 -->
 </div>
 <!-- /.row -->
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
					<li><a href="#dropdown15" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('pendidikan','dropdown15');return false;">
						<i class="fa fa-graduation-cap fa-fw"></i> Pendidikan</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" id="myTabDrop2" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-list-alt fa-fw"></i> Data Kepegawaian <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a href="#dropdown21" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('cpns','dropdown21');return false;">
						<i class="fa fa-star-half-o fa-fw"></i> CPNS</a></li>
					<li><a href="#dropdown22" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('pns','dropdown22');return false;">
						<i class="fa fa-star fa-fw"></i> PNS</a></li>
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
			<li><a href="#dropdown3" role="tab" data-toggle="tab" 
        onclick="viewTabPegawai('skp','dropdown3');return false;"> 
				<i class="fa fa-trophy fa-fw"></i> SKP</a></li>
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
		  <div class="tab-pane fade" id="dropdown15">15</div>
		  <div class="tab-pane fade" id="dropdown21">21</div>
		  <div class="tab-pane fade" id="dropdown22">22</div>
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

		
		
  <div class="row"  id="daftarpegawai">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				[ <?=$this->session->userdata('nama_unor');?> ]
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>Nama,TTL, NIP baru</th>
								<th>Pangkat / Golongan</th>
								<th>Jabatan</th>
								<th>SKPD</th>
							</tr>
						</thead>
						<tbody>
						<?php echo @$dtbody;?>
					   </tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->
<script type="text/javascript">
function refreshDatatable(){
$.ajax({
        url: '<?php echo site_url('datapegawai/getdaftarpeg');?>',
        data: {},
        type: 'post',
        dataType: 'html',
        success: function(response) {
            $('#dataTables-example tbody').html(response);
			$('#dataTables-example').dataTable();
        },
        error: function(response) {
            alert('gagal reload daftar pegawai');
        }
    });

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
function viewDaftarPegawai(){
	$("#subtext-pegawai").html('');
	$("#detailpegawai").toggle();
	$("#daftarpegawai").toggle();
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
function viewDetailPegawai(id_pegawai){
  $("div.tab-content div.tab-pane").html('');
	$("#dropdown0").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></p>');
  loadDetailPegawai(id_pegawai);
  $('#myTab a:first').tab('show');
	$("#detailpegawai").toggle();
	$("#daftarpegawai").toggle();
}
jQuery(document).ready(function() { 
	$('#dataTables-example').dataTable();
	$('#myTab a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	}) 
});
</script>
<style>
.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>
