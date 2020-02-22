<script type="text/javascript" src=""></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- <script type="text/javascript" src="<?=base_url()?>assets/jspdf/jspdf.debug.js"></script> -->
<!-- <script type="text/javascript" src="<?=base_url()?>assets/jspdf/jspdf.plugin.autotable.js"></script> -->

<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/vue.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vuejs2/axios.min.js"></script>
<!-- <script type="text/javascript" src="<?=base_url()?>assets/excellentexport/excellentexport.js"></script> -->
<script type="text/javascript" src="<?=base_url()?>assets/pdfmake/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/pdfmake/vfs_fonts.js"></script>
<!--  -->
<template  type="text/x-template" id="pagination">
    <ul class="pagination">
        <li 
      class="pagination-item"
    >
            <button 
        type="button" 
        @click="onClickFirstPage"
        :disabled="isInFirstPage"
        aria-label="Go to first page" class="btn" 
      >
        First
      </button>
        </li>
        <li
      class="pagination-item"
    >
            <button 
        type="button" 
        @click="onClickPreviousPage"
        :disabled="isInFirstPage"
        aria-label="Go to previous page" class="btn" 
      >
        <i class="fa fa-caret-left"></i>
      </button>
        </li>
        <li v-for="page in pages" class="pagination-item">
            <button 
        type="button" 
        @click="onClickPage(page.name)"
        :disabled="page.isDisabled"
        :class="{ active: isPageActive(page.name) }"
        :aria-label="`Go to page number ${page.name}`" class="btn" 
        
      >
        {{ page.name }}
      </button>
        </li>
        <li class="pagination-item">
            <button 
        type="button" 
        @click="onClickNextPage"
        :disabled="isInLastPage"
        aria-label="Go to next page" class="btn" 
      >
        <i class="fa  fa-caret-right"></i>
      </button>
        </li>
        <li class="pagination-item">
            <button 
        type="button" 
        @click="onClickLastPage"
        :disabled="isInLastPage"
        aria-label="Go to last page" class="btn" 
      >
        Last
      </button>
        </li>
    </ul>
