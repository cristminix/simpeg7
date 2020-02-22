<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!$form_filter)
    return;
extract($form_filter);
?>
<div class="console-filter">
    <div class="row">
        <div class="col-xs-12">
            <form class="form-inline" role="form" enctype="utf-8" method="post">
                <button type="button" class="btn btn-default"><span class="fa fa-filter"></span></button>
                <div class="form-group">
                    <select class="form-control" name="<?php echo ${$ff_prefix . 'sess_name'} . '_field'; ?>">
                        <?php
                        $selected_all = $this->config->item('ff_all_value') == ${$ff_prefix . 'field'} ? ' selected="selected"' : "";
                        ?>
                        <option <?php echo $selected_all; ?> value="<?php echo $this->config->item('ff_all_value'); ?>">--<?php echo lang('Anything'); ?>--</option>
                        <?php
                        if (isset(${$ff_prefix . 'cols'})):
                            if (${$ff_prefix . 'cols'}):
                                foreach (${$ff_prefix . 'cols'} as $key => $value):

                                    $selected = $key == ${$ff_prefix . 'field'} ? ' selected="selected"' : "";
                                    if ($selected_all) {
                                        $selected = '';
                                    }
                                    $text = lang($value);
                                    printf('<option%s value="%s">%s</option>', $selected, $key, $text);
                                endforeach;
                            endif;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="<?php echo ${$ff_prefix . 'sess_name'} . '_val'; ?>" placeholder="<?php echo lang('search'); ?>" value="<?php echo ${$ff_prefix . 'value'}; ?>">

                </div>
                <button type="submit" value="1" name="<?php echo ${$ff_prefix . 'sess_name'} . '_do_search'; ?>" class="btn btn-primary"><span class="fa fa-search"></span></button>
                <button type="submit" value="1" name="<?php echo ${$ff_prefix . 'sess_name'} . '_do_clear'; ?>" class="btn btn-warning"><span class="fa fa-eraser"></span></button>
            </form>

        </div>
    </div>
</div>
