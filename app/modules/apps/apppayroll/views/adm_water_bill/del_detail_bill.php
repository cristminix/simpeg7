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
                <td width="200"><?php echo lang('NIPP'), ' - ', lang('Name'); ?></td>
                <td><?php echo $detail->nipp; ?> - <?php echo $detail->empl_name; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Account ID'); ?></td>
                <td><?php echo $detail->acc_id; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Billing Period'); ?></td>
                <td><?php
                    if ($detail->print_dt) {
                        echo date('d/m/Y', strtotime($detail->print_dt));
                    }
                    ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Billing Amount'); ?></td>
                <td><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($detail->ddc_wb, 2, ",", "."); ?></td>
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
                            $ymd        = date('ymd');
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
