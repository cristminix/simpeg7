<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mod        = $this->router->fetch_module();
$controller = $this->router->fetch_class();
$method     = $this->router->fetch_method();

$raw_token = date('Y-m-d') . $controller . $this->session->userdata('sf_sess_uid') . $this->session->userdata('session_id');
//if (isset($custom_filter)) {
//    echo $custom_filter . '<br>';
//}
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
                <td width="200"><?php echo lang('Year Period'); ?></td>
                <td><?php echo $cf_cur_year; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Month Period'); ?></td>
                <td><?php echo $cf_cur_month; ?></td>
            </tr>
        </tbody>

    </table>
</div>
<?php
if (isset($rs_confirm_list)):
    ?><div>
        <form class="form-horizontal" role="form"method="post" accept-charset="utf-8">
            <fieldset>
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th width="70"><?php echo lang('EMPL ID'); ?></th>
                            <th width="80"><?php echo lang('NIPP'); ?></th>
                            <th><?php echo lang('Name'); ?></th>
                            <th><?php echo lang('Advance Allowance'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($rs_confirm_list as $i => $row):
                            ?><tr>
                                <td>

                                    <?php echo $n; ?></td>
                                <td>
                                    <input type="hidden" name="<?php echo md5('empl_id'); ?>[]" value="<?php echo $row['empl_id']; ?>">
                                    <?php echo $row['empl_id']; ?></td>
                                <td>
                                    <?php echo $row['nipp']; ?>
                                    <input type="hidden" name="<?php echo md5('nipp'); ?>[]" value="<?php echo $row['nipp']; ?>">
                                </td>
                                <td><?php
                                    $varname = 'empl_name';
                                    echo $row[$varname];
                                    ?>
                                    <input type="hidden" name="<?php echo md5($varname); ?>[]" value="<?php echo $row[$varname]; ?>"></td>
                                <td><?php
                                    $varname = 'alw_adv';
                                    echo $row[$varname];
                                    ?>
                                    <input type="hidden" name="<?php echo md5($varname); ?>[]" value="<?php echo $row[$varname]; ?>"></td>
                                <?php
                                ?></tr><?php
                                $n++;
                            endforeach;
                            ?>

                    </tbody>

                </table>
                <div class="form-group">

                    <div class="col-sm-8 col-lg-8">
                        <input class="btn btn-warning" name="<?php echo md5('confirm-upload'); ?>" type="submit" value="<?php echo lang('confirm to save'); ?>"/>

                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div>
        <hr>
        <h6><?php echo lang('Upload another file'); ?> :</h6>
    </div>
    <?php
endif;
?>
<div class="users form">

    <form class="form-horizontal" role="form" id="UserAddForm" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST" />
        </div>	
        <fieldset>
            <?php
            $field_alias = md5('file_import_alw_adv');
            $input       = array(
                'field_alias' => $field_alias,
                'label'       => lang('File upload'),
                'type'        => 'file',
                'col_lg'      => '4',
                'col_sm'      => '4',
                'input_attr'  => array('title' => lang('Choose file')),
//                'before_input' => $adsimageinfo . $adsimage . '<br>',
            );
            if (isset(${$field_alias}['err_msg'])) {
                $input['err_msg'] = ${$field_alias}['err_msg'];
            }

            echo $this->load->view('elements/form/input', compact('input'));
            ?>

            <div class="form-group">
                <label class="col-lg-2 col-sm-2 control-label"><a class="btn" href="<?php echo $rs_form_input['back_url']; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('back'); ?></a></label>

                <div class="col-sm-8 col-lg-8">
                    <input class="btn btn-primary" type="submit" value="<?php echo lang('upload'); ?>"/>
                    <input class="btn btn-default" type="reset" value="<?php echo lang('reset'); ?>"/>

                </div>
            </div>
        </fieldset>
    </form>
</div>