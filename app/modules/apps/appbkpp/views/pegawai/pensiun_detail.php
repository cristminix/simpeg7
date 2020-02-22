<div id="pensiun_detail" v-if="detail != null && state.detail_shown">
	<div class="row" id="detailpegawai" >
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
				<ul id="ulmyTabDrop1" class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a id="aMyTabDrop1utama" href="#dropdown11" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('utama',detail.id_pegawai)">
						<i class="fa fa-briefcase fa-fw"></i> Data Utama</a></li>
					<li><a id="aMyTabDrop1foto" href="#dropdown16" tabindex="-1" role="tab" data-toggle="tab">
						<i class="fa fa-file-picture-o fa-fw"></i> Foto</a></li>
					<li><a href="#dropdown12" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('alamat',detail.id_pegawai)">
						<i class="fa fa-home fa-fw"></i> Alamat</a></li>
					<li><a href="#dropdown13" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('pernikahan',detail.id_pegawai)">
						<i class="fa fa-institution fa-fw"></i> Pernikahan</a></li>
					<li><a href="#dropdown14" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('anak',detail.id_pegawai)">
						<i class="fa fa-child fa-fw"></i> Anak</a></li>

					<li><a href="#dropdown151" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('orangtua',detail.id_pegawai)">
						<i class="fa fa-user fa-fw"></i> Orang Tua</a></li>

					<li><a href="#dropdown15" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('pendidikan',detail.id_pegawai)">
						<i class="fa fa-graduation-cap fa-fw"></i> Pendidikan</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" id="myTabDrop2" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-list-alt fa-fw"></i> Data Kepegawaian<span class="caret"></span></a>
				<ul id="ulmyTabDrop2" class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a href="#dropdown21" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('kontrak',detail.id_pegawai)"> 
						<i class="fa fa-star-half-o fa-fw"></i> KONTRAK</a></li>
					<li><a href="#dropdown22" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('capeg',detail.id_pegawai)">
						<i class="fa fa-star fa-fw"></i> CAPEG</a></li>
					<li><a href="#dropdown222" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('tetap',detail.id_pegawai)">
						<i class="fa fa-star fa-fw"></i> TETAP</a></li>
					<li><a id="aMyTabDrop2pangkat" href="#dropdown23" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('kepangkatan',detail.id_pegawai)">
						<i class="fa fa-signal fa-fw"></i> Kepangkatan</a></li>
					<li><a id="aMyTabDrop2jabatan" href="#dropdown24" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('jabatan',detail.id_pegawai)">
						<i class="fa fa-tasks fa-fw"></i> Jabatan</a></li>
					<li><a href="#dropdown25" tabindex="-1" role="tab" data-toggle="tab" @click="getTabRo('kediklatan',detail.id_pegawai)">
						<i class="fa fa-graduation-cap fa-fw"></i> Kediklatan</a></li>
				</ul>
			</li><li><a href="javascript:void();" role="tab" data-toggle="tab" @click="backToGrid()">
				<i class="fa fa-chevron-circle-left fa-fw"></i> Kembali</a></li>
			
		</ul>
		<!-- Tab panes -->
		<div class="tab-content" style="padding:5px;">
		  <div class="tab-pane fade in active" id="dropdown0"><input id="id_pegawai" type="hidden" value="198" name="id_pegawai">
