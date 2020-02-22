<?php
use Dompdf\Dompdf;
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Report extends Apppayroll_Frontctl {
    public $ibl_bjb_mdl_name = 'report_ibl_bjb_mdl';
    public $payslip_m = "payslip_mdl";
    // public $m_payslip_report = 'm_payslip_report';
    public function index() {        
        $this->print_page();
    }
    public function ibl_bjb($eid = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->ibl_bjb_mdl_name;
        $this->load_mdl($mdl);
//        $detail = array();
        if ($id) {
            $detail = $this->{$mdl}->fetch_detail($id);
            $data   = array('employee' => $detail);
            $this->set_data($data);
            return $this->print_page($tpl . '_detail');
        }
        $this->set_custom_filter($mdl);
       
        $this->set_form_filter($mdl);
        $ls       = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang('Net Pay and Loan of') . ' ' . $this->config->item('app_bjb_text'));
        $this->set_pagination($mdl);
        
        $this->set_data(compact('ls'));
        
        $this->set_common_views($mdl);
        $this->print_page($tpl);
    }
    
    public function payslip($content_type='',$b='',$t='',$iu='')
    {
        $proses  = $this->input->post('proses');
        $periode = $this->input->post('periode');
        $id_unor = $this->input->post('id_unor');
        $empl_stat = $this->input->post('empl_stat');
        $is_accnum =false;
        $payload = json_decode(file_get_contents('php://input'));
        if(is_object($payload)){
            $proses = $payload->proses;
            $periode = $payload->periode;
            $id_unor = $payload->id_unor;
            $empl_stat = $payload->empl_stat;
            if(property_exists($payload, 'accnum')) {
                $is_accnum = $payload->accnum;
            }
        }
        

        $button_pressed = false;
        $report_data = [];

        $tpl = __FUNCTION__;
        $mdl = 'm_payslip_report';
        $this->load_mdl($mdl);

        $this->set_page_title("DAFTAR GAJI PEGAWAI");
            


        if(empty($periode)){
            $periode = date('m/Y');
        }
        if(empty($id_unor)){
            $id_unor = '';
        }

        $periode_a = explode('/', $periode);
        $bulan     = $periode_a[0];
        $tahun     = $periode_a[1];

        if(!empty($content_type) && !empty($b) && !empty($t) ){
            $bulan = $b;
            $tahun = $t;
            $id_unor = $id_unor;
            $proses = 'yes';
        }
        if($proses == 'yes'){
            $button_pressed = true;
            $payslip_mdl = $this->payslip_m;
            $this->load_mdl($payslip_mdl);
            $this->{$mdl}->report_tbl = $this->{$payslip_mdl}->get_archive_table($tahun,$bulan); 
            $report_data = $this->{$mdl}->get_report_data($bulan,$tahun,$id_unor,$empl_stat);

            if($content_type == 'pdf'){
                return $this->_payslip_pdf_report($report_data);
            }
            if($is_accnum === true){
                return $this->_export_accnum($report_data, $bulan, $tahun);
            }

            $this->output->set_content_type('application/json')
                         ->set_output(json_encode($report_data))
                         ->_display();
            exit();
        }  
        $data = [
            'unor_list' => [''=>'All']+$this->{$mdl}->get_unor_list(),
            'button_pressed' => $button_pressed,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'id_unor' => $id_unor,
            'report_data' => $report_data
        ];    
        $this->set_data($data);
        $this->print_page($tpl);
    }
    private function _payslip_pdf_report($report_data){
        
        $content = $this->load->view('report/payslip_pdf',['report_data'=>$report_data],true);
        //

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        exit();
        //
    }
    public function payslip_rekap($content_type='',$b='',$t='')
    {
        $proses  = $this->input->post('proses');
        $periode = $this->input->post('periode');
        $payload = json_decode(file_get_contents('php://input'));
        if(is_object($payload)){
            $proses = $payload->proses;
            $periode = $payload->periode;
        }
        

        $button_pressed = false;
        $report_data = [];

        $tpl = __FUNCTION__;
        $mdl = 'm_payslip_report';
        $this->load_mdl($mdl);

        $this->set_page_title("REKAPITULASI GAJI PEGAWAI");
            


        if(empty($periode)){
            $periode = date('m/Y');
        }
        $periode_a = explode('/', $periode);
        $bulan     = $periode_a[0];
        $tahun     = $periode_a[1];

        if(!empty($content_type) && !empty($b) && !empty($t) ){
            $bulan = $b;
            $tahun = $t;
            $proses = 'yes';
        }
        if($proses == 'yes'){
            $button_pressed = true;
            $payslip_mdl = $this->payslip_m;
            $this->load_mdl($payslip_mdl);
            $this->{$mdl}->report_tbl = $this->{$payslip_mdl}->get_archive_table($tahun,$bulan); 
            $report_data = $this->{$mdl}->get_report_data_recap($bulan,$tahun);

            if($content_type == 'pdf'){
                return $this->_payslip_pdf_report($report_data);
            }

            $this->output->set_content_type('application/json')
                         ->set_output(json_encode($report_data))
                         ->_display();
            exit();
        }  
        $data = [
            
            'button_pressed' => $button_pressed,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'report_data' => $report_data
        ];    
        $this->set_data($data);
        $this->print_page($tpl);
    }

    protected function _export_accnum($report_data, $bulan, $tahun)
    {
        // echo json_encode($report_data);die();
        
        $this->load->library('pr_phpexcel');
        $this->pr_phpexcel->_init();
        $this->pr_phpexcel->sheetTitle(sprintf('Daftar-Transfer-%s%s',$tahun, $bulan));
        $month = ['','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
        $title = [
            [''],
            ['DAFTAR GAJI DAN POTONGAN BANK JABAR BANTEN CABANG TANGERANG'],
            ['PEGAWAI PDAM TIRTA KERTA RAHARJA KABUPATEN TANGERANG'],
            [''],
            [sprintf('PERIODE : %s %s', $month[intval($bulan)], $tahun)],
            [''],
            [sprintf('Tanggal Cetak: 26 %s %s', $month[intval($bulan)], $tahun)],
        ];
        $this->pr_phpexcel->dataFromArray($title);
        $this->pr_phpexcel->merge('A2:G2');
        $this->pr_phpexcel->merge('A3:G3');
        $this->pr_phpexcel->merge('A5:G5');
        $this->pr_phpexcel->merge('A7:G7');
        $this->pr_phpexcel->setAlignment('A1:A5', 'c');
        $this->pr_phpexcel->setAlignment('A7', 'r');

//NO	 NIPP	NAMA PEGAWAI	NO. REKENING	GAJI	POTONGAN	GAJI
//BERSIH	BANK	DITERIMA


        $header = [
            [
                'NO',
            'NIPP',
            'NAMA PEGAWAI',
            'NO. REKENING',
            'GAJI',
            'POTONGAN',
            'GAJI',    
            ],[
            '',
            '',
            '',
            '',
            'BERSIH',
            'BANK',
            'DITERIMA',
            ]
        ];
        $this->pr_phpexcel->dataFromArray($header, 'A8');
        $this->pr_phpexcel->merge('A8:A9');
        $this->pr_phpexcel->merge('B8:B9');
        $this->pr_phpexcel->merge('C8:C9');
        $this->pr_phpexcel->merge('D8:D9');
        $this->pr_phpexcel->setAlignment('A8:G9', 'c');
        $this->pr_phpexcel->setFillColor('A8:G9', 'FFDCDCDC');
        $ls = array();
        
        $netpaytotal = 0;
        foreach ($report_data as $i => $row) {
            $netpay = $row->float_netpay;
            $ls[$i] = array(
                $i + 1,
                $row->nipp,
                $row->empl_name,
                (string) $row->acc_number,
                $netpay,
                0,
                $netpay,
            );
            $netpaytotal += $row->float_netpay;
        }
        if (!$ls) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $ls[] = [
            'TOTAL:',
            '',
            '',
            '',
            $netpaytotal,
            '',
            $netpaytotal,
        ];
        $this->pr_phpexcel->setValues($ls, 0, 10, [], [4=>'#,###',6=>'#,###'], [3=>PHPExcel_Cell_DataType::TYPE_STRING]);
        
        $ii = $i+11;
        
        $this->pr_phpexcel->merge(sprintf('A%s:D%s',$ii, $ii));
        $this->pr_phpexcel->setAlignment(sprintf('A%s:D%s',$ii, $ii), 'r');
        $this->pr_phpexcel->setFillColor(sprintf('A%s:G%s',$ii, $ii), 'FFDCDCDC');
        $this->pr_phpexcel->sheetAutosize('A', 'G');
        $this->pr_phpexcel->download_xlsx(sprintf('Daftar-Transfer-%s%s',$tahun, $bulan));
        die();

    }
}
