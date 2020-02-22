<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Employee_Mdl extends Apppayroll_Frontmdl {

    public $tbl                  = 'r_pegawai rp';
    public $rs_field_list        = array(
        '1' => 'nip_baru',
        'nama_pegawai',
        'kode_golongan',
        'los', // length of service
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_pegawai',
        'status_perkawinan',
        'last_updated',
    );
    public $rs_masked_search_fields = [
        '1'=> 'rp.nip_baru',
         'rkp.nama_pegawai',
         'rpg.kode_golongan',
         'los',
         'rkp.gender',
         'rkp.tempat_lahir',
         'rkp.agama',
         'rkp.status_pegawai',
         'rkp.status_perkawinan',
         'rkp.last_updated',
    ];
    public $rs_masked_field_list = array(
        '1' => 'NIPP',
        'Name',
        'Ranking Code',
        'Length of Service',
        'Gender',
        'Birth Place',
        'Date of birth',
        'Religion',
        'Status',
        'Marital',
        'Last update',
    );
    public $rs_use_form_filter = 'empl_master_data';
    public $rs_select = "rkp.*, rpg.mk_peringkat as `los`,rpg.kode_golongan";
    public $rs_order_by = null;
    public $rs_joins = [
        
        ['rekap_peg rkp','rkp.id_pegawai=rp.id_pegawai','right'],
        ["(
    SELECT
        a.sk_tanggal,
        a.id_pegawai,
        a.kode_golongan,
        a.nama_golongan,
        a.mk_peringkat ,
        a.nama_pangkat
    FROM
        r_peg_golongan a
                
        INNER JOIN (
        SELECT
            id_pegawai,
            count( id_pegawai ) cnt,
            sk_tanggal,
            max( sk_tanggal ) maxsk 
        FROM
            r_peg_golongan 
        WHERE
    
            sk_tanggal <= LAST_DAY(NOW())
            GROUP BY
            id_pegawai 
        ORDER BY
            id_pegawai,
            sk_tanggal DESC 
        ) b ON a.id_pegawai = b.id_pegawai 
        AND a.sk_tanggal = b.maxsk
            AND
             a.sk_tanggal <= LAST_DAY(NOW())
        ORDER BY
        a.id_pegawai,
        a.sk_tanggal DESC 
    ) rpg",'rpg.id_pegawai=rp.id_pegawai','left']


    ];
    public $rs_group_by = "rkp.id_pegawai";

    public $rs_common_views = array(
        /* call_user_func */
        'call_user_func' => array(
            'gender' => array(
                'callable'=>'strtoupper',
                'args' => array()
            ),
            'tempat_lahir' => array(
                'callable'=>'strtoupper',
                'args' => array()
            ),
            'agama' => array(
                'callable'=>'strtoupper',
                'args' => array()
            ),
            'status_pegawai' => array(
                'callable'=>'strtoupper',
                'args' => array()
            ),
            'status_perkawinan' => array(
                'callable'=>'strtoupper',
                'args' => array()
            )
        )
    );
    
    public function fetch_detail($eid) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->db->where('rp.id_pegawai', $eid);
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function filter_result(&$db) {
        if (!property_exists($this, 'rs_search_field')) {
            return;
        }
        if (!property_exists($this, 'rs_search_val')) {
            return;
        }

        $rs_field_list = $this->rs_field_list;
        $prop_name = 'rs_masked_search_fields';
        if(property_exists($this, $prop_name)){
            if($this->{$prop_name}){
                 $rs_field_list = $this->{$prop_name};
            }
        }
        $field = $this->rs_search_field;
        
        if ($field != $this->config->item('ff_all_value')) {
            if (!isset($this->rs_field_list[$field])) {
                return;
            }
        }
        $val = $this->rs_search_val;
        if ($field != $this->config->item('ff_all_value')) {

            $fieldname = $rs_field_list[$field];
            
            if($val === NULL){
                $db->where($fieldname, $val);
            } else {
                $db->like($fieldname, $val);
            }
            
            return;
        }
        
        foreach ($rs_field_list as $fieldname) {
            $db->or_like($fieldname, $val);
        }
    }

}
