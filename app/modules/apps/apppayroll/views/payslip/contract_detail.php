<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!isset($detail)) {
    printf('<h4>%s</h4>', lang('Empty record'));
    return;
}
?>
<div>
    <div class="row">
        <div class="col-sm-3 col-lg-3">
            <div class="row">
                <h5><?php echo lang('Job Unit'); ?>: <?php echo $detail->job_unit; ?></h5>
            </div>
            <div class="row">
                <h5>&nbsp;</h5>
            </div>
            <div class="row">
                <h5>( .................................... )</h5>
            </div>

        </div>
        <div class="col-sm-5 col-lg-5  text-center">
            <div class="row">
                <h5><?php echo $detail->nipp; ?></h5>
                <h5><?php echo $detail->empl_name; ?></h5>
                <h5><?php
                    $print_dt = strtotime($detail->print_dt);
                    $year     = date('Y', $print_dt);
                    $month    = date('F', $print_dt);
                    $month    = lang(ucfirst($month));
                    $periode  = $month;
                    $periode .= ' ';
                    $periode .= $year;
                    echo $periode;
                    ?></h5>
                <h5><?php 
                $label = lang('Total Working Day');
                $days = lang('days');
                printf('%s: %s %s', $label, $detail->work_day, $days);
                ?></h5>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="row">
                <h5>&nbsp;</h5>
            </div>
            <div class="row">
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr>
                            <!-- <th class="text-center alert-info">H</th> -->
                            <th class="text-center">S</th>
                            <th class="text-center alert-warning">I</th>
                            <th class="text-center  alert-danger">A</th>
                            <th class="text-center alert-warning">L</th>
                            <th class="text-center">C</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- <td class="text-center alert-info"><?php echo $detail->empl_work_day; ?></td> -->
                            <td class="text-center"><?php echo $detail->attn_s; ?></td>
                            <td class="text-center alert-warning"><?php echo $detail->attn_i; ?></td>
                            <td class="text-center  alert-danger"><?php echo $detail->attn_a; ?></td>
                            <td class="text-center   alert-warning"><?php echo $detail->attn_l; ?></td>
                            <td class="text-center"><?php echo $detail->attn_c; ?></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered table-condensed ">
            <thead>
                <tr>
                    <th class="text-center" width="50%">
                        <h5><?php echo lang('I N C O M E');?></h5>
                    </th>
                    <th class="text-center">
                        <h5><?php echo lang('D E D U C T I O N');?></h5>
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%"><?php echo lang('BASE SALARY');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->base_sal, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('MARITAL ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_mar, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('CHILDREN ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_ch, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('RICE ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_rc, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('ADVANCE ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_adv, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('WATER ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_wt, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('JOB ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_jt, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('FOOD ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_fd, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('RESIDENCE ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_rs, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('OVERTIME ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_ot, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('TRANSPORTATION ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_tr, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('PERFORMANCE ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_prf, 0, ",", ".");?></td>
                                </tr>
                           <!--      <tr>
                                    <td><?php echo lang('SHIFT ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_sh, 0, ",", ".");?></td>
                                </tr> -->
                                <tr>
                                    <td><?php echo lang('VEHICLE RENTAL ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_vhc_rt, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('TPP');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_tpp, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('PPh21 ALLOWANCE');?></td>
                                    <td>:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->alw_pph21, 0, ",", ".");?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                         <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%"><?php echo lang('PPh21');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_pph21, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('BPJS KETENAGAKERJAAN');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_bpjs_ket, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('BPJS KESEHATAN');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_bpjs_kes, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('BPJS PENSIUN');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_bpjs_pen, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('ASPEN');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_aspen, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('F-KP');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_f_kp, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('WORKER COOPERATIVE');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_wcl, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('WK. OBLIGATORY DEPOSIT');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_wc, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('DHARMA WANITA');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_dw, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('ZAKAT');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_zk, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('SHODAQOH');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_shd, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('TPTGR');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_tpt, 0, ",", ".");?></td>
                                </tr>
                                <tr>
                                    <td width="50%"><?php echo lang('WATER-BILL');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_wb, 0, ",", ".");?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%"><?php echo lang('TOTAL INCOME');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->gross_sal, 0, ",", ".");?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%"><?php echo lang('DEDUCTION TOTAL');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->ddc_amt, 0, ",", ".");?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%"><?php echo lang('NET PAY');?></td>
                                    <td width="10">:</td>
                                    <td><?php echo lang('#CURRENCY_SYMBOL');?></td>
                                    <td class="text-right"><?php echo number_format($detail->net_pay, 0, ",", ".");?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
<a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('back'); ?></a>
                        <?php
                        /** if($detail->locked):
                          ?><a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
                          <span class="fa fa-lock fa-2x fa-border fa-fw text-danger"></span>
                          <?php
                          endif;
                          if(!$detail->locked):
                          ?>
                          <form class="form-inline" method="post">
                          <?php
                          $ymd = date('ymd');
                          ?>
                          <input type="hidden" name="<?php echo md5('del_id'.$ymd);?>" value="<?php echo $detail->id_gaji_pokok;?>">
                          <input type="hidden" name="<?php echo md5('del_id_hash'.$ymd);?>" value="<?php echo md5($detail->id_gaji_pokok.$ymd);?>">
                          <div class="form-group">
                          <div class="form-group">
                          <a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
                          </div>
                          <button type="submit" name="<?php echo md5('do_delete'.$ymd);?>" class="btn btn-danger"><span class="fa fa-trash-o"></span> <?php echo lang('Confirm Delete');?></button>
                          </form>
                          <?php
                          endif; */
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
<?php debug($detail); ?>
