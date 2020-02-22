<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!isset($rs_action)):
    return;
endif;
if (!isset($rs_action['view_data'])):
    /**
     * $rs_action['view_data'] = array(
     *      'id_alias',
     *      'action_list' => array(
     *          'r', // read
     *          'e', // edit
     *          'd', // delete
     *      ),
     * )
     */
    return;
endif;
if (!isset($r)):
    return;
endif;
extract($rs_action['view_data']);
if (!isset($action_list)):
    return;
endif;
if (!$action_list):
    return;
endif;
$id_alias   = isset($id_alias) ? $id_alias : 'id';
$lock_alias = isset($lock_alias) ? $lock_alias : 'locked';
if (!property_exists($r, $id_alias)):
    return;
endif;
foreach ($action_list as $key => $val):
    if(isset($val['show_by_field'])){
        if (!property_exists($r, $val['show_by_field'])){
            continue;
        }
        if(!$r->{$val['show_by_field']}){
            continue;
        }
    }
    if (in_array($key, array('e', 'd'))):
        if (property_exists($r, $lock_alias)):
            $do_lock = false;
            if($r->{$lock_alias}){
                if($key == 'd'){
                    $do_lock = true;
                    $lock_title = lang('Locked for deletion');
                }
                if($key == 'e'){
                    if(isset($val['locked'])){
                        if($val['locked']){
                            $do_lock = true;
                            $lock_title = lang('Locked for editing');
                        }
                    }
                }
            }

            if ($do_lock):
                echo '  <a href="#" title="' . $lock_title . '"><span class="fa fa-lock fa-border fa-fw text-danger"></span></a>  ';
                continue;
            endif;
        endif;
    endif;
    $url  = sprintf($val['url'], $r->{$id_alias});
    $text = $val['text'];

    $html = <<<ACT
    <a href="{$url}">{$text}</a>
ACT;

    echo $html;
endforeach;