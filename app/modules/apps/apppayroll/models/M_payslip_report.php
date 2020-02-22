<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// require_once 'apppayroll_frontmdl' . EXT;


class M_payslip_report extends  CI_Model
{
	public $report_tbl = 'apr_sv_payslip';
	public function get_report_data($bulan,$tahun,$id_unor,$empl_stat)
	{
		$lastdate  = date('t', strtotime("{$tahun}-{$bulan}-01"));
		$print_dt = "{$tahun}-{$bulan}-{$lastdate}"; 
		if(!empty($id_unor)){
			$this->db->like('p.kode_unor',$id_unor);

		}
		if(!empty($empl_stat)){
			$this->db->where('p.empl_stat',$empl_stat);

		}

		$result = $this->db->select('p.*')
						   ->where('p.print_dt',$print_dt)
						   // ->join('m_unor u','u.id_unor = p.id_unor','left')
						   ->order_by('p.empl_name','asc')->get($this->report_tbl . ' p')

					 ->result();
		$fmt_num_kys = [
			'base_sal','gross_sal','net_pay',
			'alw_mar','alw_ch','alw_rc','alw_rs','alw_tr','alw_fd','alw_adv','alw_wt',
			'alw_jt','alw_ot','alw_prf','alw_sh','alw_vhc_rt','alw_tpp','alw_pph21',
			'alw_amt','ddc_amt',
			'ddc_pph21','ddc_bpjs_ket','ddc_bpjs_kes','ddc_aspen', 'ddc_bpjs_pen','ddc_wb','ddc_f_kp','ddc_wc','ddc_wcl',
			'ddc_dw','ddc_zk','ddc_shd','ddc_tpt',
		];			 
		foreach ($result as &$r) {
			 $r->empid = substr($r->nipp, -4);
			 $r->float_netpay = $r->net_pay;
		 	foreach ($fmt_num_kys as $prop) {
				 
		 		$r->{$prop} = $r->{$prop} + 0;
		 		$r->{$prop} = number_format($r->{$prop}, 0, ",", ".");
		 	}
		 }			 
		return $result;
	}
	public function get_unor_list()
	{
		$rs = $this->db->select('kode_unor,nama_unor')
				 ->where('LENGTH(kode_unor) = 5',null,false)
				 ->get('m_unor')
				 ->result();
		$result = [];
		
		foreach ($rs as $u) {
	 		$result[$u->kode_unor]=$u->nama_unor;
	    }
	    return $result;		 
	}

