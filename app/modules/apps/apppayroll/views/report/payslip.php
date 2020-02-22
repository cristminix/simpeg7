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


<div class="col-lg-12 mc" id="app">
	<form action="<?=site_url('apppayroll/report/payslip')?>" method="post" class="report">
		<div class="row">
		<div class="col-md-8">
			<div class="form-group row">
		<label for="pa" class="col-md-2">Unit Kerja:</label>
		<div class="col-md-4"><?= form_dropdown('id_unor',$unor_list,$id_unor,'class="form-control" v-model="id_unor"')?></div>
	</div>
		</div>
		<div class="col-md-4">
		</div>

	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group row">
		<label for="pa" class="col-md-2">Status Peg.:</label>
		<div class="col-md-4"><?= form_dropdown('empl_stat',[''=>'All','Tetap'=>'Tetap','Capeg'=>'Capeg','Kontrak'=>'Kontrak','Khusus'=>'Khusus'],$id_unor,'class="form-control" v-model="empl_stat"')?></div>
	</div>
		</div>
		<div class="col-md-4">
		</div>

	</div>
	<div class="row">
		<div class="col-md-8">
			
				<div class="form-group row">
						<label for="pa" class="col-md-2">Periode:</label>
						<div class="col-md-3"><?=form_input('periode',$periode,'placeholder="mm/YY" name="periode"class="form-control" id="periode" role="datepicker"')?></div>
						
				</div>
			
			</div>
		<div class="col-md-4">
			
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-6">
			<button :disabled="button_pressed" name="proses"  class="btn btn-info" value="yes" @click="onProcessForm()"><i v-bind:class="{'fa fa-search':!button_pressed,'fa fa-spinner fa-spin':button_pressed}"></i> Proses</button>
			<button v-show="report_data.length>0" name="export_pdf" class="btn btn-warning"  @click="onExportPdf()"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
			<button v-show="report_data.length>0" name="export_accnum" class="btn btn-success"  @click="onExportAccnum()"><i class="fa fa-file-excel-o"></i> Export Daftar Transfer</button>
		</div>
		<div class="col-md-6">
		</div>

	</div>
