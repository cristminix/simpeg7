$(document).ready(function() {
    app.vm = new Vue({
        el: '#app',
        data: {
            sub_title: app.data.sub_title,
            // nama_unor: app.data.nama_unor,
            config: {
                filter_open: false
            },
            filter_data: {
                unor: app.data.dd_unor,
                pangkat_golongan: app.data.dd_pangkat_golongan,
                jenis_jabatan: app.data.dd_jenis_jabatan,
                agama: app.data.dd_agama,
                status_pegawai: app.data.dd_status_pegawai,
                kelompok_pegawai: app.data.dd_kelompok_pegawai,
                status_perkawinan: app.data.dd_status_perkawinan,
                kode_jenjang_pendidikan: app.data.dd_kode_jenjang_pendidikan,
                jenis_pensiun: app.data.dd_jenis_pensiun
            },
            pagination: app.data.pagination,
            pagination_per_pages: [10, 25, 50, 100],
            filter: {

                search_query: app.data.search_query,
                kode_unor: '',
                status_kepegawaian: 'all',
                pangkat_golongan: '',
                jabatan: '',
                gender: '',
                status_perkawinan: '',
                kode_jenjang_pendidikan: '',
                agama: '',
                jenis_pensiun:''
            },
            grid_data: [],
            pager: {
                input_page: '',
                current_page:'',
                page_count:4,
                page_to_display:[],
                is_first_page:false,
                has_next:false,
                has_prev:false,
                prev_page:0,
                next_page:0,
                max_page_to_display:5
            },
            state:{
            	grid_shown:true,
            	detail_shown:false,
                form_shown:false
            },
            detail:null,
            form:null,
            new_detail:null
        },
        mounted:function(){
        	console.log('mounted');
        	this.gridPaging('');
        },
        methods: {
            goBack: function() {
                document.location.href = app.link.pegawai_aktif;
            },
            toggleFilter: function() {
                this.config.filter_open = !this.config.filter_open;
            },
            onFilterChanged: function() {
                console.log(this.filter);
                this.goPaging('');
            },
            onPaginationChanged: function() {
                console.log(this.pagination);
            },
            onGridSearch: function() {
                console.log(this.filter.search_query);
                this.goPaging('');
            },
            goPaging: function(page) {
                // console.log(app.vm.pager.input_page);
                // this.gridPaging(this.pager.input_page);
                this.pagination.page = page;
                this.gridPaging(page);
            },
            inputPagingBlur: function(event) {
                const el = event.target;
                if (el.value == '') {
                    el.value = '1';
                }
            },
            inputPagingFocus: function(event) {
                const el = event.target;
                if (el.value == '1') {
                    el.value = '';
                }
            },
            gridPaging: function(page) {
                console.log(page);
                var form_data = new FormData();
				for ( var key in this.filter ) {
				    form_data.append(key, this.filter[key] );
				}
				form_data.append('page',page);
				form_data.append('per_page',this.pagination.per_page);
                axios({
                	method:'post',
                	url:app.site_url('appbkpp/pegawai/pensiun_json'),
                	data:form_data,
                	headers: {'Content-Type': 'multipart/form-data' },

                })
				    .then((response) => {
				        // Success 🎉
				        let data = response.data;
				        this.grid_data = data.records;
				        this.buildPager(data);
				    })
				    .catch((error) => {
				        alert(error.response.data);
				    });

                // 
            },
            buildPager:function(data){
            	this.pager.page_count = parseInt(data.total_pages);
				this.pager.current_page = parseInt(data.current_page);
				this.pagination.page = parseInt(data.current_page);
				this.pager.input_page = parseInt(data.current_page);
				this.pager.page_to_display=[];


				/*
					if x+(y-1)==total_pages
					 loop from hi to lo
					else
					 loop from current page until max_page_to_display
				*/
				this.pager.max_page_to_display = parseInt(this.pager.max_page_to_display);
				// this.pager.current_page = parseInt(this.pager.current_page);
				if((this.pager.current_page + (this.pager.max_page_to_display-1) >= data.total_pages)&&data.total_pages>this.pager.max_page_to_display){
					//                11             >   11-5=6    
					let i = 1;
					let last = data.total_pages;//11
					while(i<=this.pager.max_page_to_display){
						this.pager.page_to_display.push(last--);
						i++;
					}   
					// for (var i = data.total_pages; i > l; i--) {
						
					// }
					this.pager.page_to_display.reverse();
				}else{
					if(data.total_pages > 1 ){
					
						for (var i = this.pager.current_page; i < (this.pager.current_page+this.pager.max_page_to_display); i++) {
							this.pager.page_to_display.push(i);
							
						}
					}else{
						this.pager.page_to_display.push(1);
					}
				}

				if(this.pager.current_page == data.total_pages){
					this.pager.has_next = false;
				}else{
					this.pager.has_next = true;
					this.pager.next_page = this.pager.current_page + 1;
				}

				if(this.pager.current_page == 1){
					this.pager.has_prev = false;
				}else{
					this.pager.has_prev = true;
					this.pager.prev_page = this.pager.current_page - 1;
				}
            },
            photoUrl: function(foto,width,height){
            	// if(typeof foto == undefined)return '';
            	let rand = (new Date()).getTime();
            	let w = 150;
            	let h = 200;
            	if(!isNaN(height)){
            		h = height;
            	}
            	if(!isNaN(width)){
            		w = width;
            	}
            	return app.site_url(`appbkpp/pegawai/foto_thumb/${foto}/${w}/${h}?nd=${rand}`);
            },
            getRowNumber:function(index){
            	let number = 0;
            	let page = parseInt(this.pagination.page)+0;
            	let per_page = parseInt(this.pagination.per_page);

            	if(page === 1){
            		number = index+1;
            	}else{
            				// 1       +  (10 * 1)	
            		number = (index+1) + (per_page*(page-1));
            	}
            	return number;
            },
            getVarRekapPeg:function(k,item){
            	try{
				let prop = JSON.parse(item.var_rekap_peg);
            	
            	return prop[k].length>0?prop[k]:'-';
            	}
            	catch(e){
            		return '-';
            	}
            	
            },
            viewDetailPegawai:function(item){
            	this.detail = item;
            	this.state.grid_shown = false;
            	this.state.detail_shown = true;
            },
            backToGrid:function(isForm){
                if(typeof isForm != 'undefined'){
                    if(isForm == true){
                        this.state.form_shown = false;
                        this.new_detail = null;
                    }
                }
            	this.state.grid_shown = true;
            	this.state.detail_shown = false;
            },
            getTabRo:function(m,id){
            	var form_data = new FormData();
				// for ( var key in this.filter ) {
				//     form_data.append(key, this.filter[key] );
				// }
				form_data.append('id_pegawai',id);
				form_data.append('m',m);
				form_data.append('f','view');
                axios({
                	method:'post',
                	url:app.site_url('datapegawai/gettab_ro'),
                	data:form_data,
                	headers: {'Content-Type': 'multipart/form-data' },

                })
			    .then((response) => {
			        // Success 🎉
			        let data = response.data;
			        // console.log(data);
			        $(`div[m=${m}]`).html(data);
			    })
			     .catch((error) => {
			        alert(error.response.data);
			    });
            },
            applyJsForm(){
                let self = this;
                this.$nextTick(function(){
                    $('input[name=tanggal_pensiun],input[name=tanggal_sk]').datetimepicker();
                    $('input[name=tanggal_pensiun]').on('dp.change',function(e){
                        // console.log(e)
                        self.form.tanggal_pensiun = e.target.value;
                    });
                    $('input[name=tanggal_sk]').on('dp.change',function(e){
                        self.form.tanggal_sk = e.target.value;

                    });;

                });
            },
            formEdit(item){
                console.log(item);
                this.detail = item;
                this.state.form_shown = true;
                this.state.grid_shown = false;
                this.form = {mode:'edit',submited:false};
                this.form.id = item.id;
                this.form.id_pegawai = item.id_pegawai;
                this.form.tanggal_pensiun = this.formatDate(item.tanggal_pensiun);
                this.form.no_sk = item.no_sk;
                this.form.tanggal_sk = this.formatDate(item.tanggal_sk);
                this.form.jenis_pensiun = item.jenis_pensiun;

                this.applyJsForm();

            },
            formDelete(item){
                console.log(item);
                this.detail = item;
                this.state.form_shown = true;
                this.state.grid_shown = false;
                this.form = {mode:'delete',submited:false};
                this.form.id = item.id;
                this.form.id_pegawai = item.id_pegawai;
                this.form.tanggal_pensiun = this.formatDate(item.tanggal_pensiun);
                
                this.form.no_sk = item.no_sk;
                this.form.tanggal_sk = this.formatDate(item.tanggal_sk);
                 
                this.form.jenis_pensiun = item.jenis_pensiun;

            },
            formAdd(){
                // console.log(item);
                // this.detail = item;
                this.state.form_shown = true;
                this.state.grid_shown = false;
                this.form = {mode:'add',submited:false,nip_baru:''};
                // this.form.id = item.id;
                this.form.id_pegawai = '';
                this.form.tanggal_pensiun = '';
                this.form.no_sk = '';
                this.form.tanggal_sk = '';
                this.form.jenis_pensiun = '';
                this.applyJsForm();

            },
            validateForm(){
                return this.form.id_pegawai != "" && 
                this.form.tanggal_sk.match('\d\d-\d\d-\d\d\d\d') && 
                this.form.tanggal_sk.match('\d\d-\d\d-\d\d\d\d') &&
                this.form.jenis_pensiun.length > 1 &&
                this.form.no_sk.length > 1;
            },
            formSubmit(form){
                if(this.form.submited === false){
                    this.form.submited = true;
                    console.log(form);

                    var form_data = new FormData();
                    // for ( var key in this.filter ) {
                    //     form_data.append(key, this.filter[key] );
                    // }
                    if(form.mode == 'edit'){
                        form_data.append('id',this.form.id);
                    }
                    if(form.mode == 'add'){
                        form_data.append('nip_baru',this.form.nip_baru);
                        form_data.append('nama_pegawai',this.form.nama_pegawai);
                    }
                    
                    form_data.append('id_pegawai',this.form.id_pegawai);
                    form_data.append('no_sk',this.form.no_sk);
                    form_data.append('tanggal_sk',this.mysqlDate(this.form.tanggal_sk));
                    form_data.append('tanggal_pensiun',this.mysqlDate(this.form.tanggal_pensiun));
                    form_data.append('jenis_pensiun',this.form.jenis_pensiun);
                    axios({
                        method:'post',
                        url:app.site_url('appbkpp/pegawai/pensiun_form/'+this.form.mode),
                        data:form_data,
                        headers: {'Content-Type': 'multipart/form-data' },

                    })
                    .then((response) => {
                        // Success 🎉
                        let data = response.data;
                        console.log(data);
                        // $(`div[m=${m}]`).html(data);
                        // if(form.mode=='delete'){
                           
                            this.backToGrid(true); 
                            this.gridPaging('');
                        // }
                        this.form.submited = false;
                    })
                     .catch((error) => {
                        alert(error.response.data);
                        this.form.submited = false;
                    });

                        
                }
            },
            pegawaiByNip(){
                console.log(this.form.nip_baru);
                var form_data = new FormData();
                // for ( var key in this.filter ) {
                //     form_data.append(key, this.filter[key] );
                // }
                form_data.append('nip',this.form.nip_baru);
                axios({
                    method:'post',
                    url:app.site_url('appbkpp/mutasi/cari_nip'),
                    data:form_data,
                    headers: {'Content-Type': 'multipart/form-data' },

                })
                .then((response) => {
                    // Success 🎉
                    let data = response.data;
                    if(data != '' && data != []){
                        this.new_detail = data;
                        this.form.id_pegawai = data.id_pegawai;
                        this.form.nama_pegawai = data.nama_pegawai;
                        this.form.nip_baru = data.nip_baru;
                        console.log(data);
                    }else{
                        this.new_detail = null;
                    }
                    
                    // $(`div[m=${m}]`).html(data);
                })
                 .catch((error) => {
                    alert(error.response.data);
                });
            },
            formatDate(str){
                try{
                    let dt = str.split('-');
                    if(dt.length==3){
                        return dt[2]+'-'+dt[1]+'-'+dt[0];
                    }
                }catch(e){
                    return '00-00-0000';
                }
            },
            mysqlDate(str){
                try{
                    let dt = str.split('-');
                    if(dt.length==3){
                        return dt[2]+'-'+dt[1]+'-'+dt[0];
                    }
                }catch(e){
                    return '0000-00-00';
                }
            }
        }
    });
});