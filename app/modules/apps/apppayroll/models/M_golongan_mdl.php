<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class M_Golongan_Mdl extends Apppayroll_Frontmdl {
    public $tbl                  = 'm_golongan';
    
    public function fetch_golongan(){
        $this->db->order_by('kode_golongan', 'asc');
        $rs = $this->db->get($this->tbl);
        $result = array();
        if(!$rs){
            return $result;
        }
        $res = $rs->result() ;
        if(!$res){
            return $result;
        }
        foreach($res as $key=> $val){
            $result[$val->kode_golongan] = sprintf('%s - %s',$val->kode_golongan,$val->nama_pangkat);
        }
        return $result;
    }
    
    public function get_nama_pangkat_by_kode_golongan($kode_golongan){
        $this->db->select('nama_pangkat');
        $this->db->where('kode_golongan', $kode_golongan);
        $rs = $this->db->get($this->tbl);
        $result = '';
        if(!$rs){
            return $result;
        }
        $res = $rs->row();
        if(!$res){
            return $result;
        }
        $result = $res->nama_pangkat;
        return $result;
        
    }
}