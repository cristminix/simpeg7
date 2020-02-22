<script type="text/javascript">
	const app = {
		data : <?=json_encode($app_data)?>,
		vm   : {},
		site_url : (path)=>{return `<?=site_url()?>${path}`},
		link : {
			pegawai_aktif : '<?=site_url('admin/module/appbkpp/pegawai/aktif')?>'
		}
	};
</script>
 
<div id="app">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">{{sub_title}}</h3>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div id="content-wrapper">
		<div id="pensiun_grid" v-show="state.grid_shown">
			<div class="row top-nav">
				<div class="col-lg-12">
					<div class="btn-group pull-right">
						<a class="btn btn-primary btn-xs" href="javascript:;" v-on:click="goBack()"><i class="fa fa-fast-backward fa-fw"></i> Kembali</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-6">
									<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuX" data-toggle="dropdown"><span class="fa fa-trophy fa-fw"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuX">
									<li><a href="javascript:;" @click="formAdd();return false;"><i class="fa fa-plus fa-fw"></i> Tambah Data</a></li>
								</ul>
										{{sub_title}}
									</div>
									
									
								</div>
								<div class="col-lg-6 c-opsi">
									<div class="btn-group pull-right">
										<button class="btn btn-primary btn-xs" type="button"  v-on:click="toggleFilter();"><i v-bind:class="{'fa fa-fw':1,'fa-caret-down':!config.filter_open,'fa-caret-up':config.filter_open}"></i></button>
									</div>
								</div>
							</div>
							<div class="row filter-cnt" v-show="config.filter_open">
								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Unit kerja:</label>
												<select v-model="filter.kode_unor" class="form-control" v-on:change="onFilterChanged()">
													<option value="">Semua...</option>
													<option v-for="unor in filter_data.unor" v-bind:value="unor.kode_unor">{{unor.nama_unor}}</option>
												</select>
												<!--./form-group-->
											</div>
											
											<!--./panel-body-->
										</div>
										<!--./panel panel-default-->
									</div>
									<!--./col-->
								</div>
								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Jenis Pensiun:</label>
												<select v-model="filter.jenis_pensiun" class="form-control" v-on:change="onFilterChanged()">
													<option value="">Semua...</option>
													<option v-for="(nama,id) in filter_data.jenis_pensiun" v-bind:value="id">{{nama}}</option>
													
												</select>
											</div>
											
										</div>
									</div>
									<!--./col-->
								</div>
								<!-- ./row -->
							</div>
							<!-- ./panel-heading -->
						</div>
						<!--  -->
						<div class="panel-body grid-data">
							<div class="row">
								<div class="col-lg-6 per-page">
									<div class="select-per-page-cnt">
										<select class="form-control input-sm select-per-page" v-model="pagination.per_page" v-on:change="onPaginationChanged()">
											<option v-for="per_page in pagination_per_pages" v-bind:value="per_page">{{per_page}}</option>
										</select>
									</div>
									<div class="per-page-text">item per halaman</div>
									<!-- /.col-lg-6 -->
								</div>
								<div class="col-lg-6 search-cnt">
									<div class="input-group search-grp">
										<input v-model="filter.search_query" v-on:change="onGridSearch()" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="<?=$cari;?>">
										<span class="input-group-btn">
											<button class="btn btn-default" type="button" v-on:click="onGridSearch()">
											<i class="fa fa-search"></i>
											</button>
										</span>
									</div>
									<div class="search-caption">Cari:</div>
								</div>
							</div>
							<!--  -->
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th class="t-no t-mid-ctr">No.</th>
											<th class="t-act pad0 t-mid-ctr">AKSI</th>
											<th class="t-foto pad0 t-mid-ctr">FOTO</th>
											<th class="t-det t-mid-ctr">NAMA PEGAWAI ( GENDER )<br />NIP / PANGKAT TERAKHIR</th>
											<th class="t-jbt t-mid-ctr">JABATAN TERAKHIR</th>
											<th class="t-ktr t-mid-ctr">KETERANGAN</th>
										</tr>
									</thead>
									<tbody id="list">
										<tr v-for="(item,index) in grid_data">
											<td class="t-no">{{getRowNumber(index)}}.</td>
											<td> 
												<div class="dropdown">
													<button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown">
													<i class="fa fa-caret-down fa-fw"></i>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li role="presentation" class="cpo">
															<a role="menuitem" tabindex="-1" @click="formEdit(item)">
															<i class="fa fa-edit fa-fw"></i> Edit Data</a>
														</li>
														<li role="presentation" class="cpo">
															<a role="menuitem" tabindex="-1" @click="formDelete(item)">
															<i class="fa fa-trash fa-fw"></i> Hapus Data</a>
														</li>
														<li role="presentation" class="cpo">
															<a role="menuitem" tabindex="-1" @click="viewDetailPegawai(item)">
															<i class="fa fa-binoculars fa-fw"></i> Lihat Detail</a>
														</li>
													</ul>
												</div>
											</td>
											<td><a href="javascript:;"><img v-bind:src="photoUrl(item.foto)" class="ft-thumb img-responsive" /></a></td>
											<td><b>{{item.nama_pegawai}}</b>({{getVarRekapPeg('gender',item)}})
												<br/>{{getVarRekapPeg('nip_baru',item)}}
												<br/>{{getVarRekapPeg('nama_pangkat',item)}}
												/ {{getVarRekapPeg('nama_golongan',item)}}
												
											</td>
											<td>
												<br/>{{getVarRekapPeg('nomenklatur_jabatan',item)}}
												<u>pada</u><br/>{{getVarRekapPeg('nomenklatur_pada',item)}}
											</td>
											<td>
												<table class="tb-info-pensiun">
													<tbody>
														<tr>
															<td>Tanggal pensiun</td>
															<td>:</td>
															<td>{{formatDate(item.tanggal_pensiun)}}</td>
														</tr>
														<tr>
															<td>No. SK Pensiun</td>
															<td>:</td>
															<td>{{item.no_sk}}</td>
														</tr>
														<tr>
															<td>Tanggal SK Pensiun</td>
															<td>:</td>
															<td>{{formatDate(item.tanggal_sk)}}</td>
														</tr>
													</tbody>
													<tr>
															<td>Jenis Pensiun</td>
															<td>:</td>
															<td>{{item.jenis_pensiun}}</td>
														</tr>
												</table>
											 
											</td>
										</tr>
										<tr v-if="grid_data.length==0">
											<td colspan="6">No Records</td>
										</tr>
									</tbody>
								</table>
							<!--./ table-responsive -->
							</div>
							<div id="paging" v-if="grid_data.length>0">
								<div class="page-text">Hal.</div>
								<div id="bhal" class="b-hal">
									<input id="inputpaging" type="text" class="input-page" size="2" 
									       v-model = "pager.input_page" 
									       @blur  = "inputPagingBlur" 
									       @focus ="inputPagingFocus"  
									       @change="goPaging(pager.input_page)">
								</div>
								<div class="page-text-mid">dari</div>
								<div id="bhalmax" class="page-text-mid">{{pager.page_count}}</div>

								<div class="btn-group paging-frame">
									<div class="btn btn-default active" v-if="!pager.has_prev">Prev</div>
									<div class="btn btn-default" @click="goPaging(pager.prev_page);" v-if="pager.has_prev">Prev</div>
									<div v-for="page in pager.page_to_display" v-bind:class="{'btn btn-default':1,'active':page==pager.current_page}" @click="goPaging(page);">{{page}}</div>
									<div class="btn btn-default" @click="goPaging(pager.next_page);" v-if="pager.has_next">Next</div>
									<div class="btn btn-default active"v-if="!pager.has_next">Next</div>
								</div>
							</div>
							<!-- ./panel-body -->
						</div>
						<!--  -->
					</div>
				</div>
				<!-- ./row -->
			</div>
		</div>
		<!-- #content-wraper -->
		<?=$pensiun_detail?>
		<?=$pensiun_form?>
	</div>
	<!-- #app -->
</div>
<script type="text/javascript" src="<?=site_url('assets/js/vue.min.js')?>"></script>
<script type="text/javascript" src="<?=site_url('assets/js/axios.min.js')?>"></script>
<script type="text/javascript" src="<?=site_url('assets/modules/appbkpp/pegawai/pensiun.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=site_url('assets/modules/appbkpp/pegawai/pensiun.css')?>">