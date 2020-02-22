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
            //year
            $field_alias      = md5('tahun');
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Year'),
                'type'         => 'select',
                'empty'         => true,
                'list_options' => $year_ls,
                'col_lg' => '2',
                'col_sm' => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
            // zakat_amt
            $field_alias      = md5('kode_golongan');
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Grade'),
                'type'         => 'select',
                'empty'         => true,
                'list_options' => $golongan_ls,
                'col_lg' => '4',
                'col_sm' => '4',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));


            //name
            $field_alias      = md5('mk_peringkat');
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Length of Service'),
                'empty'         => true,
                'type'         => 'select',
                'list_options' => $masa_kerja_ls,
                'col_lg' => '2',
                'col_sm' => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            //name
            $field_alias      = md5('gaji_pokok');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Base Salary'),
                'maxlength' => '15',
                'col_lg' => '3',
                'col_sm' => '3',
                'required' => true,
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