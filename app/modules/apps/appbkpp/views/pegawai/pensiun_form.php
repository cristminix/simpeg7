<div id="pensiun_form" v-if="form != null && state.form_shown">
	<div class="row" id="detailpegawai" >
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 style="text-transform: capitalize;">{{form.mode}} Data Pegawai Pensiun</h4>
				</div>
				<div class="panel-body">
					<div class="row">
					<div class="col-lg-4">
						<div class="form-group has-feedback" v-if="form.mode!='add'">
							<label>Detail Pegawai</label>
							<br/>
							<b>{{detail.nama_pegawai}}</b>({{getVarRekapPeg('gender',detail)}})
												<br/>{{getVarRekapPeg('nip_baru',detail)}}
												<br/>{{getVarRekapPeg('nama_pangkat',detail)}}
												/ {{getVarRekapPeg('nama_golongan',detail)}}
							<br/>
							<a href="javascript:;"><img v-bind:src="photoUrl(detail.foto)" class=" img-responsive" /></a>				
							<input type="hidden" v-model="form.id_pegawai" class="form-control">

						</div>
						<div class="form-group has-feedback" v-if="form.mode=='add'">
							
								<!-- <input type="text" v-model="form.tanggal_pensiun" class="form-control">
								<input type="text" v-model="form.id_pegawai" class="form-control"  > -->
							<!-- </div> -->
							<label>Data Pegawai</label>
							<div class="form-group input-group">
								<input type="text" v-model="form.nip_baru" class="form-control row-fluid" placeholder="Masukkan NIP..." style="padding-left:5px;padding-right:5px;">			<span class="input-group-btn">
								<button class="btn btn-default" type="button" @click="pegawaiByNip();"><i class="fa fa-search"></i></button>
							</span>
							</div>
						</div>
						<div class="form-group has-feedback" v-if="form.mode=='add' && new_detail != null">
							<label>Detail Pegawai</label>
							<br/>
							<b>{{new_detail.nama_pegawai}}</b>({{new_detail.gender}})
												<br/>{{new_detail.nip_baru}}
												<br/>{{new_detail.nama_pangkat}}
												/ {{new_detail.nama_golongan}}
							<a href="javascript:;"><img v-bind:src="photoUrl(new_detail.foto)" class=" img-responsive" /></a>					
							<input type="hidden" v-model="form.id_pegawai" class="form-control">

						</div>
						<div class="form-group has-feedback" v-if="form.mode=='add' && new_detail == null">
							<span style="color: red">Tidak ada pegawai yang cocok dengan nip tersebut.</span>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="form-group has-feedback">
							<label>Tanggal BUP</label>
							<input type="text" v-model="form.tanggal_pensiun" class="form-control" :disabled="form.mode=='delete'" 
							placeholder="dd-mm-yyyy" 
							name="tanggal_pensiun"
							data-date-format="DD-MM-YYYY">

							
						</div>
						<div class="form-group has-feedback">
							<label>No SK. Pensiun</label>
							<input type="text" v-model="form.no_sk" class="form-control" :disabled="form.mode=='delete'">
						</div>
						<div class="form-group has-feedback">
							<label>Tanggal SK. Pensiun</label>
							<input type="text" v-model="form.tanggal_sk" class="form-control" :disabled="form.mode=='delete'" 
							placeholder="dd-mm-yyyy" 
							name="tanggal_sk"
							data-date-format="DD-MM-YYYY">
						</div>
						<div class="form-group has-feedback">
							<label>Jenis Pensiun</label>
							<select v-model="form.jenis_pensiun" class="form-control" :disabled="form.mode=='delete'">
								<option value="">Semua...</option>
								<option v-for="(nama,id) in filter_data.jenis_pensiun" v-model="id">{{nama}}</option>
								
							</select>
						</div>
						<div class="form-group has-feedback">
							<div class="button-group">
								<div class="row">
									<div class="col-md-6"><button class="btn btn-default" @click="backToGrid(true)"><i class="fa fa-close"></i> Batal</button></div>
									<div class="col-md-6" style="text-align: right;"><button class="btn btn-danger" @click="formSubmit(form)" :disabled="validateForm()==false"><i class="fa fa-save"></i> {{form.mode=='delete'?'Hapus':'Simpan'}}</button></div>
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>