</template>
<!--  -->
<div class="col-lg-12 mc" id="app">
    
    <form action="<?=site_url('apppayroll/ref_base_salary/edit/kenaikan_gaji')?>" method="post" class="kenaikan_gaji">
        <div class="row">
        <div class="col-md-8">
            <div class="form-group row">
        <label for="pa" class="col-md-2">Tahun:</label>
        <div class="col-md-4"><?= form_dropdown('tahun',$tahun_list,$tahun,'class="form-control" v-model="tahun"')?></div>
    </div>
        </div>
        <div class="col-md-4">
        </div>

    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group row">
        <label for="pa" class="col-md-2">Prosentase :</label>
        <div class="col-md-4"><?= form_input('prosentase',$prosentase,'class="form-control" v-model="prosentase"')?></div>
        <div class="col-md-6">
             <button :disabled="button_pressed" name="proses"  class="btn btn-info" value="yes" @click="onProcessForm()"><i v-bind:class="{'fa fa-search':!button_pressed,'fa fa-spinner fa-spin':button_pressed}"></i> Proses</button>
             &nbsp;
             <button :disabled="salaries.data.length <= 0 || selected_rows.length <= 0 || button_pressed" name="save"  class="btn btn-danger" value="yes" @click="onSaveForm()"><i v-bind:class="{'fa fa-save':!button_pressed,'fa fa-spinner fa-spin':button_pressed}"></i> Simpan</button>
        </div>
    </div>
        </div>
        <div class="col-md-4">
            
        </div>

    </div>
   
    <div class="row">
        <div class="col-md-6">
           
            
        </div>
        <div class="col-md-6">
            
           
        </div>

    </div>
    <div class="row" style="padding-top: 1em">
            <div class="col-md-6">
                <!-- <label class="col-md-3">
                    Per Page
                </label> -->
                <div class="col-md-3" style="padding-left: 0">
                    <select class="form-control" v-model="salaries.per_page">
                    <option value="10" selected="selected">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>
                </div>
                
            </div>
            <div class="col-md-6" style="text-align: right;">
                 <pagination
   :total-pages="salaries.total_pages"
   :total="salaries.total_rows"
   :per-page="salaries.per_page"
   :current-page="salaries.page"
   @pagechanged="onPageChange"
 ></pagination>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12" style="padding-top: 1em">
            <table id="grid" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 30px"><input type="checkbox" name="ck_all" v-model='ck_all' @click="onToggleSelectAll()"></th>
                        <th style="text-align: right;width: 120px">Kode Peringkat</th>
                        <th style="text-align: right;width: 120px">MK Peringkat</th>
                        <th style="text-align: right;width: 120px">Gaji Pokok</th>
                        <th style="text-align: right;width: 120px">Penambahan</th>
                        <th style="text-align: right;width: 120px">Gaji Pokok Baru</th>
                        <th style="text-align: center;" width="30px">Tahun</th>
                        <th> NAMA PANGKAT</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in salaries.data">
                        <td style="text-align: center;"><input type="checkbox" v-model="r.selected" @click="onToggleSelectRow(r)"></td>
                        <td style="text-align: right;"><span v-text="r.kode_golongan"></span></td>
                        <td style="text-align: right;"><span v-text="r.mk_peringkat"></span></td>
                        <td style="text-align: right;"><span v-text="r.gaji_pokok_before"></span></td>
                        <td style="text-align: right;"><span v-text="r.gaji_pokok_add"></span></td>
                        <td style="text-align: right;"><span v-text="r.gaji_pokok"></span></td>
                        <td style="text-align: center;"><span v-text="r.tahun"></span></td>
                        <td><span v-text="r.nama_pangkat"></span></td>
                        
                    </tr>
                    <tr v-show="salaries.data.length == 0">
                        <td colspan="8"> Tidak Ada Data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
   
</div>
<iframe style="display: none" id="ifr"></iframe>
<style type="text/css">
    .mc{
        margin-top: 1em
    }
    .mc > .row{
        margin-right: -28px !important;
        margin-left: -28px !important;
    }
    form.report  label{
        line-height: 32px;
    }
    input[role=datepicker]{
        text-align: center;
    }
    table.table-lap th.tc{
        text-align: center !important;
    }
    table.table-lap th.vm{
        vertical-align: middle !important;

    }
    table.table-lap th.vt{
        vertical-align: top !important;

    }
    table.table-lap th{
        white-space: nowrap !important;
    } 
    .grid{
        width: 99%;
        margin: 0 auto;
        overflow: auto;
    }
    table.table-lap td.tc{
        text-align: center !important;
    }
    table.table-lap td.tl{
        text-align: left !important;
    }
    table.table-lap td.tr{
        text-align: right !important;
    }
