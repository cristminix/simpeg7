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
	<form action="<?php echo site_url('apppayroll/report/payslip_rekap');?>" method="post" class="report">
        
	<div class="row">
		<div class="col-md-8">
			
				<div class="form-group row">
						<label for="pa" class="col-md-2">Periode:</label>
						<div class="col-md-3"><?php echo form_input('periode',$periode,'placeholder="mm/YY" name="periode"class="form-control" id="periode" role="datepicker"');?></div>
						
				</div>
			
			</div>
		<div class="col-md-4">
			
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-6">
			<button :disabled="button_pressed" name="proses"  class="btn btn-info" value="yes" @click="onProcessForm()"><i v-bind:class="{'fa fa-search':!button_pressed,'fa fa-spinner fa-spin':button_pressed}"></i> Proses</button>
			<button v-if="Object.keys(report_data).length>0" name="export_pdf" class="btn btn-warning"  @click="onExportPdf()"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
			
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
								<th rowspan="2" class="tc vm">UNIT KERJA</th>
								<th colspan="5" class="tc">ABSENSI</th>
                                <th rowspan="2" class="tc vm">GAJI<br/>POKOK</th>
								<th colspan="4" class="tc">TUNJANGAN - TUNJANGAN</th>
								<th rowspan="2" class="tc vm">GAJI<br/>KOTOR</th>
								<th colspan="4" class="tc">POTONGAN - POTONGAN</th>
								<th rowspan="2" class="tc vm">JUMLAH<br/>POTONGAN</th>
								<th rowspan="2" class="tc vm">GAJI<br/>BERSIH</th>
								<!-- <th rowspan="2" class="tc vm">TANDA TANGAN</th> -->

							</tr>
							<tr>
								
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
                            <template v-for="(rdata, idx) in report_data">
                                <tr class="strong">
                                    <td colspan="19">{{ idx }}</td>
                                </tr>
                                <tr v-for="(r, index) in rdata">
                                    <td class="tc" v-text="index+1"></td>
                                    <td class="tl" v-html="r.nomenkpada"></td>
                                    <td class="tc" v-text="r.sum_attn_s"></td>
                                    <td class="tc" v-text="r.sum_attn_i"></td>
                                    <td class="tc" v-text="r.sum_attn_a"></td>
                                    <td class="tc" v-text="r.sum_attn_l"></td>
                                    <td class="tc" v-text="r.sum_attn_c"></td>
                                    <td class="tr">
                                        {{ formatPrice(r.sum_base_sal) }} 
                                     </td>
                                    <td class="tr">
                                        {{ formatPrice(r.sum_alw_mar) }} <br/>
                                        {{ formatPrice(r.sum_alw_ch) }} <br/>
                                        {{ formatPrice(r.sum_alw_rc) }} <br/>
                                        {{ formatPrice(r.sum_alw_wt) }}
                                     </td>
                                    <td class="tr">
                                        {{ formatPrice(r.sum_alw_jt) }} <br/>
                                        {{ formatPrice(r.sum_alw_prf) }} <br/>
                                        {{ formatPrice(r.sum_alw_ot) }} <br/>
                                        {{ formatPrice(r.sum_alw_adv) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(r.sum_alw_rs) }} <br/>
                                        {{ formatPrice(r.sum_alw_tr) }} <br/>
                                        {{ formatPrice(r.sum_alw_vhc_rt) }} <br/>
                                        {{ formatPrice(r.sum_alw_fd) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(r.sum_alw_sh) }} <br/>
                                        {{ formatPrice(r.sum_alw_tpp) }} <br/>
                                        {{ formatPrice(r.sum_alw_pph21) }} 
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(r.sum_gross_sal) }} 
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(r.sum_ddc_pph21) }} <br/>
                                        {{ formatPrice(r.sum_ddc_bpjs_ket) }} <br/>
                                        {{ formatPrice(r.sum_ddc_aspen) }} <br/>
                                        {{ formatPrice(r.sum_ddc_f_kp) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(r.sum_ddc_wc) }} <br/>
                                        {{ formatPrice(r.sum_ddc_wcl) }} <br/>
                                        {{ formatPrice(r.sum_ddc_dw) }} <br/>
                                        {{ formatPrice(r.sum_ddc_tpt) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(r.sum_ddc_bpjs_kes) }} <br/>
                                        {{ formatPrice(r.sum_ddc_wb) }} <br/>
                                        {{ formatPrice(r.sum_ddc_bpjs_pen) }} 
                                     </td>
                                     <td class="tr">
                                        
                                        {{ formatPrice(r.sum_ddc_zk) }} <br/>
                                        {{ formatPrice(r.sum_ddc_shd) }} 
                                     </td>
                                    <td class="tr">
                                        {{ formatPrice(r.sum_ddc_amt) }} 
                                     </td>
                                    <td class="tr">
                                        {{ formatPrice(r.sum_net_pay) }} 
                                     </td>
                                    <!-- <td>&nbsp;</td> -->
                                </tr>
                                <tr class="strong">
                                    <td class="tl" colspan="2">JUMLAH TOTAL: {{ idx }}</td>
                                    <td class="tc">{{ totalAttn(rdata, "sum_attn_s") }}</td>
                                    <td class="tc">{{ totalAttn(rdata, "sum_attn_i") }}</td>
                                    <td class="tc">{{ totalAttn(rdata, "sum_attn_a") }}</td>
                                    <td class="tc">{{ totalAttn(rdata, "sum_attn_l") }}</td>
                                    <td class="tc">{{ totalAttn(rdata, "sum_attn_c") }}</td>
                                    <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_base_sal")) }}
                                    </td>
                                    <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_mar")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_ch")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_rc")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_wt")) }}
                                    </td>
                                    <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_jt")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_prf")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_ot")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_adv")) }}
                                    </td>
                                    <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_rs")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_tr")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_vhc_rt")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_fd")) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_sh")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_tpp")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_alw_pph21")) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_gross_sal")) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_pph21")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_bpjs_ket")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_aspen")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_f_kp")) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_wc")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_wcl")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_dw")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_tpt")) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_bpjs_kes")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_wb")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_bpjs_pen")) }}
                                     </td>
                                     <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_zk")) }} <br/>
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_shd")) }}
                                     </td>
                                    <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_ddc_amt")) }}
                                     </td>
                                    <td class="tr">
                                        {{ formatPrice(totalFloat(rdata, "sum_net_pay")) }}
                                     </td>
                                </tr>
                            </template>
                            <tr class="strong" v-show="Object.keys(report_data).length>0">
                                <td class="tl" colspan="2">JUMLAH TOTAL:</td>
                                <td class="tc">{{ totalAllAttn(report_data, "sum_attn_s") }}</td>
                                <td class="tc">{{ totalAllAttn(report_data, "sum_attn_i") }}</td>
                                <td class="tc">{{ totalAllAttn(report_data, "sum_attn_a") }}</td>
                                <td class="tc">{{ totalAllAttn(report_data, "sum_attn_l") }}</td>
                                <td class="tc">{{ totalAllAttn(report_data, "sum_attn_c") }}</td>
                                <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_base_sal")) }}
                                </td>
                                <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_mar")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_ch")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_rc")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_wt")) }}
                                </td>
                                <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_jt")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_prf")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_ot")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_adv")) }}
                                </td>
                                <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_rs")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_tr")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_vhc_rt")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_fd")) }}
                                    </td>
                                    <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_sh")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_tpp")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_alw_pph21")) }}
                                    </td>
                                    <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_gross_sal")) }}
                                    </td>
                                    <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_pph21")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_bpjs_ket")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_aspen")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_f_kp")) }}
                                    </td>
                                    <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_wc")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_wcl")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_dw")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_tpt")) }}
                                    </td>
                                    <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_bpjs_kes")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_wb")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_bpjs_pen")) }}
                                    </td>
                                    <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_zk")) }} <br/>
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_shd")) }}
                                    </td>
                                <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_ddc_amt")) }}
                                    </td>
                                <td class="tr">
                                    {{ formatPrice(totalAllFloat(report_data, "sum_net_pay")) }}
                                    </td>
                            </tr>
                            
                                
                            
							<tr v-show="Object.keys(report_data).length <= 0">
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
    table tr.strong td {
        font-weight: bold;
    }
