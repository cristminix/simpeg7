<div class="col-lg-12" id="doc_el" style="padding: 1em">
	<div class="row">
		<div class="col-md-12">
			<h4><i class="fa fa-file"></i> Dokumen Elektronik</h4>
			
		</div>
	</div>
	<div class="row form" v-if="state.form_shown">
		<div class="panel panel-info" style="margin-bottom: 0">
			<div class="panel-header" style="background: #ddd;padding: 1em">
				<div class="row">
					<div class="col-lg-6">ADD DOKUMEN</div>
					<div class="col-lg-6" style="text-align: right;"><button class="btn btn-xs" @click="cancelForm()"><i class="fa fa-times"></i></button></div>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-lg-12">
					<div class="row" >
						<div class="col-md-4">
							
							<div class="form-group">
								<label>Nama Dokumen</label>
								<input type="text" name="title" class="form-control" v-model="form.title"/>
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>File</label>
								<input type="file" name="attachment" class="form-control" />
							</div>
							<!-- <div class="form-group">
									<label>Keterangan</label>
									<textarea name="keterangan[]" class="form-control" ></textarea>
							</div> -->
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-danger form-control" @click="submitForm()"  :disabled="vaidateForm()==false"><i class="fa fa-upload"></i> Submit</button>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row form form-edit" v-if="state.form_edit_shown">
		<div class="panel panel-info" style="margin-bottom: 0">
			<div class="panel-header" style="background: #ddd;padding: 1em">
				<div class="row">
					<div class="col-lg-6">EDIT DOKUMEN</div>
					<div class="col-lg-6" style="text-align: right;"><button class="btn btn-xs" @click="cancelForm(true)"><i class="fa fa-times"></i></button></div>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-lg-12">
					<div class="row" >
						<div class="col-md-4">
							
							<div class="form-group">
								<label>Nama Dokumen</label>
								<input type="text" name="title" class="form-control" v-model="form.title"/>
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>File</label>
								<input type="file" name="attachment" class="form-control" v-show="state.attachment_deleted"/>

								<div style="border: none;" class="form-control" v-show="!state.attachment_deleted"><span>{{form.data}}</span>&nbsp;<button class="btn btn-xs" title="Hapus File" @click="deleteAttachment()"><i class="fa fa-trash"></i></button></div>
							</div>
							<!-- <div class="form-group">
									<label>Keterangan</label>
									<textarea name="keterangan[]" class="form-control" ></textarea>
							</div> -->
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-danger form-control" @click="submitForm(true)"  :disabled="vaidateForm()==false"><i class="fa fa-upload"></i> Update</button>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row grid" style="padding: 2px 1em" v-if="state.grid_shown">
		<table class="table table-bordered" style="margin-top: 1em">
			<thead>
				<tr>
					<th style="width: 10px">No</th>
					<th style="width: 20px">Aksi</th>
					<th style="width: 200px;text-align: left">Nama Dokumen</th>
					<th style="text-align: left;">Dokumen/File</th>
				</tr>
			</thead>
			<tbody>
				<tr v-if="records.length==0">
					<td colspan="4">No records</td>
				</tr>
				<tr v-for="(r,index) in records">
					<td>{{index+1}}.</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown">
							<i class="fa fa-caret-down fa-fw"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li role="presentation" class="cpo">
									<a role="menuitem" tabindex="-1" @click="formEdit(r)">
									<i class="fa fa-edit fa-fw"></i> Edit Data</a>
								</li>
								<li role="presentation" class="cpo">
									<a role="menuitem" tabindex="-1" @click="formDelete(r)">
									<i class="fa fa-trash fa-fw"></i> Hapus Data</a>
								</li>
								
							</ul>
						</div>
					</td>
					<td>{{r.title}}</td>
					<td><a v-bind:href="fileUrl(r.data)" target="_blank">{{r.data}}</a></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="row" v-show="state.add_button_shown">
		<div class="col-md-12">
			<button class="btn btn-info" @click="formAdd()"><i class="fa fa-plus"></i></button>
		</div>
	</div>
</div>

