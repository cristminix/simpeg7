<?php 		date_default_timezone_set('UTC'); ?>
 <div class="row" id="detailpegawai">
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
<!--
					<li><a href="#dropdown16" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('foto','dropdown16');return false;">
						<i class="fa fa-file-picture-o fa-fw"></i> Foto</a></li>
-->
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
					<i class="fa fa-list-alt fa-fw"></i> Data Kepegawaian <span class="caret"></span></a>
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

<li class="">
<a  onclick="batal();" data-toggle="tab" role="tab" href="#dropdown99">
<i class="fa fa-chevron-circle-left fa-fw"></i>
Kembali ke Daftar Pegawai
</a>
</li>

		</ul>
		<!-- Tab panes -->
		<div class="tab-content" style="padding:5px;">
		  <div class="tab-pane fade in active" id="dropdown0">


<?php $arGender = $this->dropdowns->gender();?>
<?php $arAgama = $this->dropdowns->agama();?>
<?php $arStatusPegawai= $this->dropdowns->status_pegawai();?>
<?php $arKelompokPegawai= $this->dropdowns->kelompok_pegawai();?>
<?php $arMarital = $this->dropdowns->status_perkawinan();?>
<br/>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-user fa-fw"></i> Data Utama
        <button type="button" class="btn btn-primary btn-xs pull-right" onclick="viewTabPegawai('utama','dropdown11');return false;"
        title="Edit Data Utama">
          <i class="fa fa-edit"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<dl class="dl-horizontal">
				  <dt>Nama Lengkap</dt>
				  <dd><?=(trim($data->gelar_nonakademis) != '-')?trim($data->gelar_nonakademis).' ':'';?><?=(trim($data->gelar_depan) != '-')?trim($data->gelar_depan).' ':'';?><?=trim($data->nama_pegawai);?><?=(trim($data->gelar_belakang) != '-')?', '.trim($data->gelar_belakang):'';?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Jenis Kelamin</dt>
				  <dd><?php echo $arGender[$data->gender];?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Gelar Non Akademis</dt>
				  <dd><?php echo @$data->gelar_nonakademis;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Gelar Depan</dt>
				  <dd><?php echo @$data->gelar_depan;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Gelar Belakang</dt>
				  <dd><?php echo @$data->gelar_belakang;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>NIP </dt>
				  <dd><?php echo @$data->nip_baru;?></dd>
				</dl>			
					
				<dl class="dl-horizontal">
				  <dt>Tempat Lahir</dt>
				  <dd><?php echo @$data->tempat_lahir;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Tanggal Lahir</dt>
				  <dd><?php echo @$data->tanggal_lahir;?></dd>
				</dl>			
				<dl class="dl-horizontal">
				  <dt>Agama</dt>
				  <dd><?php echo $arAgama[@$data->agama];?></dd>
				</dl>	
			<dl class="dl-horizontal">
				  <dt>Status Pegawai</dt>
				  <dd><?php echo @$data->status_pegawai;?></dd>
				</dl>		
<dl class="dl-horizontal">
				  <dt>Kelompok Pegawai</dt>
				  <dd><?php echo @$data->kelompok_pegawai;?></dd>
				</dl>					
				<dl class="dl-horizontal">
				  <dt>Status Perkawinan</dt>
				  <dd><?php echo @$data->status_perkawinan;?></dd>
				</dl>			
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-tasks fa-fw"></i> Jabatan
        <button type="button" class="btn btn-success btn-xs pull-right" onclick="viewTabPegawai('utama','dropdown24');return false;"
        title="Edit Data Jabatan">
          <i class="fa fa-edit"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">TMT Jabatan</label>
						<div class="col-sm-9">
						  <p class="form-control-static"><?php echo @$data->tmt_jabatan;?></p>
						</div>
						<!-- /.col-sm-9 -->
					</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-8 -->
	<div class="col-lg-4">
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-file-picture-o fa-fw"></i> Foto Pegawai
        <button type="button" class="btn btn-success btn-xs pull-right" onclick="return false;"
        title="Upload Foto Pegawai">
          <i class="fa fa-upload"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<img src="<?php echo @$fotoSrc;?>" alt="Foto Pegawai" class="img-responsive img-thumbnail" width="250">
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		
		<!-- /.panel -->
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-sort-amount-desc fa-fw"></i> Kepangkatan
        <button type="button" class="btn btn-success btn-xs pull-right" onclick="viewTabPegawai('utama','dropdown23');return false;"
        title="Edit Data Kepangkatan Pegawai">
          <i class="fa fa-edit"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-4 control-label">Pangkat</label>
						<div class="col-sm-8">
						  <p class="form-control-static"><?php echo @$data->nama_pangkat;?></p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-4 control-label">Golongan</label>
						<div class="col-sm-8">
						  <p class="form-control-static"><?php echo @$data->nama_golongan;?></p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-5 control-label">TMT Pangkat</label>
						<div class="col-sm-7">
						  <p class="form-control-static"><?php echo @$data->tmt_pangkat;?></p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-4 -->
</div>
<!-- /.row -->


		  
		  </div>
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

	</td>
</tr>

<script type="text/javascript">
function viewTabPegawai(section,targetArea){
	$("#"+targetArea).html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></p>');
/*
	var id_pegawai = false;
	id_pegawai = $("#dropdown0 #id_pegawai").val();
	if(!id_pegawai){
		alert('kesalahan.reload kembali');
		return false;
	}
*/
	$.ajax({
        url: '<?php echo site_url('appbkpp/profile');?>/'+section,
        data: {id_pegawai:9770,m:section,f:'view'},
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
</script>
<style>
.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>
