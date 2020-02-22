<table class="table table-bordered table-lap" border="1" cellpadding="2px" colspacing="2px">
		<thead>
			<tr>
				<th rowspan="2" class="tc vm">NO</th>
				<th width="40px">NAMA</th>
				<th colspan="5" class="tc">ABSENSI</th>
				<th colspan="4" class="tc">TUNJANGAN - TUNJANGAN</th>
				<th rowspan="2" class="tc vm">GAJI<br/>KOTOR</th>
				<th colspan="4" class="tc">POTONGAN - POTONGAN</th>
				<th rowspan="2" class="tc vm">JUMLAH<br/>POTONGAN</th>
				<th rowspan="2" class="tc vm">GAJI<br/>BERSIH</th>
				<th rowspan="2" class="tc vm">TANDA TANGAN</th>

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
				<th class="tc vt">ASKES<br/>REK. AIR<br/>BPJS PEN.</th>
				<th class="tc vt">ZAKAT<br/>SHDQ</th>

			</tr>
		</thead>
		<tbody>
			<?foreach($report_data as $index => $r):?>
			<tr>
				<td class="tc"><?=$index+1?></td>
				<td class="tl"><?=$r->empl_name.'<br/>'.'-/'.$r->empid.'<br/>'.$r->job_title.'<br/>'.$r->base_sal.' <br/>'.$r->kode_peringkat.' - '. $r->los .' - '.( $r->mar_stat != ('' || 0 ) ? 'Kawin' :'Belum Kawin').' ' . ($r->child_cnt>0?'Anak ' . $r->child_cnt:'')?></td>
				<td class="tc"><?=$r->attn_s?></td>
				<td class="tc"><?=$r->attn_i?></td>
				<td class="tc"><?=$r->attn_a?></td>
				<td class="tc"><?=$r->attn_l?></td>
				<td class="tc"><?=$r->attn_c?></td>


				<td class="tr"><?=$r->alw_mar.'<br/>'.$r->alw_ch.'<br/>'.$r->alw_rc.'<br/>'.$r->alw_wt?></td>
				<td class="tr"><?=$r->alw_jt.'<br/>'.$r->alw_prf.'<br/>'.$r->alw_ot.'<br/>'.$r->alw_adv?></td>
				<td class="tr"><?=$r->alw_rs.'<br/>'.$r->alw_tr.'<br/>'.$r->alw_vhc_rt.'<br/>'.$r->alw_fd?></td>
				<td class="tr"><?=$r->alw_sh.'<br/>'.$r->alw_tpp.'<br/>'.$r->alw_pph21?></td>
				<td class="tr"><?=$r->gross_sal?></td>

				<td class="tr"><?=$r->ddc_pph21.'<br/>'.$r->ddc_bpjs_ket.'<br/>'.$r->ddc_aspen.'<br/>'.$r->ddc_f_kp?></td>
				<td class="tr"><?=$r->ddc_wc.'<br/>'.$r->ddc_wcl.'<br/>'.$r->ddc_dw.'<br/>'.$r->ddc_tpt?></td>
				<td class="tr"><?=$r->ddc_bpjs_kes.'<br/>'.$r->ddc_wb.'<br/>'.$r->ddc_bpjs_pen?></td>
				<td class="tr"><?=$r->ddc_zk.'<br/>'.$r->ddc_shd?></td>
				<td class="tr"><?=$r->ddc_amt?></td>
				<td class="tr"><?=$r->net_pay?></td>
				<td>&nbsp;</td>
			</tr>
			<?endforeach?>
			<?if(count($report_data) == 0):?>
			<tr>
				<td colspan="19">Tidak ada data</td>
			</tr>
			<?endif?>
		</tbody>
	</table>