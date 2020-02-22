<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mod        = $this->router->fetch_module();
$controller = $this->router->fetch_class();
$method     = $this->router->fetch_method();

$raw_token = date('Y-m-d') . $controller . $this->session->userdata('sf_sess_uid') . $this->session->userdata('session_id');
if (isset($custom_filter)) {
    echo $custom_filter . '<br>';
}
if (!isset($rs_form_input)) {
    printf('<h4>%s</h4>', lang('Empty record'));
    return;
}
if (!$rs_form_input) {
    printf('<h4>%s</h4>', lang('Empty record'));
    return;
}
extract($rs_form_input);
?>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
        </thead>
        <tbody>

            <tr>
                <td width="200"><?php echo lang('NIPP'), ' - ', lang('Name'); ?></td>
                <td><?php echo $detail->nipp; ?> - <?php echo $detail->name; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Status'); ?></td>
                <td><?php echo $detail->relatives; ?>
                    <?php
                    echo $detail->dependent_status ? lang('get the allowance') : '';
                    ?>
                    <?php
                    echo $detail->alw_rc_ch_cnt ? lang('and get the rice allowance') : '';
                    ?>
                </td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Dependent Name'); ?></td>
                <td><?php echo $detail->text; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Since'); ?></td>
                <td><?php
                    if ($detail->eff_date):
                        echo date('d/m/Y', strtotime($detail->eff_date));
                    endif;

                    if ($detail->term_date):
                        echo date(' - d/m/Y', strtotime($detail->term_date));
                    endif;
                    ?></td>
            </tr>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>
<div class="users form">
    <form class="form-horizontal" role="form" id="UserAddForm" method="post" accept-charset="utf-8">
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST" />
        </div>	
        <fieldset>
            <?php
            
            //text
            $field_alias      = md5('text');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Dependent Name'),
                'maxlength'   => '100',
                'col_lg'      => '6',
                'col_sm'      => '6',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));

            //relatives
           
            $field_alias = md5('relatives');

            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Relatives'),
                'type'         => 'select',
                'empty'        => true,
                'list_options' => $relatives_ls,
                'col_lg'       => '2',
                'col_sm'       => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
            //gender
           $gender_ls = array(
                'l' => lang('Male'),
                'p' => lang('Female')
            );

            $field_alias = md5('gender');

            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Gender'),
                'type'         => 'select',
                'empty'        => true,
                'list_options' => $gender_ls,
                'col_lg'       => '2',
                'col_sm'       => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
            //dependent_status
           $get_ls = array(
                '0' => lang('Not Get'),
                '1' => lang('Get')
            );

            $field_alias = md5('dependent_status');

            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Alw. Stat.'),
                'type'         => 'select',
                'empty'        => true,
                'list_options' => $get_ls,
                'col_lg'       => '2',
                'col_sm'       => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
            
            //alw_rc_ch_cnt
            
            $field_alias = md5('alw_rc_ch_cnt');
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Rice Alw. Stat.'),
                'type'         => 'select',
                'empty'        => true,
                'list_options' => $get_ls,
                'col_lg'       => '2',
                'col_sm'       => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
//eff_date
            $field_alias      = md5('eff_date');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Since'),
                'type'        => 'date',
                'required'    => true,
                'col_lg'      => '2',
                'col_sm'      => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));

            //term_date
            $field_alias      = md5('term_date');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Until'),
                'type'        => 'date',
                'col_lg'      => '2',
                'col_sm'      => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));

            

            //annotation
            $field_alias      = md5('annotation');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Notes'),
                'maxlength'   => '255',
                
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //hr
            echo '<hr>';
            $ymd         = date('ymd');
            $field_alias = md5('id');
            ?>
            <input type="hidden" name="data[<?php echo md5('edit_id' . $ymd); ?>]" value="<?php echo $rs_form_input[$field_alias]['value']; ?>">
            <input type="hidden" name="data[<?php echo md5('edit_id_hash' . $ymd); ?>]" value="<?php echo md5($rs_form_input[$field_alias]['value'] . $ymd); ?>">
            <div class="form-group">
                <label class="col-lg-2 col-sm-2 control-label"><a class="btn" href="<?php echo $rs_form_input['back_url']; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('back'); ?></a></label>

                <div class="col-sm-8 col-lg-8">
                    <input class="btn btn-primary" type="submit" value="<?php echo lang('save'); ?>"/>
                    <input class="btn btn-default" type="reset" value="<?php echo lang('reset'); ?>"/>

                </div>
            </div>
        </fieldset>
    </form>
</div>