<br>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-user fa-fw"></i> Data Utama
        <button type="button" class="btn btn-primary btn-xs pull-right" onclick="$('a#aMyTabDrop1utama').click();" tabindex="-1" role="tab" data-toggle="tab" title="Lihat Data Utama">
          <i class="fa fa-eye"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<dl class="dl-horizontal">
				  <dt>Nama Lengkap</dt>
				  <dd>{{detail.nama_pegawai}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Jenis Kelamin</dt>
				  <dd>{{getVarRekapPeg('gender',detail)=='p'?'Perempuan':'Laki-Laki'}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Gelar Non Akademis</dt>
				  <dd>{{getVarRekapPeg('gelar_nonakademis',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Gelar Depan</dt>
				  <dd>{{getVarRekapPeg('gelar_depan',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Gelar Belakang</dt>
				  <dd>{{getVarRekapPeg('gelar_belakang',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>NIP</dt>
				  <dd>{{detail.nip_baru}}</dd>
				</dl>

				<dl class="dl-horizontal">
				  <dt>Tempat Lahir</dt>
				  <dd>{{getVarRekapPeg('tempat_lahir',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Tanggal Lahir</dt>
				  <dd>{{getVarRekapPeg('tanggal_lahir',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Agama</dt>
				  <dd>{{getVarRekapPeg('agama',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Status Pegawai</dt>
				  <dd>{{getVarRekapPeg('status_pegawai',detail)}}</dd>
				</dl>
			<dl class="dl-horizontal">
				  <dt>Kelompok Pegawai</dt>
				  <dd>{{getVarRekapPeg('kelompok_pegawai',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Status Perkawinan</dt>
				  <dd>{{getVarRekapPeg('status_perkawinan',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Golongan Darah</dt>
				  <dd>{{getVarRekapPeg('gol_darah',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Nomor HP</dt>
				  <dd>{{getVarRekapPeg('nomor_hp',detail)}}</dd>
				</dl>
				<dl class="dl-horizontal">
				  <dt>Nomor Telp. Rumah</dt>
				  <dd>{{getVarRekapPeg('nomor_tlp_rumah',detail)}}</dd>
				</dl>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-tasks fa-fw"></i> Jabatan
        <button type="button" class="btn btn-success btn-xs pull-right" onclick="$('a#aMyTabDrop2jabatan').click();" title="Riwayat Jabatan">
          <i class="fa fa-tasks"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">TMT Jabatan</label>
						<div class="col-sm-9">
						  <p class="form-control-static">{{getVarRekapPeg('tmt_jabatan',detail)}}</p>
						</div>
						<!-- /.col-sm-9 -->
					</div>
					<!-- /.form-group -->
				</form>
				<!-- /.form-horizontal -->
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
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<img v-bind:src="photoUrl(detail.foto,350,400)" alt="Foto Pegawai" class="img-responsive img-thumbnail">
				 
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->

		<!-- /.panel -->

		<!-- /.panel -->
		<div class="panel panel-green">
			<div class="panel-heading">
				<i class="fa fa-sort-amount-desc fa-fw"></i> Kepangkatan
          <i class="fa fa-signal fa-fw"></i>
        </button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-4 control-label">Pangkat</label>
						<div class="col-sm-8">
						  <p class="form-control-static">{{getVarRekapPeg('nama_pangkat',detail)}}</p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-4 control-label">Golongan</label>
						<div class="col-sm-8">
						  <p class="form-control-static">{{getVarRekapPeg('nama_golongan',detail)}}</p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-5 control-label">TMT Pangkat</label>
						<div class="col-sm-7">
						  <p class="form-control-static">{{getVarRekapPeg('tmt_pangkat',detail)}}</p>
						</div>
						<!-- /.col-sm-8 -->
					</div>
					<!-- /.form-group -->
				</form>
				<!-- /.form-horizontal -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-4 -->
</div>
<!-- /.row -->
 
</div>

			<div class="tab-pane fade" id="dropdown11" m="utama">
				
			</div>

		  <div class="tab-pane fade" id="dropdown12" m="alamat">
				
		  </div>
		  <div class="tab-pane fade" id="dropdown16">
		  	<img v-bind:src="photoUrl(detail.foto,800,600)" alt="Foto Pegawai" class="img-responsive img-thumbnail">
		  </div>
		  <div class="tab-pane fade" id="dropdown13" m="pernikahan"></div>
		  <div class="tab-pane fade" id="dropdown14" m="anak"></div>
		  <div class="tab-pane fade" id="dropdown151" m="orangtua"></div>
		  <div class="tab-pane fade" id="dropdown15" m="pendidikan"></div>
		  <div class="tab-pane fade" id="dropdown21" m="kontrak"></div>
		  <div class="tab-pane fade" id="dropdown22" m="capeg"></div>
		  <div class="tab-pane fade" id="dropdown222" m="tetap"></div>
		  <div class="tab-pane fade" id="dropdown23" m="kepangkatan"></div>
		  <div class="tab-pane fade" id="dropdown24" m="jabatan"></div>
		  <div class="tab-pane fade" id="dropdown25" m="kediklatan"></div>
		  <div class="tab-pane fade" id="dropdown3"></div>
		</div>
	</div>
	<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
</div>
