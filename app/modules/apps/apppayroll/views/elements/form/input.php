<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!isset($input))
    return;
if (!is_array($input))
    return;
extract($input);

$after_input  = isset($after_input) ? $after_input : '';
$before_input = isset($before_input) ? $before_input : '';
$col_lg       = isset($col_lg) ? $col_lg : '8';
$col_sm       = isset($col_sm) ? $col_sm : '8';
$empty        = isset($empty) ? $empty : false;
$err_msg      = isset($err_msg) ? $err_msg : false;
$escape       = isset($escape) ? $escape : true;
$field_alias  = isset($field_alias) ? $field_alias : random_string('unique');
$input_attr   = isset($input_attr) ? $input_attr : array();
$label        = isset($label) ? $label : $field_alias;
$list_options = isset($list_options) ? $list_options : array();
$maxlength    = isset($maxlength) ? $maxlength : '100';
$multiple     = isset($multiple) ? $multiple : false;
$placeholder  = isset($placeholder) ? $placeholder : '';
//$readonly     = isset($readonly) ? $readonly : false;
$required     = isset($required) ? $required : false;
$row          = isset($row) ? $row : '5';

$type  = isset($type) ? $type : 'text';
$value = isset($value) ? $value : '';

$selected_list = is_array($value) ? $value : array();

if (!is_array($input_attr)):
    $input_attr = array();
endif;
$input_attr_parsed = ' ';
if ($input_attr):
    foreach ($input_attr as $key => $val):
        $input_attr_parsed .= sprintf(' %s="%s" ', $key, $val);
    endforeach;
endif;

if ($escape):
    $value = html_escape($value);
endif;

//set tag open
if ($type != 'hidden'):
    $error_text          = $err_msg ? 'error' : '';
    $required_text       = $required ? 'required' : '';
    $required_text_input = $required ? 'required="required"' : '';
    printf('<div class="form-group %s">', $required_text);
    printf('<label for="%s" class="col-lg-2 col-sm-2 control-label">%s</label>', $field_alias, $label);
    printf('<div class="col-lg-%s col-sm-%%s">', $col_lg, $col_sm);
endif;

echo $before_input;

switch ($type):
    default: //text password email tel number
        printf('<input name="data[%s]" class="form-control %7$s" maxlength="%2$s" type="%3$s" id="%1$s" %4$s value="%5$s" placeholder="%6$s" %8$s/>', $field_alias, $maxlength, $type, $required_text_input, $value, $placeholder, $error_text, $input_attr_parsed);
        break;
    case 'checkbox':
        if ($list_options):
            $n = 0;
            printf('<div class="row-fluid">');
            //$list_options = array_merge($list_options, range(30000,30020));
            foreach ($list_options as $key => $val):
                if ($n % 3 == 0):
                    printf('</div>');
                    printf('<div class="row-fluid">');
                endif;
                $checked_text = in_array($key, $selected_list) ? 'checked="checked"' : '';
                $checkbox     = sprintf('<input name="data[%s][]" type="%s" %s value="%s" %s>%s', $field_alias, $type, $checked_text, $key, $input_attr_parsed, $val);
                printf('<label class="checkbox-inline col-sm-3 col-lg-3">%s</label>', $checkbox);
                $n++;
            endforeach;
            printf('</div>');
        endif;

        break;
    case 'date':

        printf('<input name="data[%s]" type="%s" id="%1$s" value="%s" class="%s form-control form-date-input" %s />', $field_alias, 'text', $value, $error_text, ' '.$required_text_input.' '.$input_attr_parsed);
        /**
          <input
         *  name="data[ScmContentPublished][text]"
         *  class="form-control form-date-input"
         *  type="text"
         *  id="ScmContentPublishedText"/>
         *
         */
        break;
    case 'datetime':
        $value_date = date('Y-m-d'); //yyyy-mm-dd
        $value_hour = '00'; //hh
        $value_minute = '00'; //ii
        if ($value) {
            if (is_array($value)) {
                $value_date = $value['date'];
                $value_hour = $value['hour'];
                $value_minute = $value['minute'];
            } else {
                $value_date   = substr($value, 0, 10);
                $value_hour   = substr($value, 11, 2);
                $value_minute = substr($value, 14, 2);//1234-67-90-23-56
                
            }
        }
        printf('<input name="data[%s][date]" type="date" id="%1$sdate" value="%s" class="%s form-control form-date-input" %s />', $field_alias, $value_date, $error_text, $input_attr_parsed);
        printf('<div style="display:inline-block;width:250px;"><select id="%shour" name="data[%1$s][hour]" class="form-control col-sm-1 col-lg-1" style="width:80px;display:inline;">', $field_alias);
        $hours = range(0, 23);
        foreach ($hours as $r):
            $hr       = str_pad($r, 2, '0', STR_PAD_LEFT);
            $selected = ($value_hour == $hr) ? 'selected="selected"' : '';
            printf('<option value="%s" %s>%1$s</option>', $hr, $selected);
        endforeach;
        printf('</select>');
        printf('<select id="%sminute" name="data[%1$s][minute]" class="form-control col-sm-1 col-lg-1" style="width:80px; display:inline;">', $field_alias);
        $minutes = range(0, 59);
        foreach ($minutes as $r):
            $mn       = str_pad($r, 2, '0', STR_PAD_LEFT);
            $selected = ($value_minute == $mn) ? 'selected="selected"' : '';
            printf('<option value="%s" %s>%1$s</option>', $mn, $selected);
        endforeach;
        printf('</select></div>');
        break;
    case 'file': //hidden
        printf('<input name="%s" class="form-control %7$s" maxlength="%2$s" type="%3$s" id="%1$s" %4$s value="%5$s" placeholder="%6$s" %8$s/>', $field_alias, $maxlength, $type, $required_text_input, $value, $placeholder, $error_text, $input_attr_parsed);
        break;
    case 'hidden': //hidden
        printf('<input name="data[%s]" type="%s" id="%1$s" value="%s" %s/>', $field_alias, $type, $value, $input_attr_parsed);
        break;
    case 'select':
        if ($list_options):
            $multiple_text        = $multiple ? 'multiple' : '';
            $multiple_name_suffix = $multiple ? '[]' : '';
            printf('<select id="%s" name="data[%1$s]%s" class="form-control" %s %s %s>', $field_alias, $multiple_name_suffix, $multiple_text, $input_attr_parsed, $required_text);
            if ($empty)
                printf('<option value="%s">%s</option>', '', ''); //allow empty
            foreach ($list_options as $i => $r):
                $selected = ($value == $i) ? 'selected="selected"' : '';
                printf('<option value="%s" %s>%s</option>', $i, $selected, $r);
            endforeach;
            printf('</select>');
        endif;
        break;
    case 'textarea':
        echo <<<TEXT
        <textarea name="data[{$field_alias}]" class="form-control {$error_text}" id="{$field_alias}" placeholder="{$placeholder}" {$required_text_input} row="{$row}" {$input_attr_parsed} >{$value}</textarea>
TEXT;
        break;
endswitch;

if ($type != 'hidden'):
    if ($err_msg):
        printf('<div class="alert alert-danger help-inline alert-dismissible alert-auto-dismiss">%s</div>', $err_msg);
    endif;
    printf('</div></div>');
endif;
echo $after_input;

/* End of file input.php */
/* Location: ./application/views/elements/form/input.php */