</form>
	<div class="row">
		<div class="col-md-12">
			<div class="content" style="padding: 1em;margin: 1em -1em">
				<div v-bind:class="{'alert alert-info':button_pressed,'alert alert-warning':!button_pressed}" v-if="false">
					Button <span v-text="button_pressed?'Is':'Not'"></span> Pressed !
				</div> 
				<div class="grid">
					<table class="table table-bordered table-lap">
						<thead>
							<tr>
								<th rowspan="2" class="tc vm">NO</th>
								<th>NAMA</th>
								<th colspan="5" class="tc">ABSENSI</th>
								<th colspan="4" class="tc">TUNJANGAN - TUNJANGAN</th>
								<th rowspan="2" class="tc vm">GAJI<br/>KOTOR</th>
								<th colspan="4" class="tc">POTONGAN - POTONGAN</th>
								<th rowspan="2" class="tc vm">JUMLAH<br/>POTONGAN</th>
								<th rowspan="2" class="tc vm">GAJI<br/>BERSIH</th>
								<!-- <th rowspan="2" class="tc vm">TANDA TANGAN</th> -->

							</tr>
							<tr>
								<th>REKENING NO. / EMPID<br/>JABATAN<br/>GAJI POKOK<br/>P-M-STATUS</th>
								<th class="tc vt">S</th>
								<th class="tc vt">I</th>
								<th class="tc vt">A</th>
								<th class="tc vt">L</th>
								<th class="tc vt">C</th>
								<th class="tc vt">ISTRI<br/>ANAK<br/>BERAS<br/>AIR</th>
								<th class="tc vt">JABATAN<br/>PRESTASI<br/>LEMBUR<br/>KHUSUS</th>
								<th class="tc vt">PERUMAHAN<br/>TRANSPORT<br/>KENDARAAN<br/>MAKAN</th>
								<th class="tc vt">SHIFT<br/>TPP<br/>PPH21</th>
								<th class="tc vt">PPH21<br/>ASTEK<br/>ASPEN<br/>FKP</th>
								<th class="tc vt">KOPERASI<br/>KOP. WAJIB<br/>D. WANITA<br/>TPTGR</th>
								<th class="tc vt">ASKES<br/>REK. AIR<br/>BPJS.PEN</th>
								<th class="tc vt">ZAKAT<br/>SHDQ</th>

							</tr>
						</thead>
						<tbody>
							<tr v-for="(r, index) in report_data">
								<td class="tc" v-text="index+1"></td>
								<td class="tl" v-html="r.empl_name+'<br/>'+r.acc_number+'/'+r.empid+'<br/>'+r.job_title+'<br/>'+r.base_sal+' <br/> '+(r.empl_stat=='Kontrak'?'0':r.kode_peringkat)+' - '+ (r.empl_stat=='Kontrak'?'0':r.los) +' - '+(( r.mar_stat === '' || r.mar_stat=== '0') ?'Belum Kawin':'Kawin')+' ' + (r.child_cnt>0?'Anak ' + r.child_cnt:'')"></td>
								<td class="tc" v-text="r.attn_s"></td>
								<td class="tc" v-text="r.attn_i"></td>
								<td class="tc" v-text="r.attn_a"></td>
								<td class="tc" v-text="r.attn_l"></td>
								<td class="tc" v-text="r.attn_c"></td>


								<td class="tr" v-html="r.alw_mar+'<br/>'+r.alw_ch+'<br/>'+r.alw_rc+'<br/>'+r.alw_wt"></td>
								<td class="tr" v-html="r.alw_jt+'<br/>'+r.alw_prf+'<br/>'+r.alw_ot+'<br/>'+r.alw_adv"></td>
								<td class="tr" v-html="r.alw_rs+'<br/>'+r.alw_tr+'<br/>'+r.alw_vhc_rt+'<br/>'+r.alw_fd"></td>
								<td class="tr" v-html="r.alw_sh+'<br/>'+r.alw_tpp+'<br/>'+r.alw_pph21"></td>
								<td class="tr" v-html="r.gross_sal"></td>

								<td class="tr" v-html="r.ddc_pph21+'<br/>'+r.ddc_bpjs_ket+'<br/>'+r.ddc_aspen+'<br/>'+r.ddc_f_kp"></td>
								<td class="tr" v-html="r.ddc_wc+'<br/>'+r.ddc_wcl+'<br/>'+r.ddc_dw+'<br/>'+r.ddc_tpt"></td>
								<td class="tr" v-html="r.ddc_bpjs_kes+'<br/>'+r.ddc_wb+'<br/>'+r.ddc_bpjs_pen"></td>
								<td class="tr" v-html="r.ddc_zk+'<br/>'+r.ddc_shd"></td>
								<td class="tr" v-html="r.ddc_amt"></td>
								<td class="tr" v-html="r.net_pay"></td>
								<!-- <td>&nbsp;</td> -->
							</tr>
							<tr v-if="!button_pressed">
								<td colspan="19">Tidak ada data</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
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
	function s2ab(s) {
	var buf = new ArrayBuffer(s.length);
	var view = new Uint8Array(buf);
	for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
	return buf;
	}
	var PDF = {
		build:function(report_data,title) {
			var b = [true, true, true, true];
			var fc = '#fff';
			var fb = '#ddd';
			var headerTitle = title;
			var dd = {
				header: function(currentPage, pageCount) {
					        var columnText = [
					        
					        ];
					        columnText.push( "Halaman: " + currentPage + " - " + pageCount); 
					        return [{text: headerTitle, style: {fontSize:10,alignment:'center',bold:true},margin:[0,30,0,0]},
					                          { text: columnText[0], alignment: 'left', margin: [35,3,0,0],  style:{ fontSize: 7} }]; 
					    },
					    pageMargins: [35,80,35,30],
				pageSize: 'A4',
				// pageMargins: [ 8, 8, 8, 8 ],
				pageOrientation: 'landscape',
				styles: {
					default: {
						fontSize:6,
						alignment:'center',
						
					},
					tl:{
						alignment:'left'
					},
					tc:{
						alignment:'center'
					},
					tr:{
						alignment:'right'
					},
					header: {
						fontSize: 18,
						bold: true,
						margin: [0, 0, 0, 10],
						alignment:'center'
					},
				},
				content:[
					
					{
						style: 'default',
						table: {
							widths: [ 'auto','*','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','*'],
							headerRows: 2,
								keepWithHeaderRows: 1,
							dontBreakRows: true, 
							body: [
									[{border: b, fillColor: fc, text: "NO", rowSpan:2 ,margin:[3,16,3,3]}, 
									 {border: [true,true,false,false],style:{alignment:'left'}, fillColor: fc, text: 'NAMA'  ,margin:[3,3,3,3]                                                  }, 
									 {border: b, fillColor: fc, text: 'ABSENSI', colSpan:5 ,margin:[3,3,3,3]},
									 ''                                    ,
									 ''                                    ,
									 ''                                    ,
									 ''                                    , 
									 {border: b, fillColor: fc, text: 'TUNJANGAN - TUNJANGAN', colSpan:4 ,margin:[3,3,3,3]}, 
									 '',                                                                     
									 ''                                                                           ,
									 '',                                                    
									 {border: b, fillColor: fc, text: "GAJI\nKOTOR", rowSpan:2 ,margin:[3,16,3,3]}, 
									 {border: b, fillColor: fc, text: 'POTONGAN - POTONGAN', colSpan:4 ,margin:[3,3,3,3]}, 
									 ''                                                                            ,
									 ''                                                 , 
									 ''                                                                           ,  
									 {border: b, fillColor: fc, text: "JUMLAH\nPOTONGAN", rowSpan:2,margin:[3,16,3,3] }, 
									 {border: b, fillColor: fc, text: "GAJI\nBERSIH", rowSpan:2 ,margin:[3,16,3,3]}, 
									 {border: b, fillColor: fc, text: "TANDA TANGAN", rowSpan:2,margin:[3,16,3,3] } 
									],
									['',                                                 
									 {border: [false,false,false,false], fillColor: fc,margin:[3,3,3,3] , text: "REKENING NO. / EMPID\nJABATAN\nGAJI POKOK\nP-M-STATUS",style:'tl'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: 'S'                  }, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: 'I'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: 'A'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: 'L'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: 'C'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "ISTRI\nANAK\nBERAS\nAIR"       }, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "JABATAN\nPRESTASI\nLEMBUR\nKHUSUS"}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "PERUMAHAN\nTRANSPORT\nKENDARAAN\nMAKAN"},
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "SHIFT\nTPP\nPPH21\n"}, 
									 '',                                            
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "PPH21\nASTEK\nASPEN\nFKP"    }, 
									 {border: b ,margin:[3,3,3,3]  , fillColor: fc, text: "KOPERASI\nKOP.WAJIB\nD.WANITA\nTPTGR"},
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "ASKES\nREK.AIR\nBPJS.PEN"},
									 {border: b,margin:[3,3,3,3],  fillColor: fc, text: "ZAKAT\nSHDQ"},
									 '',
									 '',
									 ''
								   ]
								]
						},
						layout: {
							defaultBorder: false,
							hLineWidth: function(i, node) {
						      return (i === 0 || i === node.table.body.length) ? 1 : 1;
						    },
						    vLineWidth: function(i, node) {
						      return (i === 0 || i === node.table.widths.length) ? 0.1 : 0.1;
    }
						},

					}
				]
			};
			// console.log(dd);
			$.each(report_data,function(i,r){
				var no = i+1;
				if(r.empl_stat == 'Kontrak'){
					r.kode_peringkat = 0;
					r.los = 0;
				}
				var _1ColText = r.empl_name+"\n"+r.acc_number+'/'+r.empid+"\n"+r.job_title+"\n"+r.base_sal+"\n"+r.kode_peringkat+' - '+ r.los +' - '+ ( (r.mar_stat === '0' || r.mar_stat === '') ? 'Belum Kawin':'Kawin') +' ' + (r.child_cnt>0?'Anak ' + r.child_cnt:'');
				var _7ColText = r.alw_mar+"\n"+r.alw_ch+"\n"+r.alw_rc+"\n"+r.alw_wt;
				var _8ColText = r.alw_jt+"\n"+r.alw_prf+"\n"+r.alw_ot+"\n"+r.alw_adv;

				var _9ColText = r.alw_rs+"\n"+r.alw_tr+"\n"+r.alw_vhc_rt+"\n"+r.alw_fd;
				var _10ColText = r.alw_sh+"\n"+r.alw_tpp+"\n"+r.alw_pph21;
				var _12ColText = r.ddc_pph21+"\n"+r.ddc_bpjs_ket+"\n"+r.ddc_aspen+"\n"+r.ddc_f_kp;
				var _13ColText = r.ddc_wc+"\n"+r.ddc_wcl+"\n"+r.ddc_dw+"\n"+r.ddc_tpt ;
				var _14ColText = r.ddc_bpjs_kes+"\n"+r.ddc_wb+"\n"+r.ddc_bpjs_pen;
				var _15ColText = r.ddc_zk+"\n"+r.ddc_shd;
				// var _9ColText = ;
				var row = [
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: no }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _1ColText, style: 'tl' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.attn_s }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.attn_i }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.attn_a }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.attn_l }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.attn_c }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _7ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _8ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _9ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _10ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.gross_sal, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _12ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _13ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _14ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _15ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.ddc_amt, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.net_pay, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: '', style: 'tr' }, 
					 
				];

				dd.content[0].table.body.push(row);
				// if(no%9==0){
				// 	var pbreak=[{text: '', pageBreak: 'before',colSpan:19}];
				// 	dd.content[0].table.body.push(pbreak);

				// }
			});
			//11.69x8.50 inch
			pdfMake.createPdf(dd).open();
			
		}
};
	var RP={};
	$(document).ready(function(){
		$('.main > h3').html('DAFTAR GAJI PEGAWAI');		
		RP = new Vue({
			el:'#app',
			data : {
				unor_list : <?=json_encode($unor_list)?>,
				id_unor : '<?=$id_unor?>',
				periode : '<?=$periode?>',
				bulan : '<?=$bulan?>',
				tahun : '<?=$tahun?>',
				empl_stat:'',
				button_pressed: <?=$button_pressed?'true':'false'?>,
				report_data:[]
			},
			mounted(){
				$('input#periode').datepicker({
					language: 'id',
					minViewMode: 'months',
					format:'mm/yyyy'
				}).on('changeDate',function(e){
					var dt = $(this).datepicker('getDate');
					RP.$data.periode = this.value;
					RP.$data.bulan = dt.getMonth()+1;
					RP.$data.bulan = RP.$data.bulan < 10 ? '0'+ RP.$data.bulan : RP.$data.bulan;
					RP.$data.tahun = dt.getFullYear();
				});
				$("form.report").submit(function(e){
		            e.preventDefault(e);
		        });
			},
			methods:{
				onProcessForm:function(){
					var prxy_url = '<?=site_url('apppayroll/report/payslip')?>';
					this.button_pressed = true;
					this.report_data = [];
					var postData = {
						id_unor : this.id_unor,
						periode : this.periode,
						proses : 'yes',
						empl_stat:this.empl_stat
					};
					var self = this;
					axios.post(prxy_url,postData).then(function (response) {
					    self.report_data = response.data;
					    self.button_pressed = false;
					  })
					  .catch(function (error) {
					    alert(error);
					  });
				},
				onExportPdf: function(){
					var bulan = ['','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
					var nama_bulan = bulan[this.bulan.replace(/^0/,'')];
					var tahun = this.tahun;
					var nama_unor = this.id_unor!=''? this.unor_list[this.id_unor]:'';
					var title = "DAFTAR GAJI PEGAWAI"+(this.empl_stat!=''?' '+this.empl_stat.toUpperCase():"")+" PDAM TIRTA KERTA RAHARJA KABUPATEN TANGERANG\nPERIODE " + nama_bulan + " " + tahun + "\n"+nama_unor;
					PDF.build(this.report_data,title);
				},
				onExportAccnum: function(){
					
					var tahun = this.tahun;

					var prxy_url = '<?php echo site_url('apppayroll/report/payslip');?>';
					// this.button_pressed = true;
					// this.report_data = [];
					var postData = {
						id_unor : this.id_unor,
						periode : this.periode,
						proses : 'yes',
						empl_stat:this.empl_stat,
						accnum: true
					};
					var self = this;
					axios.post(prxy_url,postData, {responseType: 'blob'}).then(function (response) {
						const blob = new Blob([response.data], {type: response.data.type});
						const url = window.URL.createObjectURL(blob);
						const link = document.createElement('a');
						link.href = url;
						const contentDisposition = response.headers['content-disposition'];
						let fileName = 'unknown';
						if (contentDisposition) {
							const fileNameMatch = contentDisposition.match(/filename="(.+)"/);
							if (fileNameMatch.length === 2)
								fileName = fileNameMatch[1];
						}
						link.setAttribute('download', fileName);
						document.body.appendChild(link);
						link.click();
						link.remove();
						window.URL.revokeObjectURL(url);
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