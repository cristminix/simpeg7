<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


?>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
        </thead>
        <tbody>

            
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">

                    <?php
                   
                        ?>
                        <form class="form-inline" method="post">
                            <?php
                            $ymd        = date('ymd');
                            $field_name = 'action';
                            ?>
                            <input type="hidden" name="<?php echo md5('confirm_id' . $ymd); ?>" value="<?php echo $detail->{$field_name}; ?>">
                            <input type="hidden" name="<?php echo md5('confirm_id_hash' . $ymd); ?>" value="<?php echo md5($detail->{$field_name} . $ymd); ?>">
                            <div class="form-group">
                                <div class="form-group">
                                    <a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
                                </div>
                                <button type="submit" name="<?php echo md5('do_action' . $ymd); ?>" class="btn btn-warning"><span class="fa fa-exclamation-triangle"></span> <?php echo lang('Confirm action now !'); ?></button>
                        </form>
                        
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<?php debug($detail); ?>
