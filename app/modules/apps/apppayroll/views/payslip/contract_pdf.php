<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->library('pr_tcpdf');
$this->pr_tcpdf->_init('A4', 'P');
$pdf          = $this->pr_tcpdf->pdf;
$pdf->SetFont('helvetica', '', '9');

$pdf->setPrintHeader(false);
$ln           = 0;
$border       = 0;
$border_style = array(
    'width' => 0.1,
    'cap'   => 'butt',
    'join'  => 'miter',
    'dash'  => 0,
    'color' => array(100, 100, 100)
);
$border_thin  = array(
    'LTRB' => $border_style
);

$border_thin_l   = array(
    'L' => $border_style
);
$border_thin_lr  = array(
    'LR' => $border_style
);
$border_thin_lrb = array(
    'LRB' => $border_style
);
$border_thin_ltb = array(
    'LTB' => $border_style
);
$border_thin_r   = array(
    'R' => $border_style
);
$border_thin_tb   = array(
    'TB' => $border_style
);
$border_thin_trb   = array(
    'TRB' => $border_style
);
$arr             = array(
    // 'H' => 'empl_work_day',
    'S' => 'attn_s',
    'I' => 'attn_i',
    'A' => 'attn_a',
    'L' => 'attn_l',
    'C' => 'attn_c',
);

$components = array(
    array(
        'l' => array(
            'base_sal' => 'BASE SALARY'
        ),
        'r' => array(
            'ddc_pph21' => 'PPh21'
        ),
    ),
    array(
        'l' => array(
            'alw_mar' => 'MARITAL ALLOWANCE'
        ),
        'r' => array(
            'ddc_bpjs_ket' => 'BPJS KETENAGAKERJAAN'
        ),
    ),
    array(
        'l' => array(
            'alw_ch' => 'CHILDREN ALLOWANCE'
        ),
        'r' => array(
            'ddc_bpjs_kes' => 'BPJS KESEHATAN'
        ),
    ),
    array(
        'l' => array(
            'alw_rc' => 'RICE ALLOWANCE'
        ),
        'r' => array(
            'ddc_bpjs_pen' => 'BPJS PENSIUN'
        ),
    ),
    array(
        'l' => array(
            'alw_adv' => 'ADVANCE ALLOWANCE'
        ),
        'r' => array(
            'ddc_aspen' => 'ASPEN'
        ),
    ),
    array(
        'l' => array(
            'alw_wt' => 'WATER ALLOWANCE'
        ),
        'r' => array(
            'ddc_f_kp' => 'F-KP'
        ),
    ),
    array(
        'l' => array(
            'alw_jt' => 'JOB ALLOWANCE'
        ),
        'r' => array(
            'ddc_wcl' => 'WORKER COOPERATIVE'
        ),
    ),
    array(
        'l' => array(
            'alw_fd' => 'FOOD ALLOWANCE'
        ),
        'r' => array(
            'ddc_wc' => 'WK. OBLIGATORY DEPOSIT'
        ),
    ),
    array(
        'l' => array(
            'alw_rs' => 'RESIDENCE ALLOWANCE'
        ),
        'r' => array(
            'ddc_dw' => 'DHARMA WANITA'
        ),
    ),
    array(
        'l' => array(
            'alw_ot' => 'OVERTIME ALLOWANCE'
        ),
        'r' => array(
            'ddc_zk' => 'ZAKAT'
        ),
    ),
    array(
        'l' => array(
            'alw_tr' => 'TRANSPORTATION ALLOWANCE'
        ),
        'r' => array(
            'ddc_shd' => 'SHODAQOH'
        ),
    ),
    array(
        'l' => array(
            'alw_prf' => 'PERFORMANCE ALLOWANCE'
        ),
        'r' => array(
            'ddc_tpt' => 'TPTGR'
        ),
    ),

    array(
        'l' => array(
            'alw_vhc_rt' => 'VEHICLE RENTAL ALLOWANCE'
        ),
        'r' => array(
            'ddc_wb' => 'WATER-BILL'
//            
        ),
    ),
    array(
        'l' => array(
            'alw_tpp' => 'TPP'
        ),
        'r' => array(
//            
        ),
    ),
    array(
        'l' => array(
            'alw_pph21' => 'PPh21 ALLOWANCE'
        ),
        'r' => array(
//            
        ),
    ),
);

