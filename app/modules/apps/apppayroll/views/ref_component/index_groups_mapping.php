<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mod        = $this->router->fetch_module();
$controller = $this->router->fetch_class();
$method     = $this->router->fetch_method();

$raw_token = date('Y-m-d') . $controller . $this->session->userdata('sf_sess_uid') . $this->session->userdata('session_id');
if (isset($custom_filter)) {
    echo $custom_filter;
}
//if (!$ls) :
//    printf('<h4>%s</h4>', lang('Empty record'));
//    return;
//endif;

if (!isset($field_no_sorting)) {
    $field_no_sorting = array(
    );
}

$order_by = isset($order_by) ? $order_by : null;
//debug($ls);
//echo $pagination;
?>
<div>
    <form method="post">
        <input type="hidden" name="_method" value="POST">
        <table class="table table-bordered table-condensed table-striped">
            <thead>
                <?php
                if (isset($rs_action)):
                    if (isset($rs_action['view_data'])):
                        if (isset($rs_action['view_data']['action_top'])):
                            ?><tr><th colspan="<?php
                                $colspan = count($field_list) + 2;

                                echo $colspan;
                                ?>"><?php
                                        echo $this->load->view('elements/index_action_top_menu');
                                        ?> <button type="submit" id="this_update_button" class="btn btn btn-sm btn-primary"><span class="fa fa-save"></span> <?php echo lang('Update'); ?></button></th></tr><?php
                                endif;
                            endif;
                        endif;
                        ?>
                <tr>

                    <th>#</th>

                    <?php
                    if (isset($rs_action)):
                        $checkbox = '<input type="checkbox" id="input_check_select_all">';
                        printf('<th nowrap="nowrap">%s %s</th>', $checkbox, lang('Select'));
                    endif;
                    foreach ($field_list as $idx => $field):
                        $text = isset($masked_field_list[$idx]) ? $masked_field_list[$idx] : $field;
                        $text = lang($text);
                        if (in_array($field, $field_no_sorting)) {
                            printf('<th>%s</th>', $text);
                            continue;
                        }
                        $dir  = 'asc';
                        $attr = array();
                        if ($order_by == $idx):
                            $dir           = $sort_order;
                            $attr['class'] = 'text-success';
                        endif;
                        $segment    = sprintf('%s/%s/%s/0/1/%s/%s/%s', $mod, $controller, $method, $per_page, $idx, $dir);
                        $icon_class = $dir == 'asc' ? 'fa-caret-down' : 'fa-caret-up';
                        $text       .= sprintf('&nbsp;<span class="fa %s"></span>', $icon_class);



                        printf('<th nowrap="nowrap" >%s</th>', anchor($segment, $text, $attr));
                    endforeach;
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($ls_index as $i => $r):
                    
                    ?>
                    <tr>

                        <td><?php echo $rs_offset + $i; ?></td>
                        <td>
                            <input type="checkbox" class="input_check_select" name="input_check_select[]" value="<?php echo $r->id; ?>"<?php echo isset($ls[$r->id] ) ? ' checked="checked"' : '';?>><?php // echo $r->id; 
                        ?></td>
                            <?php
//                        if (isset($rs_action)):
//                            $action = $this->load->view($rs_action['tpl'], compact('rs_action', 'r'), true);
//                            printf('<td nowrap="nowrap">%s</td>', $action);
//                        endif;
                            foreach ($field_list as $idx => $field):

                                if (!property_exists($r, $field)):
                                    printf('<td>%s</td>', '-');
                                    continue;
                                endif;
                                $css_class = "";
                                if ($order_by == $idx):
                                    $css_class = "text-success";
                                endif;
                                $text = $r->{$field};
                                if (isset($call_user_func)) {
                                    if (isset($call_user_func[$field])) {
                                        $text = call_user_func($call_user_func[$field]['callable'], $text);
                                    }
                                }
                                if (isset($currency_field_list)) {
                                    if (in_array($field, $currency_field_list)) {
                                        $text = lang('#CURRENCY_SYMBOL') . " " . number_format($text, 2, ",", ".");
                                    }
                                }
                                if (isset($date_field_list)) {
                                    if (isset($date_field_list[$field])) {

                                        $text = date($date_field_list[$field], strtotime($text));
                                    }
                                }
                                $cell_alignment = "";
                                if (isset($cell_alignments)) {
                                    $cell_alignment = isset($cell_alignments[$field]) ? $cell_alignments[$field] : "";
                                }
                                $nowrap = '';
                                if (isset($cell_nowrap)) {
                                    $nowrap = in_array($field, $cell_nowrap) ? ' nowrap="nowrap"' : "";
                                }
                                printf('<td class="%s" align="%s" %s>%s</td>', $css_class, $cell_alignment, $nowrap, $text);
                            endforeach;
                            ?>
                    </tr>

                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </form>
</div>
