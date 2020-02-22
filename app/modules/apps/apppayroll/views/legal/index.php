<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mod        = $this->router->fetch_module();
$controller = $this->router->fetch_class();
$method     = $this->router->fetch_method();

$raw_token          = date('Y-m-d') . $controller . $this->session->userdata('sf_sess_uid') . $this->session->userdata('session_id');
$delete_token       = md5($raw_token);
$delete_form_id     = md5('delete_form' . $delete_token);
$delete_input_id    = md5('delete_input_id' . $delete_token);
$delete_input_token = md5('delete_input_token' . $raw_token);
if (!$ls) :
    printf('<h4>%s</h4>', lang('Empty record'));
    return;
endif;

$field_no_sorting = array(
    'role',
);


//echo $page_form_filter;
echo $pagination;
?>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
            <tr>

                <th>#</th>
                <?php
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
                    $text .= sprintf('&nbsp;<span class="fa %s"></span>', $icon_class);

                    printf('<th nowrap="nowrap">%s</th>', anchor($segment, $text, $attr));
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
                        if ($field == 'gender') {
                            $text = strtoupper($text);
                        }
                        printf('<td class="%s">%s</td>', $css_class, $text);
                    endforeach;
                    ?>
                </tr>

                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<form id="<?php echo $delete_form_id; ?>" method="post">
    <input type="hidden" name="_method" value="POST" />
    <input type="hidden" id="<?php echo $delete_input_id; ?>" name="<?php echo $delete_input_id; ?>"  />
    <input type="hidden" id="<?php echo $delete_input_token; ?>" name="<?php echo $delete_input_token; ?>" />
</form>