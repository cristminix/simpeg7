<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!$cf_data)
    return;
extract($cf_data);
?><br>
<div class="console-filter">
<div class="row">
    <div class="col-xs-12">
        <form class="form-inline" role="form" enctype="utf-8" method="post">
            <button type="button" class="btn btn-default"><span class="fa fa-calendar-check-o"></span> <?php echo $cf_label; ?> :</button>
            <div class="form-group">
                <select class="form-control" name="cf_year">

                    <option value="">-- <?php echo lang('Select year'); ?> --</option>
                    <?php
                    for ($y = $cf_year_max; $y >= $cf_year_min; $y--):
                        $selected = '';
                        if (isset($cf_cur_year)) {
                            $selected = $cf_cur_year == $y ? ' selected="selected"' : '';
                        }
                        printf('<option%s value="%s">%s</option>', $selected, $y, $y);
                    endfor;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="cf_month">

                    <option value="">-- <?php echo lang('Select month'); ?> --</option>
                    <?php
                    foreach ($cf_months as $idx => $month):
                        $selected = '';
                        if (isset($cf_cur_month)) {
                            $selected = $cf_cur_month == $idx ? ' selected="selected"' : '';
                        }
                        printf('<option%s value="%s">%s</option>', $selected, $idx, $month);
                    endforeach;
                    ?>
                </select>

            </div>
            <button type="submit" value="1" name="<?php echo 'cf_do_filter'; ?>" class="btn btn-primary"><span class="fa fa-search"></span></button>
            <button type="submit" value="1" name="<?php echo 'cf_do_reset'; ?>" class="btn btn-warning"><span class="fa fa-eraser"></span></button>
        </form>

    </div>
</div>
</div>