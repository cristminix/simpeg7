<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class M_Gaji_Pokok_Mdl extends Apppayroll_Frontmdl {

    public $tbl = 'm_gaji_pokok';

    public function add_new_gaji_pokok($kode_golongan, $nama_pangkat, $mk_peringkat, $gaji_pokok, $tahun) {
        $this->db->set('kode_golongan', $kode_golongan);
        $this->db->set('nama_pangkat', $nama_pangkat);
        $this->db->set('mk_peringkat', $mk_peringkat);
        $this->db->set('gaji_pokok', $gaji_pokok);
        $this->db->set('tahun', $tahun);
        $this->db->set('status', 'aktif');
        $this->db->insert($this->tbl);
        $aff = $this->db->affected_rows();
        if (!$aff) {
            return $aff;
        }
        return $this->db->insert_id();
    }

    public function is_duplicated($kode_golongan, $mk_peringkat, $tahun, $not_id = null) {
        $this->db->where('kode_golongan', $kode_golongan);
        $this->db->where('mk_peringkat', $mk_peringkat);
        $this->db->where('tahun', $tahun);
        // $this->db->where('status', 'aktif');
        $this->db->select('COUNT(id_gaji_pokok) cgp', false);
        if ($not_id) {
            $this->db->not_like('id_gaji_pokok', $not_id, 'none');
        }
        $rs     = $this->db->get($this->tbl);
        $result = false;
        if (!$rs) {
            return $result;
        }
        $res = $rs->row();
        if (!$res) {
            return $result;
        }
        $result = (bool) $res->cgp;
        return $result;
    }

    public function update_gaji_pokok($id, $kode_golongan, $nama_pangkat, $mk_peringkat, $gaji_pokok, $tahun) {
        $this->db->set('kode_golongan', $kode_golongan);
        $this->db->set('nama_pangkat', $nama_pangkat);
        $this->db->set('mk_peringkat', $mk_peringkat);
        $this->db->set('gaji_pokok', $gaji_pokok);
        $this->db->set('tahun', $tahun);
        $this->db->set('status', 'aktif');
        $this->db->where('id_gaji_pokok', $id);
        $this->db->update($this->tbl);
        return $this->db->affected_rows();
        
    }
}
