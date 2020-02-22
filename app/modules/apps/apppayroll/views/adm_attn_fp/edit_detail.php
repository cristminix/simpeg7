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
            
        </tbody>
        
    </table>
</div>
<div class="users form">
    <form class="form-horizontal" role="form" id="UserAddForm" method="post" accept-charset="utf-8">
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST" />
        </div>	
        <fieldset>
            <?php
            
            //fpid
            $field_alias      = md5('fpid');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('FPID'),
                'maxlength'   => '50',
                'col_lg'      => '2',
                'col_sm'      => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));

            //text
            $field_alias      = md5('text');
            $label            = lang('Annotation');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '255',
                'type'        => 'textarea',
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