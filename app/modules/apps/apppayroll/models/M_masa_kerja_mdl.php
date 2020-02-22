<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class M_Masa_Kerja_Mdl extends Apppayroll_Frontmdl {
    public $tbl                  = 'm_masa_kerja';
    
    public function fetch_masa_kerja(){
        $this->db->order_by('masa_kerja', 'asc');
        $this->db->where('status', 'aktif');
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
            $result[$val->masa_kerja] = $val->masa_kerja;
        }
        return $result;
    }
}