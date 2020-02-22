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
<div class="users form">
    <form class="form-horizontal" role="form" id="UserAddForm" method="post" accept-charset="utf-8">
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST" />
        </div>	
        <fieldset>
            <?php
            //name
            $field_alias      = md5('name');
            $label            = lang('Code');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '100',
                'col_lg'      => '3',
                'col_sm'      => '3',
                'required'    => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //text
            $field_alias      = md5('text');
            $label            = lang('Name');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '100',
                'col_lg'      => '6',
                'col_sm'      => '6',
                'required'    => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //class_mdl
            $field_alias      = md5('class_mdl');
            $label            = lang('Obj Model');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '100',
                'col_lg'      => '3',
                'col_sm'      => '3',
                'required'    => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //fetch_method
            $field_alias      = md5('fetch_method');
            $label            = lang('Fetch Method');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '100',
                'col_lg'      => '3',
                'col_sm'      => '3',
                'required'    => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //annotation
            $field_alias      = md5('annotation');
            $label            = lang('Annotation');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => $label,
                'maxlength'   => '100',
                'type'      => 'textarea',
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