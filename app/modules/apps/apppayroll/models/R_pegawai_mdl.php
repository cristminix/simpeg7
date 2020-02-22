<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class R_Pegawai_Mdl extends Apppayroll_Frontmdl {
    public $tbl                  = 'r_pegawai';
    
    // public function get_min_tgl_terima_year(){ 
    //     $rw = $this->db->select('g.mk_peringkat')->from($tbl . ' p')
    //              ->join('r_peg_golongan g','left')
    //              ->order_by('g.kode_golongan','desc')
    //              ->order_by('g.mk_peringkat','desc')
    //              ->get()
    //              ->row();
    //     if(!empty($rw)){
    //         return $rw->mk_peringkat;
    //     }
    //     return 0;
    // }
    public function get_min_tgl_terima_year(){
        $this->db->select('min(year(tgl_terima)) maxyear', false);
        $rs = $this->db->get($this->tbl);
        $result = date('Y');
        if(!$rs){
            return $result;
        }
        $res = $rs->row() ;
        if(!$res){
            return $result;
        }
        $result = $res->maxyear;

        return $result;
    }
    
}