</style>
<script type="text/javascript">
    function formatPrice(value) {
        value = value ? value : 0;
        let val = (value/1).toFixed(2).replace('.', ',');
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    function arrayFormatPrice(arr) {
        for(let i = 0; i < arr.length; i++){

            arr[i] = formatPrice(arr[i]);

        }
        return arr;
    }

    var PDF = {
		build:function(report_data,title, printed_date) {
			var b = [true, true, true, true];
			var fc = '#fff';
			var fb = '#ddd';
			var fx = '#fed';
			var headerTitle = title;
			var dd = {
				header: function(currentPage, pageCount) {
                    var columnText = [
                        
                    ];
                    columnText.push( "Halaman: " + currentPage + " - " + pageCount); 
                    return [
                        {
                            text: headerTitle, 
                            style: {
                                fontSize:10,
                                alignment:'center',
                                bold:true
                            },
                            margin:[0,30,0,0]
                        },
                        { 
                            text: columnText[0], 
                            alignment: 'left', 
                            margin: [35,3,0,0],  
                            style:{ fontSize: 7} 
                        }
                    ]; 
                },
                pageMargins: [35,80,35,30],
				pageSize: 'LEGAL',
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
					footer: {
						fontSize: 10,
                        border: [false,false,false,false],
						alignment:'center'
					},
				},
				content:[
					
					{
						style: 'default',
						table: {
							widths: [ 'auto','*','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','auto','*'],
							headerRows: 2,
                            keepWithHeaderRows: 1,
							dontBreakRows: true, 
							body: [
									[
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: "NO", 
                                            rowSpan:2 ,
                                            margin:[3,16,3,3]
                                        }, 
									    {
                                            border: b,
                                            fillColor: fb, 
                                            rowSpan:2,
                                            text: 'UNIT KERJA',
                                            margin:[3,16,3,3]
                                        },
									    {
                                            border: b, 
                                            fillColor: fb, 
                                            text: 'ABSENSI', 
                                            colSpan:5 ,margin:[3,3,3,3]
                                        },
                                        '',
                                        '',
                                        '',
                                        '',
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: "GAJI\nPOKOK", 
                                            rowSpan:2 ,
                                            margin:[3,16,3,3]
                                        },
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: 'TUNJANGAN - TUNJANGAN', 
                                            colSpan:4,
                                            margin:[3,3,3,3]
                                        }, 
                                        '',
                                        '',
                                        '',
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: "GAJI\nKOTOR", 
                                            rowSpan:2,
                                            margin:[3,16,3,3]
                                        },
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: 'POTONGAN - POTONGAN', 
                                            colSpan:4 ,margin:[3,3,3,3]
                                        },
                                        '',
                                        '',
                                        '',
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: "JUMLAH\nPOTONGAN", 
                                            rowSpan:2,margin:[3,16,3,3] 
                                        },
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: "GAJI\nBERSIH", 
                                            rowSpan:2,
                                            margin:[3,16,3,3]
                                        },
                                        {
                                            border: b, 
                                            fillColor: fb, 
                                            text: "TANDA TANGAN", 
                                            rowSpan:2,
                                            margin:[3,16,3,3]
                                        } 
									],
									[
                                        '',
                                        {
                                            border: [false,false,false,false], 
                                            fillColor: fb,
                                            margin:[3,3,3,3], 
                                            text: "",
                                            style:'tl'
                                        },
                                        {
                                            border: b,
                                            margin:[3,3,3,3],
                                            fillColor: fb, 
                                            text: 'S'
                                        }, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: 'I'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: 'A'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: 'L'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: 'C'}, 
                                     {border: [false,false,false,false], fillColor: fb,margin:[3,3,3,3] , text: "",style:'tl'}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "ISTRI\nANAK\nBERAS\nAIR"       }, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "JABATAN\nPRESTASI\nLEMBUR\nKHUSUS"}, 
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "PERUMAHAN\nTRANSPORT\nKENDARAAN\nMAKAN"},
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "SHIFT\nTPP\nPPH21\n"}, 
									 '',                                            
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "PPH21\nASTEK\nASPEN\nFKP"    }, 
									 {border: b ,margin:[3,3,3,3]  , fillColor: fb, text: "KOPERASI\nKOP.WAJIB\nD.WANITA\nTPTGR"},
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "ASKES\nREK.AIR\nBPJS.PEN"},
									 {border: b,margin:[3,3,3,3],  fillColor: fb, text: "ZAKAT\nSHDQ"},
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
            var tAttn = [0,0,0,0,0];
            var tSumx = [0,0,0,0];
            var ta7 = [0,0,0,0];
            var ta8 = [0,0,0,0];
            var ta9 = [0,0,0,0];
            var ta10 = [0,0,0];
            var ta12 = [0,0,0,0];
            var ta13 = [0,0,0,0];
            var ta14 = [0,0,0];
            var ta15 = [0,0];
			$.each(report_data,function(idata,rdata){
                var row = [
                    {
                        border: b, 
                        fillColor: fc, 
                        text: idata, 
                        colSpan:20 ,
                        margin:[3,3,3,3],
                        style: 'tl'
                    }
                ];
                dd.content[0].table.body.push(row);
                var totalAttnS = 0;
                var totalAttnI = 0;
                var totalAttnA = 0;
                var totalAttnL = 0;
                var totalAttnC = 0;
                var totalBaseSal = 0;
                var totalGrossSal = 0;
                var totalDdcAmt = 0;
                var totalNetPay = 0;
                var a7 = [0,0,0,0];
                var a8 = [0,0,0,0];
                var a9 = [0,0,0,0];
                var a10 = [0,0,0];
                var a12 = [0,0,0,0];
                var a13 = [0,0,0,0];
                var a14 = [0,0,0];
                var a15 = [0,0];
                $.each(rdata,function(i,r){
				var no = i+1;
				var _1ColText = r.nomenkpada;
				var _7ColText = formatPrice(r.sum_alw_mar)+"\n"+formatPrice(r.sum_alw_ch)+"\n"+formatPrice(r.sum_alw_rc)+"\n"+formatPrice(r.sum_alw_wt);
                a7[0] += parseFloat(r.sum_alw_mar ? r.sum_alw_mar: 0);
                a7[1] += parseFloat(r.sum_alw_ch ? r.sum_alw_ch: 0);
                a7[2] += parseFloat(r.sum_alw_rc ? r.sum_alw_rc: 0);
                a7[3] += parseFloat(r.sum_alw_wt ? r.sum_alw_wt: 0);
                ta7[0] += parseFloat(r.sum_alw_mar ? r.sum_alw_mar: 0);
                ta7[1] += parseFloat(r.sum_alw_ch ? r.sum_alw_ch: 0);
                ta7[2] += parseFloat(r.sum_alw_rc ? r.sum_alw_rc: 0);
                ta7[3] += parseFloat(r.sum_alw_wt ? r.sum_alw_wt: 0);
				var _8ColText = formatPrice(r.sum_alw_jt)+"\n"+formatPrice(r.sum_alw_prf)+"\n"+formatPrice(r.sum_alw_ot)+"\n"+formatPrice(r.sum_alw_adv);
                a8[0] += parseFloat(r.sum_alw_jt ? r.sum_alw_jt: 0);
                a8[1] += parseFloat(r.sum_alw_prf ? r.sum_alw_prf: 0);
                a8[2] += parseFloat(r.sum_alw_ot ? r.sum_alw_ot: 0);
                a8[3] += parseFloat(r.sum_alw_adv ? r.sum_alw_adv: 0);
                ta8[0] += parseFloat(r.sum_alw_jt ? r.sum_alw_jt: 0);
                ta8[1] += parseFloat(r.sum_alw_prf ? r.sum_alw_prf: 0);
                ta8[2] += parseFloat(r.sum_alw_ot ? r.sum_alw_ot: 0);
                ta8[3] += parseFloat(r.sum_alw_adv ? r.sum_alw_adv: 0);

				var _9ColText = formatPrice(r.sum_alw_rs)+"\n"+formatPrice(r.sum_alw_tr)+"\n"+formatPrice(r.sum_alw_vhc_rt)+"\n"+formatPrice(r.sum_alw_fd);
                a9[0] += parseFloat(r.sum_alw_rs ? r.sum_alw_rs: 0);
                a9[1] += parseFloat(r.sum_alw_tr ? r.sum_alw_tr: 0);
                a9[2] += parseFloat(r.sum_alw_vhc_rt ? r.sum_alw_vhc_rt: 0);
                a9[3] += parseFloat(r.sum_alw_fd ? r.sum_alw_fd: 0);
                ta9[0] += parseFloat(r.sum_alw_rs ? r.sum_alw_rs: 0);
                ta9[1] += parseFloat(r.sum_alw_tr ? r.sum_alw_tr: 0);
                ta9[2] += parseFloat(r.sum_alw_vhc_rt ? r.sum_alw_vhc_rt: 0);
                ta9[3] += parseFloat(r.sum_alw_fd ? r.sum_alw_fd: 0);

				var _10ColText = formatPrice(r.sum_alw_sh)+"\n"+formatPrice(r.sum_alw_tpp)+"\n"+formatPrice(r.sum_alw_pph21);
                a10[0] += parseFloat(r.sum_alw_sh ? r.sum_alw_sh: 0);
                a10[1] += parseFloat(r.sum_alw_tpp ? r.sum_alw_tpp: 0);
                a10[2] += parseFloat(r.sum_alw_pph21 ? r.sum_alw_pph21: 0);
                ta10[0] += parseFloat(r.sum_alw_sh ? r.sum_alw_sh: 0);
                ta10[1] += parseFloat(r.sum_alw_tpp ? r.sum_alw_tpp: 0);
                ta10[2] += parseFloat(r.sum_alw_pph21 ? r.sum_alw_pph21: 0);

				var _12ColText = formatPrice(r.sum_ddc_pph21)+"\n"+formatPrice(r.sum_ddc_bpjs_ket)+"\n"+formatPrice(r.sum_ddc_aspen)+"\n"+formatPrice(r.sum_ddc_f_kp);
                a12[0] += parseFloat(r.sum_ddc_pph21 ? r.sum_ddc_pph21: 0);
                a12[1] += parseFloat(r.sum_ddc_bpjs_ket ? r.sum_ddc_bpjs_ket: 0);
                a12[2] += parseFloat(r.sum_ddc_aspen ? r.sum_ddc_aspen: 0);
                a12[3] += parseFloat(r.sum_ddc_f_kp ? r.sum_ddc_f_kp: 0);
                ta12[0] += parseFloat(r.sum_ddc_pph21 ? r.sum_ddc_pph21: 0);
                ta12[1] += parseFloat(r.sum_ddc_bpjs_ket ? r.sum_ddc_bpjs_ket: 0);
                ta12[2] += parseFloat(r.sum_ddc_aspen ? r.sum_ddc_aspen: 0);
                ta12[3] += parseFloat(r.sum_ddc_f_kp ? r.sum_ddc_f_kp: 0);

				var _13ColText = formatPrice(r.sum_ddc_wc)+"\n"+formatPrice(r.sum_ddc_wcl)+"\n"+formatPrice(r.sum_ddc_dw)+"\n"+formatPrice(r.sum_ddc_tpt) ;
                a13[0] += parseFloat(r.sum_ddc_wc ? r.sum_ddc_wc: 0);
                a13[1] += parseFloat(r.sum_ddc_wcl ? r.sum_ddc_wcl: 0);
                a13[2] += parseFloat(r.sum_ddc_dw ? r.sum_ddc_dw: 0);
                a13[3] += parseFloat(r.sum_ddc_tpt ? r.sum_ddc_tpt: 0);
                ta13[0] += parseFloat(r.sum_ddc_wc ? r.sum_ddc_wc: 0);
                ta13[1] += parseFloat(r.sum_ddc_wcl ? r.sum_ddc_wcl: 0);
                ta13[2] += parseFloat(r.sum_ddc_dw ? r.sum_ddc_dw: 0);
                ta13[3] += parseFloat(r.sum_ddc_tpt ? r.sum_ddc_tpt: 0);

				var _14ColText = formatPrice(r.sum_ddc_bpjs_kes)+"\n"+formatPrice(r.sum_ddc_wb)+"\n"+formatPrice(r.sum_ddc_bpjs_pen);
                a14[0] += parseFloat(r.sum_ddc_bpjs_kes ? r.sum_ddc_bpjs_kes: 0);
                a14[1] += parseFloat(r.sum_ddc_wb ? r.sum_ddc_wb: 0);
                a14[2] += parseFloat(r.sum_ddc_bpjs_pen ? r.sum_ddc_bpjs_pen: 0);
                ta14[0] += parseFloat(r.sum_ddc_bpjs_kes ? r.sum_ddc_bpjs_kes: 0);
                ta14[1] += parseFloat(r.sum_ddc_wb ? r.sum_ddc_wb: 0);
                ta14[2] += parseFloat(r.sum_ddc_bpjs_pen ? r.sum_ddc_bpjs_pen: 0);

				var _15ColText = formatPrice(r.sum_ddc_zk)+"\n"+formatPrice(r.sum_ddc_shd);
                a15[0] += parseFloat(r.sum_ddc_zk ? r.sum_ddc_zk: 0);
                a15[1] += parseFloat(r.sum_ddc_shd ? r.sum_ddc_shd: 0);
                ta15[0] += parseFloat(r.sum_ddc_zk ? r.sum_ddc_zk: 0);
                ta15[1] += parseFloat(r.sum_ddc_shd ? r.sum_ddc_shd: 0);

                var _base_sal = formatPrice(r.sum_base_sal);
                var _gross_sal = formatPrice(r.sum_gross_sal);
                var _ddc_amt = formatPrice(r.sum_ddc_amt);
                var _net_pay = formatPrice(r.sum_net_pay);

				totalAttnS += parseInt(r.sum_attn_s);
                totalAttnI += parseInt(r.sum_attn_i);
                totalAttnA += parseInt(r.sum_attn_a);
                totalAttnL += parseInt(r.sum_attn_l);
                totalAttnC += parseInt(r.sum_attn_c);
                totalBaseSal += parseFloat(r.sum_base_sal);
                totalGrossSal += parseFloat(r.sum_gross_sal);
                totalDdcAmt += parseFloat(r.sum_ddc_amt);
                totalNetPay += parseFloat(r.sum_net_pay);
                tSumx[0] += parseFloat(r.sum_base_sal);
                tSumx[1] += parseFloat(r.sum_gross_sal);
                tSumx[2] += parseFloat(r.sum_ddc_amt);
                tSumx[3] += parseFloat(r.sum_net_pay);
				var row = [
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: no }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _1ColText, style: 'tl' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.sum_attn_s }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.sum_attn_i }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.sum_attn_a }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.sum_attn_l }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: r.sum_attn_c }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _base_sal, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _7ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _8ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _9ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _10ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _gross_sal, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _12ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _13ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _14ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _15ColText, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _ddc_amt, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: _net_pay, style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fc, text: '', style: 'tr' }
					 
				];

				dd.content[0].table.body.push(row);
                
			});
            tAttn[0] += totalAttnS;
            tAttn[1] += totalAttnI;
            tAttn[2] += totalAttnA;
            tAttn[3] += totalAttnL;
            tAttn[4] += totalAttnC;
            a7 = arrayFormatPrice(a7);
            a8 = arrayFormatPrice(a8);
            a9 = arrayFormatPrice(a9);
            a10 = arrayFormatPrice(a10);
            a12 = arrayFormatPrice(a12);
            a13 = arrayFormatPrice(a13);
            a14 = arrayFormatPrice(a14);
            a15 = arrayFormatPrice(a15);
            var row = [
					
					{border: b,margin:[3,3,3,3],colSpan:2,  fillColor: fb, text: 'JUMLAH TOTAL: '+ idata, style: 'tl' }, 
                    {border: b,margin:[3,3,3,3],  fillColor: fb, text: '', style: 'tr' },
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: totalAttnS }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: totalAttnI }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: totalAttnA }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: totalAttnL }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: totalAttnC }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: formatPrice(totalBaseSal), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a7.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a8.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a9.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a10.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: formatPrice(totalGrossSal), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a12.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a13.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a14.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: a15.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: formatPrice(totalDdcAmt), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: formatPrice(totalNetPay), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fb, text: '', style: 'tr' }
					 
				];

				dd.content[0].table.body.push(row);
            });
            ta7 = arrayFormatPrice(ta7);
            ta8 = arrayFormatPrice(ta8);
            ta9 = arrayFormatPrice(ta9);
            ta10 = arrayFormatPrice(ta10);
            ta12 = arrayFormatPrice(ta12);
            ta13 = arrayFormatPrice(ta13);
            ta14 = arrayFormatPrice(ta14);
            ta15 = arrayFormatPrice(ta15);
            var row = [
					
					{border: b,margin:[3,3,3,3],colSpan:2,  fillColor: fx, text: 'JUMLAH TOTAL: ', style: 'tl' }, 
                    {border: b,margin:[3,3,3,3],  fillColor: fx, text: '', style: 'tr' },
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: tAttn[0] }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: tAttn[1] }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: tAttn[2] }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: tAttn[3] }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: tAttn[4] }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: formatPrice(tSumx[0]), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta7.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta8.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta9.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta10.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: formatPrice(tSumx[1]), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta12.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta13.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta14.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: ta15.join("\n"), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: formatPrice(tSumx[2]), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: formatPrice(tSumx[3]), style: 'tr' }, 
					{border: b,margin:[3,3,3,3],  fillColor: fx, text: '', style: 'tr' }
					 
				];

				dd.content[0].table.body.push(row);
            var foot = [
                {
                    margin: [10,10,10,0],
                    colSpan:8,  
                    fillColor: fc, 
                    text: 'MENGETAHUI/MENYETUJUI', 
                    style: 'footer' 
                },
                '','','','','','','','','','','','','','','','',
                {
                    margin: [10,10,10,0],
                    colSpan:3,  
                    fillColor: fc, 
                    text: 'TANGERANG, ' + printed_date, 
                    style: 'footer' 
                },
                '',''
            ];
            dd.content[0].table.body.push(foot);
            var foot = [
                '',
                '','','',
                '',
                '','','','','','','','','','','','',
                {
                    margin: [10,1,10,0],
                    colSpan:3,  
                    fillColor: fc, 
                    text: 'DIPERIKSA OLEH', 
                    style: 'footer' 
                },
                '',''
            ];
            dd.content[0].table.body.push(foot);
            var foot = [
                {
                    margin: [10,1,10,0],
                    colSpan:4,  
                    fillColor: fc, 
                    text: 'DIREKTUR UTAMA', 
                    style: 'footer' 
                },
                '','','',
                {
                    margin: [10,1,10,0],
                    colSpan:4,  
                    fillColor: fc, 
                    text: 'DIREKTUR UMUM', 
                    style: 'footer' 
                },
                '','','','','','','','','','','','',
                {
                    margin: [10,1,10,0],
                    colSpan:3,  
                    fillColor: fc, 
                    text: 'KEPALA BAGIAN KEPEGAWAIAN', 
                    style: 'footer' 
                },
                '',''
            ];
            dd.content[0].table.body.push(foot);
            var foot = [
                {
                    margin: [10,60,10,3],
                    colSpan:4,  
                    fillColor: fc, 
                    text: 'RUSDY MACHMUD', 
                    style: 'footer' 
                },
                '','','',
                {
                    margin: [10,60,10,3],
                    colSpan:4,  
                    fillColor: fc, 
                    text: 'SOFYAN SAPAR', 
                    style: 'footer' 
                },
                '','','','','','','','','','','','',
                {
                    margin: [10,60,10,3],
                    colSpan:3,  
                    fillColor: fc, 
                    text: 'SUPARLAN', 
                    style: 'footer' 
                },
                '',''
            ];
            dd.content[0].table.body.push(foot);
			pdfMake.createPdf(dd).open();
			
		}
    };
    var RP={};
	$(document).ready(function(){
		$('.main > h3').html('REKAPITULASI GAJI PEGAWAI');		
		RP = new Vue({
			el:'#app',
			data : {
				
				periode : '<?php echo $periode;?>',
				bulan : '<?php echo $bulan;?>',
				tahun : '<?php echo $tahun;?>',
				button_pressed: <?php echo $button_pressed ? 'true' : 'false'; ?>,
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
                formatPrice(value) {
                    let val = (value/1).toFixed(2).replace('.', ',')
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                },
                totalAttn: function (values, v) {
                    return values.reduce((acc, val) => {
                        return acc + parseInt(val[v] ? val[v] : 0 );
                    }, 0);    
                },
                totalAllAttn: function (values, v) {
                    return Object.keys(values).reduce((acc, key) => {
                        return acc + this.totalAttn(values[key], v);
                    }, 0);        
                },
                totalFloat: function (values, v) {
                    return values.reduce((acc, val) => {
                        
                        return acc + parseFloat(val[v] ? val[v] : 0 );
                    }, 0);    
                },
                totalAllFloat: function (values, v) {
                    return Object.keys(values).reduce((acc, key) => {
                        return acc + this.totalFloat(values[key], v);
                    }, 0);    
                },
				onProcessForm:function(){
					var prxy_url = '<?php echo site_url('apppayroll/report/payslip_rekap');?>';
					this.button_pressed = true;
					this.report_data = [];
					var postData = {
						periode : this.periode,
						proses : 'yes'
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
					var title = "REKAPITULASI GAJI PEGAWAI"+" PDAM TIRTA KERTA RAHARJA KABUPATEN TANGERANG\nPERIODE " + nama_bulan + " " + tahun + "\n";
					PDF.build(this.report_data,title, '<?php echo date('j'); ?> '+ nama_bulan + ' ' + tahun);
				}
			}
		});
		//

	});
</script>