	public function get_report_data_recap($bulan,$tahun)
	{
		$result = [];
		$lastdate  = date('t', strtotime("{$tahun}-{$bulan}-01"));
		$print_dt = "{$tahun}-{$bulan}-{$lastdate}"; 
		$tbl = $this->report_tbl;
		
		$where = ["PUSAT" => " WHERE `p`.`print_dt` = '{$print_dt}'
		AND `un`.`nama_unor` NOT LIKE '%Cabang%'
		AND `un`.`nama_unor` NOT LIKE '%Wilayah%'
		AND `un`.`nama_unor` NOT LIKE '%IKK %' ", 
		"WILAYAH/CABANG/IKK" => 
		" WHERE `p`.`print_dt` = '{$print_dt}' AND (
		`un`.`nama_unor` LIKE '%Cabang%'
		OR `un`.`nama_unor` LIKE '%Wilayah%'
		OR `un`.`nama_unor` LIKE '%IKK %' ) " 
	];
		foreach($where as $i => $w ) {
			$sql = <<<SQL
			SELECT `p`.*, 
				SUM(`p`.`attn_s`) `sum_attn_s`, 
				SUM(`p`.`attn_i`) `sum_attn_i`, 
				SUM(`p`.`attn_a`) `sum_attn_a`, 
				SUM(`p`.`attn_l`) `sum_attn_l`, 
				SUM(`p`.`attn_c`) `sum_attn_c`, 

				SUM(`p`.`base_sal`) `sum_base_sal`, 

				SUM(`p`.`alw_mar`) `sum_alw_mar`, 
				SUM(`p`.`alw_ch`) `sum_alw_ch`, 
				SUM(`p`.`alw_rc`) `sum_alw_rc`, 
				SUM(`p`.`alw_wt`) `sum_alw_wt`, 

				SUM(`p`.`alw_jt`) `sum_alw_jt`, 
				SUM(`p`.`alw_prf`) `sum_alw_prf`, 
				SUM(`p`.`alw_ot`) `sum_alw_ot`, 
				SUM(`p`.`alw_adv`) `sum_alw_adv`, 

				/* r.alw_rs+'<br/>'+r.alw_tr+'<br/>'+r.alw_vhc_rt+'<br/>'+r.alw_fd */

				SUM(`p`.`alw_rs`) `sum_alw_rs`, 
				SUM(`p`.`alw_tr`) `sum_alw_tr`, 
				SUM(`p`.`alw_vhc_rt`) `sum_alw_vhc_rt`, 
				SUM(`p`.`alw_fd`) `sum_alw_fd`, 

				/*r.alw_sh+'<br/>'+r.alw_tpp+'<br/>'+r.alw_pph21*/

				SUM(`p`.`alw_sh`) `sum_alw_sh`, 
				SUM(`p`.`alw_tpp`) `sum_alw_tpp`, 
				SUM(`p`.`alw_pph21`) `sum_alw_pph21`, 

				SUM(`p`.`gross_sal`) `sum_gross_sal`, 

				/*r.ddc_pph21+'<br/>'+r.ddc_bpjs_ket+'<br/>'+r.ddc_aspen+'<br/>'+r.ddc_f_kp*/
				SUM(`p`.`ddc_pph21`) `sum_ddc_pph21`, 
				SUM(`p`.`ddc_bpjs_ket`) `sum_ddc_bpjs_ket`, 
				SUM(`p`.`ddc_aspen`) `sum_ddc_aspen`, 
				SUM(`p`.`ddc_f_kp`) `sum_ddc_f_kp`, 
				/*r.ddc_wc+'<br/>'+r.ddc_wcl+'<br/>'+r.ddc_dw+'<br/>'+r.ddc_tpt*/
				SUM(`p`.`ddc_wc`) `sum_ddc_wc`, 
				SUM(`p`.`ddc_wcl`) `sum_ddc_wcl`, 
				SUM(`p`.`ddc_dw`) `sum_ddc_dw`, 
				SUM(`p`.`ddc_tpt`) `sum_ddc_tpt`, 
				/*r.ddc_bpjs_kes+'<br/>'+r.ddc_wb+'<br/>'+r.ddc_bpjs_pen*/
				SUM(`p`.`ddc_bpjs_pen`) `sum_ddc_bpjs_pen`, 
				SUM(`p`.`ddc_bpjs_kes`) `sum_ddc_bpjs_kes`, 
				SUM(`p`.`ddc_wb`) `sum_ddc_wb`, 
				/*r.ddc_zk+'<br/>'+r.ddc_shd*/

				SUM(`p`.`ddc_zk`) `sum_ddc_zk`, 
				SUM(`p`.`ddc_shd`) `sum_ddc_shd`, 

				SUM(`p`.`ddc_amt`) `sum_ddc_amt`, 
				SUM(`p`.`net_pay`) `sum_net_pay`, 
				`un`.`nama_unor` `nomenkpada` 
			FROM `{$tbl}` `p`
			LEFT JOIN `m_unor` `un`
				ON `un`.`kode_unor` = LEFT(`p`.`kode_unor`, 5)
			{$w}
			GROUP BY `un`.`nama_unor`
			ORDER BY `un`.`kode_unor` ASC

SQL;
			
			$result[$i] = $this->db->query($sql)
			->result();
		}
	
		return $result;
	}
}