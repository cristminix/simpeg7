<?php

if (!isset($rs_action)):
    return;
endif;
if (!isset($rs_action['view_data'])):
    return;
endif;
if (!isset($rs_action['view_data']['action_top'])):
    return;
endif;
$top_menu = $rs_action['view_data']['action_top'];
if (!$top_menu):
    return;
endif;
printf('<div class="btn-group"  role="group" >');
foreach ($top_menu as $i => $v):
//    $li_class = isset($v['li_class']) ? $v['li_class'] : '';
//    printf('<li class="%s"  role="presentation">', $li_class);
    $a_class  = isset($v['a_class']) ? $v['a_class'] : 'btn-default';
    $atts     = array(
        'class' => "btn btn-sm ".$a_class,
        'role'  => "button",
    );

    if(isset($v['anchor_popup'])){
        echo anchor_popup($v['url'], $v['text'], array_merge($atts,$v['anchor_popup']));
    }else{
        echo anchor($v['url'], $v['text'], $atts);
    }
    
//    printf('</li>');
endforeach;
printf('</div>');
?>