<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!isset($detail)) {
    printf('<h4>%s</h4>', lang('Empty record'));
    return;
}
?>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
        </thead>
        <tbody>

            <tr>
                <td width="200"><?php echo lang('Payslip Group Name'); ?></td>
                <td><?php echo $rs_detail_data->name; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Annotation'); ?></td>
                <td><?php echo $rs_detail_data->text; ?></td>
            </tr>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
        </thead>
        <tbody>

            <tr>
                <td width="200"><?php echo lang('Since'); ?></td>
                <td><?php
                    if ($detail->eff_date):
                        echo $detail->eff_date == '0000-00-00' ? $detail->eff_date : date('d/m/Y', strtotime($detail->eff_date));
                    endif;

                    if ($detail->term_date):
                        echo $detail->term_date == '0000-00-00' ? ' - ' . $detail->term_date : date(' - d/m/Y', strtotime($detail->term_date));
                    endif;
                    ?></td>
            </tr>
            <tr>
                <td><?php echo lang('Fieldname'); ?></td>
                <td><?php echo $detail->field_name.' - '.$detail->name; ?></td>
            </tr>

            <tr>
                <td><?php echo lang('Operator'); ?></td>
                <td><?php echo $detail->operator; ?></td>
            </tr>
            <tr>
                <td><?php echo lang('Value'); ?></td>
                <td><?php echo $detail->value; ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">

                    <?php
                    if ($detail->locked):
                        ?><a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
                        <span class="fa fa-lock fa-2x fa-border fa-fw text-danger"></span>
                        <?php
                    endif;
                    if (!$detail->locked):
                        ?>
                        <form class="form-inline" method="post">
                            <?php
                            $ymd         = date('ymd');
                            $field_name = 'id';
                            ?>
                            <input type="hidden" name="<?php echo md5('del_id' . $ymd); ?>" value="<?php echo $detail->{$field_name}; ?>">
                            <input type="hidden" name="<?php echo md5('del_id_hash' . $ymd); ?>" value="<?php echo md5($detail->{$field_name} . $ymd); ?>">
                            <div class="form-group">
                                <div class="form-group">
                                    <a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
                                </div>
                                <button type="submit" name="<?php echo md5('do_delete' . $ymd); ?>" class="btn btn-danger"><span class="fa fa-trash-o"></span> <?php echo lang('Confirm Delete'); ?></button>
                        </form>
                        <?php
                    endif;
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<?php debug($detail); ?>