$curr = lang('#CURRENCY_SYMBOL');
foreach ($ls as $i => $r):
    $pdf->addPage();
    //$pdf->SetFillColor(255, 255, 255);
    /**
     * 
      $w,
      $h = 0,
      $txt = “,
      $border = 0,
      $ln = 0,
      $align = “,
      $fill = false,
      $link = “,
      $stretch = 0,
      $ignore_min_height = false,
      $calign = ’T’,
      $valign = ’M’
     */
    $txt = lang('Job Unit') . ' : ' . $r->job_unit;
    $pdf->Cell(63, 1, $txt, $border, $ln, 'L', false);
    $txt = $r->nipp;
    $pdf->Cell(63, 1, $txt, $border, $ln, 'C', false);
    $txt = ' ';
    $pdf->Cell(64, 1, $txt, $border, $ln, 'R', false);

    $pdf->Ln();
    $txt = ' ';
    $pdf->Cell(63, 1, $txt, $border, $ln, 'L', false);
    $txt = $r->empl_name;
    $pdf->Cell(63, 1, $txt, $border, $ln, 'C', false);
    $txt = '';
    $pdf->Cell(64, 1, $txt, $border, $ln, 'R', false);

    $pdf->Ln();
    $txt      = ' ';
    $pdf->Cell(63, 1, $txt, $border, $ln, 'L', false);
    $print_dt = strtotime($r->print_dt);
    $year     = date('Y', $print_dt);
    $month    = date('F', $print_dt);
    $month    = lang(ucfirst($month));
    $periode  = $month;
    $periode  .= ' ';
    $periode  .= $year;

    $txt = $periode;
    $pdf->Cell(63, 1, $txt, $border, $ln, 'C', false);


    foreach ($arr as $key => $val):
        $pdf->Cell(10, 1, $key, $border_thin, $ln, 'C', false);
    endforeach;

    $pdf->Ln();
    $txt   = '( .................................... )';
    $pdf->Cell(63, 1, $txt, $border, $ln, 'L', false);
    $label = lang('Total Working Day');
    $days  = lang('days');


    $txt = sprintf('%s: %s %s', $label, $r->work_day, $days);
    $pdf->Cell(63, 1, $txt, $border, $ln, 'C', false);

    foreach ($arr as $key => $val):
        $pdf->Cell(10, 1, $r->{$val}, $border_thin, $ln, 'C', false);
    endforeach;
    //

    $pdf->Ln(10);
    $txt = lang('I N C O M E');
    $pdf->Cell(95, 1, $txt, $border_thin, $ln, 'C', false);
    $txt = lang('D E D U C T I O N');
    $pdf->Cell(95, 1, $txt, $border_thin, $ln, 'C', false);

    $pdf->Ln();

    $txt = '';
    $pdf->Cell(95, 1, $txt, $border_thin_lr, $ln, 'C', false);
    $txt = '';
    $pdf->Cell(95, 1, $txt, $border_thin_lr, $ln, 'C', false);

    $pdf->Ln();
    foreach ($components as $rows):
        foreach ($rows as $col):
            $txt = '';
            $pdf->Cell(3, 1, $txt, $border_thin_l, $ln, 'L', false);

            if ($col):
                $field = key($col);
                $label = $col[$field];

                $txt = lang($label);
                $pdf->Cell(45, 1, $txt, $border, $ln, 'L', false);
                $txt = ':';
                $pdf->Cell(2, 1, $txt, $border, $ln, 'L', false);
                $txt = $curr;
                $pdf->Cell(10, 1, $txt, $border, $ln, 'R', false);
                $txt = number_format($r->{$field}, 0, ",", ".");
                $pdf->Cell(30, 1, $txt, $border, $ln, 'R', false);
            else:
                $txt = '';
                $pdf->Cell(45, 1, $txt, $border, $ln, 'L', false);
                $pdf->Cell(2, 1, $txt, $border, $ln, 'L', false);
                $pdf->Cell(10, 1, $txt, $border, $ln, 'R', false);
                $pdf->Cell(30, 1, $txt, $border, $ln, 'R', false);
            endif;
            $txt = '';
            $pdf->Cell(5, 1, $txt, $border_thin_r, $ln, 'L', false);

        endforeach;
        //
        $pdf->Ln();

    endforeach;
    $txt = '';
    $pdf->Cell(95, 1, $txt, $border_thin_lrb, $ln, 'C', false);
    $pdf->Cell(95, 1, $txt, $border_thin_lrb, $ln, 'C', false);
    $pdf->Ln();
    
    $txt = '';
    $pdf->Cell(3, 1, $txt, $border_thin_l, $ln, 'L', false);
    $txt = lang('TOTAL INCOME');
    $pdf->Cell(45, 1, $txt, $border, $ln, 'L', false);
    $txt = ':';
    $pdf->Cell(2, 1, $txt, $border, $ln, 'L', false);
    $txt = $curr;
    $pdf->Cell(10, 1, $txt, $border, $ln, 'R', false);
    $txt = number_format($r->gross_sal, 0, ",", ".");
    $pdf->Cell(30, 1, $txt, $border, $ln, 'R', false);
    $txt = '';
    $pdf->Cell(5, 1, $txt, $border_thin_r, $ln, 'L', false);
    
    $txt = '';
    $pdf->Cell(3, 1, $txt, $border_thin_l, $ln, 'L', false);
    $txt = lang('DEDUCTION TOTAL');
    $pdf->Cell(45, 1, $txt, $border, $ln, 'L', false);
    $txt = ':';
    $pdf->Cell(2, 1, $txt, $border, $ln, 'L', false);
    $txt = $curr;
    $pdf->Cell(10, 1, $txt, $border, $ln, 'R', false);
    $txt = number_format($r->ddc_amt, 0, ",", ".");
    $pdf->Cell(30, 1, $txt, $border, $ln, 'R', false);
    $txt = '';
    $pdf->Cell(5, 1, $txt, $border_thin_r, $ln, 'L', false);
    
    $pdf->Ln();
    $txt = '';
    $pdf->Cell(95, 1, $txt, $border_thin, $ln, 'C', false);
    
    $txt = '';
    $pdf->Cell(3, 1, $txt, $border_thin_ltb, $ln, 'L', false);
    $txt = lang('NET PAY');
    $pdf->Cell(45, 1, $txt, $border_thin_tb, $ln, 'L', false);
    $txt = ':';
    $pdf->Cell(2, 1, $txt, $border_thin_tb, $ln, 'L', false);
    $txt = $curr;
    $pdf->Cell(10, 1, $txt, $border_thin_tb, $ln, 'R', false);
    $txt = number_format($r->net_pay, 0, ",", ".");
    $pdf->Cell(30, 1, $txt, $border_thin_tb, $ln, 'R', false);
    $txt = '';
    $pdf->Cell(5, 1, $txt, $border_thin_trb, $ln, 'L', false);
    
endforeach;

$this->pr_tcpdf->pdf = $pdf;
$this->pr_tcpdf->render('file');


