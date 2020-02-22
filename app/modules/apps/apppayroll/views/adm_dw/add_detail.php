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
                <td width="200"><?php echo lang('NIPP'); ?> - <?php echo lang('Name'); ?></td>
                <td><?php echo $detail->nip_baru; ?> - <?php echo $detail->nama_pegawai; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Join date'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($detail->tgl_terima)); ?></td>
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
            //empl_id
            $field_alias = md5('empl_id');
            $input       = array(
                'field_alias' => $field_alias,
                'type'        => 'hidden',
                'required'    => true,
            );

            if (isset($rs_form_input[$field_alias]['value']))
                $input['value'] = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));
            
            //attn_s
            $field_alias      = md5('dw_id');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('DW ID'),
                'maxlength'   => '25',
                'col_lg'      => '2',
                'col_sm'      => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));


            //attn_i
            $field_alias      = md5('member_pos');
            $list_options     = array(
                'Anggota'    => 'Anggota',
                'Pengurus'   => 'Pengurus',
                'Bendahara'  => 'Bendahara',
                'Sekretaris' => 'Sekretaris',
                'Wk. Ketua'  => 'Wk. Ketua',
                'Ketua'      => 'Ketua',
            );
            $input            = array(
                'field_alias'  => $field_alias,
                'label'        => lang('Position'),
                'type'         => 'select',
                'list_options' => $list_options,
                'col_lg'       => '2',
                'col_sm'       => '2',
                'empty'        => true,
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));

            //attn_a
            $field_alias      = md5('member_since');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Registered'),
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

            //attn_l
            $field_alias      = md5('member_term');
            $input            = array(
                'field_alias' => $field_alias,
                'label'       => lang('Termination'),
                'type'        => 'date',
                'col_lg'      => '2',
                'col_sm'      => '2',
            );
            if (isset($rs_form_input[$field_alias]['err_msg']))
                $input['err_msg'] = $rs_form_input[$field_alias]['err_msg'];
            if (isset($rs_form_input[$field_alias]['value']))
                $input['value']   = $rs_form_input[$field_alias]['value'];
            echo $this->load->view('elements/form/input', compact('input'));


            //hr
            echo '<hr>';
            $ymd         = date('ymd');
            $field_alias = md5('empl_id');
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