<script type="text/javascript">
	const site_url = (p)=>{return `<?=base_url()?>${p}`};
	let doc_el = new Vue({
		el:'#doc_el',
		data:{
			id_pegawai:<?=$id_pegawai?>,
			records:[],
			form:{title:''},
			state:{
				form_shown:false,
				grid_shown:true,
				form_edit_shown:false,
				attachment_deleted:false,
				form_submitted:false,
				add_button_shown:true
			}
		},
		mounted(){
			this.reloadGrid();
		},
		methods:{
			reloadGrid(){
				// form_data.append('jenis_pensiun',this.form.jenis_pensiun);
                axios({
                    method:'post',
                    url:site_url('appdatapegawai/dokumen_elektronik/fetch/'+this.id_pegawai),
                    data:{},
                    headers: {'Content-Type': 'multipart/form-data' },

                })
                .then((response) => {
                    // Success 🎉
                    let data = response.data;
                    // console.log(data);
                    this.records = data;
                    // $(`div[m=${m}]`).html(data);
                    // if(form.mode=='delete'){
                       
                        // this.backToGrid(true); 
                        // this.gridPaging('');
                    // }
                    // this.form.submited = false;
                })
                 .catch((error) => {
                    alert(error.response.data);
                    // this.form.submited = false;
                });
			},
			submitForm(edit){
				edit = edit || false;
				let form_data = new FormData();
				form_data.append('id_pegawai',this.id_pegawai);
				form_data.append('title',this.form.title);
				form_data.append('attachment',$('input[name=attachment]')[0].files[0]);
				if(edit){
					form_data.append('id',this.form.id);
				}
				// 
				let url_path = edit?'update':'create';
                axios({
                    method:'post',
                    url:site_url(`appdatapegawai/dokumen_elektronik/${url_path}`),
                    data:form_data,
                    headers: {'Content-Type': 'multipart/form-data' },

                })
                .then((response) => {
                    // Success 🎉
                    let data = response.data;
                    console.log(data);
                    if(!data.success){
                    	alert(data.msg);
                    }else{
                    	if(edit){
                    		this.state.form_edit_shown=false;
                    		this.state.grid_shown=true;
                    	}
                    	this.clearForm();
                    	this.reloadGrid();
                    }
                   
                })
                 .catch((error) => {
                    alert(error.response.data);
                });
			},
			fileUrl(path){
				return site_url(`assets/file/dokumen/${path}`);
			},
			formAdd(){
				this.state.form_shown = true;
				this.state.form_edit_shown = false;
				this.state.grid_shown = false;

				this.state.add_button_shown = false;
				this.$nextTick(()=>{$('input[name=title]').focus()});
			},
			formEdit(r){
				this.form.title = r.title;
				this.form.data = r.data;
				this.form.id = r.id;
				if(r.data == ''){
					this.state.attachment_deleted = true;
				}
				this.state.form_edit_shown = true;
				this.state.form_shown = false;
				this.state.grid_shown = false;
				this.state.add_button_shown=false;
				this.$nextTick(()=>{$('input[name=title]').focus()});
			},
			deleteAttachment(){
				// console.log(r);
				const msg = `Apakah anda yakin ingin menghapus file ini ?`;
				if(confirm(msg)){
					let form_data = new FormData();
					form_data.append('id',this.form.id);
					
	                axios({
	                    method:'post',
	                    url:site_url('appdatapegawai/dokumen_elektronik/delete_attachment'),
	                    data:form_data,
	                    headers: {'Content-Type': 'multipart/form-data' },

	                })
	                .then((response) => {
	                    // Success 🎉
	                    let data = response.data;
	                    console.log(data);
	                    if(!data.success){
	                    	alert(data.msg);
	                    }else{
	                    	// this.reloadGrid();
	                    	this.state.attachment_deleted = true;
	                    	snackbar('<i class="fa fa-check"></i> File dihapus');
	                    }
	                   
	                })
	                 .catch((error) => {
	                    alert(error.response.data);
	                });
				}
			},
			formDelete(r){
				console.log(r);
				const msg = `Apakah anda yakin ingin menghapus dokumen ${r.title} ?`;
				if(confirm(msg)){
					let form_data = new FormData();
					form_data.append('id',r.id);
					
	                axios({
	                    method:'post',
	                    url:site_url('appdatapegawai/dokumen_elektronik/delete'),
	                    data:form_data,
	                    headers: {'Content-Type': 'multipart/form-data' },

	                })
	                .then((response) => {
	                    // Success 🎉
	                    let data = response.data;
	                    console.log(data);
	                    if(!data.success){
	                    	alert(data.msg);
	                    }else{
	                    	this.reloadGrid();
	                    }
	                   
	                })
	                 .catch((error) => {
	                    alert(error.response.data);
	                });
				}
			},
			cancelForm(){
				this.state.form_shown = false;
				this.state.form_edit_shown = false;
				this.state.grid_shown = true;
				this.clearForm();

			},
			clearForm(){
				this.form.title = '';
				this.form.data = '';
				this.form.id = '';
				this.form.id_pegawai = '';
				this.state.add_button_shown=true;
				$('input[name=attachment]').val('');
			},
			vaidateForm(){
				return this.form.title != '';
			}
		}
	});
</script>
<style type="text/css">
	.row.form{
		padding: 1em;
	}
	.cpo{
		cursor: pointer;
	}

</style>