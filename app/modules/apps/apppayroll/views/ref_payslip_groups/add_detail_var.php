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
                <td width="200"><?php echo lang('Payslip Group Name'); ?></td>
                <td><?php echo $detail->name; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Annotation'); ?></td>
                <td><?php echo $detail->text; ?></td>
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
            //name
            $field_alias = md5('apr_payslip_group_id');

            $input = array(
                'field_alias' => $field_alias,
                'type'        => 'hidden',
            );

            if (isset($rs_form_input[$field_alias]['value']))
                $input['value'] = $rs_form_input[$field_alias]['value'];
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

            
            //text
            $field_alias      = md5('field_name');
            $label            = lang('Name');
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => $label,
                'type'         => 'select',
                'list_options' => $field_ls,
                'empty'        => true,
                'col_lg'       => '4',
                'col_sm'       => '4',
                'required'      => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //class_mdl
            $field_alias      = md5('operator');
            $label            = lang('Operator');
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => $label,
                'type'         => 'select',
                'list_options' => $operator_ls,
                'empty'        => true,
                'col_lg'       => '2',
                'col_sm'       => '2',
                'required'      => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //fetch_method
            $field_alias      = md5('value');
            $label            = lang('Value');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '255',
                'col_lg'      => '6',
                'col_sm'      => '6',
                'required'      => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));

            //hr
            echo '<hr>';
            ?>
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