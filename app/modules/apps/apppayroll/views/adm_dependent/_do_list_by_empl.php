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
?>
<br>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
        </thead>
        <tbody>

            <tr>
                <td width="200"><?php echo lang('NIPP'), ' - ', lang('Name'); ?></td>
                <td><?php echo $detail->nipp; ?> - <?php echo $detail->name; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Latest Status'); ?></td>
                <td><?php echo $detail->mar_stat; ?>
                    <?php
                    echo $detail->alw_rc_sp_cnt ? lang('and get the rice allowance') : '';
                    ?>
                </td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Latest Spouse'); ?></td>
                <td><?php echo $detail->text; ?></td>
            </tr>
            <tr>
                <td width="200"><?php echo lang('Since'); ?></td>
                <td><?php
                    if ($detail->eff_date):
                        echo date('d/m/Y', strtotime($detail->eff_date));
                    endif;

                    if ($detail->term_date):
                        echo date(' - d/m/Y', strtotime($detail->term_date));
                    endif;
                    ?></td>
            </tr>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>    
<?php
echo $pagination;
?>
<div>
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
                                    ?></th></tr><?php
                    endif;
                endif;
            endif;
            ?>
            <tr>

                <th>#</th>
                <?php
                if (isset($rs_action)):
                    printf('<th nowrap="nowrap">%s</th>', lang('Action'));
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
                    $segment    = sprintf('%s/%s/%s/%s/1/%s/%s/%s', $mod, $controller, $method, $detail->id, $per_page, $idx, $dir);
                    $icon_class = $dir == 'asc' ? 'fa-caret-down' : 'fa-caret-up';
                    $text       .= sprintf('&nbsp;<span class="fa %s"></span>', $icon_class);



                    printf('<th nowrap="nowrap" >%s</th>', anchor($segment, $text, $attr));
                endforeach;
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($ls as $i => $r):
                ?>
                <tr>

                    <td><?php echo $rs_offset + $i; ?></td>
                    <?php
                    if (isset($rs_action)):
                        $action = $this->load->view($rs_action['tpl'], compact('rs_action', 'r'), true);
                        printf('<td nowrap="nowrap">%s</td>', $action);
                    endif;
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
                                if ($text) {
                                    $text = date($date_field_list[$field], strtotime($text));
                                }
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
</div>