</style>
<script type="text/javascript">

    var KG={};
    $(document).ready(function(){
        // $('.main > h3').html('DAFTAR GAJI PEGAWAI');  
 ///////
        Vue.component('pagination',{
          // name: 
          template: '#pagination',
            props: {
            maxVisibleButtons: {
              type: Number,
              required: false,
              default: 3
            },
            totalPages: {
              type: Number,
              required: true
            },
            total: {
              type: Number,
              required: true
            },
            perPage: {
              type: Number,
              required: true
            },
            currentPage: {
              type: Number,
              required: true
            },
          },
          computed: {
            startPage() {
              if (this.currentPage === 1) {
                return 1;
              }
        
              if (this.currentPage === this.totalPages) { 
                return this.totalPages - this.maxVisibleButtons + 1;
              }
        
              return this.currentPage - 1;
        
            },
            endPage() {
              
              return Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);
              
            },
            pages() {
              const range = [];
        
              for (let i = this.startPage; i <= this.endPage; i+= 1 ) {
                range.push({
                  name: i,
                  isDisabled: i === this.currentPage 
                });
              }
        
              return range;
            },
            isInFirstPage() {
              return this.currentPage === 1;
            },
            isInLastPage() {
              return this.currentPage === this.totalPages;
            },
          },
          methods: {
            onClickFirstPage() {
              this.$emit('pagechanged', 1);
            },
            onClickPreviousPage() {
              this.$emit('pagechanged', this.currentPage - 1);
            },
            onClickPage(page) {
              this.$emit('pagechanged', page);
            },
            onClickNextPage() {
              this.$emit('pagechanged', this.currentPage + 1);
            },
            onClickLastPage() {
              this.$emit('pagechanged', this.totalPages);    
            },
            isPageActive(page) {
              return this.currentPage === page;
            },
          }
         });
//////                
        KG = new Vue({
            el:'#app',
            data : {
                tahun_list : <?=json_encode($tahun_list)?>,
                prosentase : '<?=$prosentase?>', 
                tahun : '<?=$tahun?>',
                button_pressed: <?=$button_pressed?'true':'false'?>,
                salaries:{data:[],tahun:0,prosentase:0,total_pages:0,total_rows:0,page:1,per_page:10},
                ck_all:false,
                selected_rows:[]
            },
            mounted(){
                $("form.kenaikan_gaji").submit(function(e){
                    e.preventDefault(e);
                });
            },
            methods:{
                onPageChange(page) {
                  console.log(page)
                  this.salaries.page = page;
                  this.ck_all = false;
                  this.onProcessForm();
                },
                onToggleSelectRow:function(rw){
                    rw.selected = !rw.selected;
                    var index = this.selected_rows.indexOf(rw.id_gaji_pokok);
                    // console.log(rw);
                    if(rw.selected){
                        this.selected_rows.push(rw.id_gaji_pokok);
                    }else{
                        if (index > -1) {
                           this.selected_rows.splice(index, 1);
                        }
                    }
                },
                onSaveForm:function(){
                    var prxy_url = '<?=site_url('apppayroll/ref_base_salary/edit/kenaikan_gaji')?>';
                    this.button_pressed = true;
                    // this.salaries.data=[];
                    var postData = {
                        tahun : this.tahun,
                        prosentase : this.prosentase,
                        proses : 'yes',
                        cmd:'save_rows',
                        ids: this.selected_rows
                    };
                    var self = this;
                    axios.post(prxy_url,postData).then(function (response) {
                        self.salaries.page = 1;
                        // self.button_pressed = false;
                        self.ck_all = false;
                        self.selected_rows = [];
                        alert('OK');
                        self.onProcessForm();
                      })
                      .catch(function (error) {
                        alert(error);
                      });
                },
                onToggleSelectAll:function(){
                    
                    this.ck_all = !this.ck_all;
                    // console.log(this.ck_all);
                    this.selected_rows = [];
                    self = this;
                    $.each(this.salaries.data,function(i,rw){
                        rw.selected = self.ck_all;
                        var index = self.selected_rows.indexOf(rw.id_gaji_pokok);
                        if(rw.selected){
                            self.selected_rows.push(rw.id_gaji_pokok);
                        }else{
                            if (index > -1) {
                               self.selected_rows.splice(index, 1);
                            }
                        }
                    });
                },
                onProcessForm:function(){
                    var prxy_url = '<?=site_url('apppayroll/ref_base_salary/edit/kenaikan_gaji')?>';
                    this.button_pressed = true;
                    this.salaries.data=[];
                    var postData = {
                        tahun : this.tahun,
                        prosentase : this.prosentase,
                        per_page: this.salaries.per_page,
                        page: this.salaries.page,
                        proses : 'yes',
                        cmd:'get_list'
                    };
                    var self = this;
                    axios.post(prxy_url,postData).then(function (response) {
                        self.salaries = response.data;
                        self.button_pressed = false;
                        self.ck_all = false;
                        self.selected_rows = [];

                      })
                      .catch(function (error) {
                        alert(error);
                      });
                }
            }
        });
        //

    });
</script>