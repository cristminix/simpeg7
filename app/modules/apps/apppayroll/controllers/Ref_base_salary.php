<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Ref_Base_Salary extends Apppayroll_Frontctl {

    public $gaji_pokok_mdl = "m_gaji_pokok_mdl";
    public $golongan_mdl   = "m_golongan_mdl";
    public $main_mdl       = "ref_base_salary_mdl";
    public $masa_kerja_mdl = "m_masa_kerja_mdl";
    public $r_peg_mdl      = "r_pegawai_mdl";

    protected function _do_add_new($mdl) {
        $tpl   = 'add_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_post($mdl, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_form_input = array(
            'back_url' => $back_url
        );
        $this->set_page_title(lang("Base Salary") . ': ' . lang('Add new'));

        if (!$post) {
            $data = compact('rs_form_input');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'id_gaji_pokok',
            'kode_golongan',
            'mk_peringkat',
            'gaji_pokok',
            'tahun',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                 = md5($item);
            $rs_form_input[$md5] = array();
            if (isset($post['data'][$md5])) {
                $rs_form_input[$md5]['value'] = $post['data'][$md5];
            }
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Base Salary") . ': ' . lang('Add new'));
        return $this->print_page($tpl);
    }

    protected function _do_add_post($mdl, $input) {
        $error         = array();
        $flash_message = array();
        if (!$input) {
            return $error;
        }

        extract($input);

        $kode_golongan = filter_var($data[md5('kode_golongan')], FILTER_SANITIZE_NUMBER_INT);
        if (!$kode_golongan) {
            $error['kode_golongan'] = lang('required');
        }

        $mk_peringkat = filter_var($data[md5('mk_peringkat')], FILTER_SANITIZE_STRING);
        if (!$mk_peringkat) {
            if ($mk_peringkat !== '0') {
                $error['mk_peringkat'] = lang('required');
            }
        }

        $gaji_pokok = filter_var($data[md5('gaji_pokok')], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (!$gaji_pokok) {
            $error['gaji_pokok'] = lang('invalid value');
        }
        $tahun = filter_var($data[md5('tahun')], FILTER_SANITIZE_NUMBER_INT);
        if (!$tahun) {
            $error['tahun'] = lang('invalid year');
        }
        if (!$error) {
            $gaji_pokok_mdl = $this->gaji_pokok_mdl;
            $this->load->model($gaji_pokok_mdl);
            $duplicated     = $this->{$gaji_pokok_mdl}->is_duplicated($kode_golongan, $mk_peringkat, $tahun);
            if ($duplicated) {
                $error['kode_golongan'] = lang('duplicated');
                $error['mk_peringkat']    = lang('duplicated');
                $error['tahun']         = lang('duplicated');
            }
        }
        if (!$error) {
            $nama_pangkat = $this->{$this->golongan_mdl}->get_nama_pangkat_by_kode_golongan($kode_golongan);
            $do_add       = $this->{$gaji_pokok_mdl}->add_new_gaji_pokok($kode_golongan, $nama_pangkat, $mk_peringkat, $gaji_pokok, $tahun);
            if ($do_add) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $do_add));
            }
            $error = array(true);
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_del($mdl, $id) {
        $tpl    = 'del_detail';
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url = $this->session->userdata(md5(__FILE__ . 'back'));
        $post     = $this->input->post();
        if ($post) {
            $flash_message = $this->_do_del_post($mdl, $id, $post);
            if ($flash_message) {

                $this->session->set_userdata('flash_message', $flash_message);
//                return $error;
            }
            redirect($back_url);
        }

        $data = compact('back_url', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("Base Salary") . ' : ' . lang('Delete Confirmation'));
        return $this->print_page($tpl);
    }

    protected function _do_del_post($mdl, $id, $input) {

        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Delete error');
            return $flash_message;
        }
        $ymd    = date('ymd');
        $del_id = filter_var($input[md5('del_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($del_id != $id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }
        $del_id_hash = filter_var($input[md5('del_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($del_id . $ymd) != $del_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }

        return $this->{$mdl}->delete_row_by_id($del_id);
    }

    protected function _do_edit($mdl, $id) {
        $tpl   = 'edit_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id_gaji_pokok',
            'kode_golongan',
            'mk_peringkat',
            'gaji_pokok',
            'tahun',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                 = md5($item);
            $rs_form_input[md5($item)] = array(
                'value' => $detail->{$item}
            );
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Base Salary") . ': ' . sprintf('%s / %s / %s - %s ', $detail->tahun, $detail->mk_peringkat, $detail->kode_golongan, $detail->nama_pangkat));
        return $this->print_page($tpl);
    }

    protected function _do_edit_post($mdl, $id, $input) {

        $error         = array();
        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        extract($input);
        $ymd     = date('ymd');
        $edit_id = filter_var($data[md5('edit_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($edit_id != $id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $edit_id_hash = filter_var($data[md5('edit_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($edit_id . $ymd) != $edit_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        $error         = array();
        $kode_golongan = filter_var($data[md5('kode_golongan')], FILTER_SANITIZE_NUMBER_INT);
        if (!$kode_golongan) {
            $error['kode_golongan'] = lang('required');
        }

        $mk_peringkat = filter_var($data[md5('mk_peringkat')], FILTER_SANITIZE_STRING);
        if (!$mk_peringkat) {
            if ($mk_peringkat !== '0') {
                $error['mk_peringkat'] = lang('required');
            }
        }

        $gaji_pokok = filter_var($data[md5('gaji_pokok')], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (!$gaji_pokok) {
            $error['gaji_pokok'] = lang('invalid value');
        }
        $tahun = filter_var($data[md5('tahun')], FILTER_SANITIZE_NUMBER_INT);
        if (!$tahun) {
            $error['tahun'] = lang('invalid year');
        }
        $nama_pangkat = $this->{$this->golongan_mdl}->get_nama_pangkat_by_kode_golongan($kode_golongan);
        if (!$error) {
            $gaji_pokok_mdl = $this->gaji_pokok_mdl;
            $this->load->model($gaji_pokok_mdl);
            // echo $mk_peringkat;
            // die();
            $duplicated     = $this->{$gaji_pokok_mdl}->is_duplicated($kode_golongan, $mk_peringkat, $tahun, $edit_id);
            if ($duplicated) {
                $error['kode_golongan'] = lang('duplicated'). ': ' . $kode_golongan .' - ' . $nama_pangkat;
                $error['mk_peringkat']    = lang('duplicated'). ': ' . $mk_peringkat;
                $error['tahun']         = lang('duplicated'). ': ' . $tahun;
            }
        }
        if (!$error) {
            
            $do_update    = $this->{$gaji_pokok_mdl}->update_gaji_pokok($edit_id, $kode_golongan, $nama_pangkat, $mk_peringkat, $gaji_pokok, $tahun);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $edit_id));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    public function edit($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        if($id=='kenaikan_gaji'){
            return $this->_kenaikan_gaji($cur_page,$per_page,$order_by,$sort_order);
        }
        if ($id) {
            $golongan_mdl             = $this->golongan_mdl;
            $masa_kerja_mdl           = $this->masa_kerja_mdl;
            $r_peg_mdl                = $this->r_peg_mdl;
            $this->load_mdl($golongan_mdl);
            $this->load_mdl($masa_kerja_mdl);
            $this->load_mdl($r_peg_mdl);
            $data_ls                  = array();
            $data_ls['masa_kerja_ls'] = $this->{$masa_kerja_mdl}->fetch_masa_kerja();
            $data_ls['golongan_ls']   = $this->{$golongan_mdl}->fetch_golongan();
            $year_ls                  = range(date('Y') + 1, $this->{$r_peg_mdl}->get_min_tgl_terima_year());
            $data_ls['year_ls']       = array_combine($year_ls, $year_ls);
            $this->set_data($data_ls);
            if ($id == md5('del' . date('ymd'))) {
                if ($cur_page) {
                    return $this->_do_del($mdl, $cur_page);
                }
            }
            if ($id == md5('new' . date('ymd'))) {
                return $this->_do_add_new($mdl);
            }
            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->{$mdl}->set_rs_select();
        $this->{$mdl}->set_joins();
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Base Salary Management"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        // $this->db->where('status','aktif');
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Base Salary Master"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }
    public function _kenaikan_gaji($a='',$b='',$c='',$d='',$e='',$f='')
    {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        $payload = json_decode(file_get_contents('php://input'));
        if(is_object($payload)){
            $proses = $payload->proses;
            $prosentase = $payload->prosentase;
            $tahun = $payload->tahun;
            $data = $payload->data;
            $cmd = $payload->cmd;
            $page = $payload->page;
            $per_page = $payload->per_page;
            $ids = $payload->ids;

            if(empty($page)){
                $page = 1;
            }
            if(empty($per_page)){
                $per_page = 10;
            }
        }
        if($cmd == 'save_rows'){
            $new_ids = [];
            $tahun = date('Y');
            $list = $this->db->where_in('id_gaji_pokok',$ids)
                             ->get('m_gaji_pokok')
                             ->result();
            foreach ($list as $rw) {
                $pk = $rw->id_gaji_pokok;
                unset($rw->id_gaji_pokok);
                $rw->tahun = $tahun;
                $add = ($rw->gaji_pokok + 0) * ($prosentase/100);
                $rw->gaji_pokok = $rw->gaji_pokok + $add;
                $this->db->insert('m_gaji_pokok',$rw);
                $new_ids[]=$this->db->insert_id();
                
            }   

            // unset active
            $this->db->where_in('id_gaji_pokok',$ids)->update('m_gaji_pokok',['status'=>'tidak aktif']);              
            $data = [
                'success'=>true,
                'ids' => $ids,
                'new_ids' => $new_ids
            ];                 
            $this->output->set_content_type('text/javascript')
                         ->set_output(json_encode($data))
                         ->_display();
            exit;                 
        }   
        if($cmd == 'get_list'){
            $cond = [
                'tahun'=> $tahun,
                'status'=>'aktif'
            ];
            $total_rows =  $this->db->where($cond)
                                ->select('COUNT(id_gaji_pokok) total')
                                ->get('m_gaji_pokok')
                                ->row()->total + 0;
            $total_pages = ceil($total_rows / $per_page);
            $offset = ($page - 1) * $per_page;
                                
            $list = $this->db->where($cond)
                             ->order_by('kode_golongan','asc')
                             ->order_by('mk_peringkat','asc')
                             ->get('m_gaji_pokok',$per_page,$offset)
                             ->result();


            foreach ($list as $index => &$rw) {
                if($rw->kode_golongan == '97'){
                    unset($list[$index]);
                    continue;
                }
                $rw->selected = false;
                $rw->gaji_pokok_add_uf = ($rw->gaji_pokok + 0) * ($prosentase/100);
                $rw->gaji_pokok_add = number_format($rw->gaji_pokok_add_uf, 0, ",", ".");
                $rw->gaji_pokok_before = number_format($rw->gaji_pokok, 0, ",", ".");
                $rw->gaji_pokok = number_format($rw->gaji_pokok + $rw->gaji_pokok_add_uf, 0, ",", ".");

            }
            $data = [
                'page' => $page,
                'per_page' => $per_page,
                'total_pages' => $total_pages,
                'total_rows' => $total_rows,
                'data' => $list,
                'tahun' => $tahun,
                'prosentase' => $prosentase
            ];

            $this->output->set_content_type('text/javascript')
                         ->set_output(json_encode($data))
                         ->_display();
            exit;
        }
        

        $p_tahun = $this->db->select("MIN(tahun) min_tahun, MAX(tahun) max_tahun")->get('m_gaji_pokok')->row();

        $tahun_list = [];

        $i_tahun = $p_tahun->min_tahun;
        
        
        if(empty($tahun)){
            $tahun = $i_tahun;
        }
        if(empty($prosentase)){
            $prosentase = 10;
        }
        while( $i_tahun <= $p_tahun->max_tahun){

            $tahun_list[$i_tahun] = $i_tahun;
            $i_tahun += 1;
        }
        $data = [
            'tahun_list' => $tahun_list,
            'tahun' => $tahun,
            'button_pressed' => false,
            'prosentase' => $prosentase
        ];

        $this->set_data($data);
        $this->print_page('kenaikan_gaji');


    }
}
