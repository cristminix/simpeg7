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
            // id
            $field_alias = md5('id');

            $input = array(
                'field_alias' => $field_alias,
                'type'        => 'hidden'
            );

            if (isset(${$field_alias}['value']))
                $input['value'] = ${$field_alias}['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            // id
            $field_alias = md5('print_dt');

            $input = array(
                'field_alias' => $field_alias,
                'type'        => 'hidden',
            );

            if (isset(${$field_alias}['value']))
                $input['value'] = ${$field_alias}['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
            // zakat_amt
            $field_alias      = md5('zakat_amt');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Zakat'),
                'maxlength'   => '100',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
             

            //name
            $field_alias      = md5('shodaqoh_amt');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Shodaqoh'),
                
                'maxlength'   => '100',
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
                <label class="col-lg-2 col-sm-2 control-label"><a class="btn" href="<?php echo site_url('apppayroll/zkt_sh/edit')?>"><span class="fa fa-arrow-left"></span> <?php echo lang('back'); ?></a>  </label>
                
                <div class="col-sm-8 col-lg-8">
                    <input class="btn btn-primary" type="submit" value="<?php echo lang('save'); ?>"/>
                    <input class="btn btn-default" type="reset" value="<?php echo lang('reset'); ?>"/>
                    
                </div>
            </div>
        </fieldset>
    </form>
</div>