<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($per_page_options);
if(!isset($per_page_options)){
    return;
}
if(!$per_page_options){
    return;
}
extract($per_page_options);
?>
    <ul class="pagination">
        <li class="pagination-list"><a ><?php echo lang('Records per page');?> :</a></li>
    <?php
    foreach ($list as $val):
        if($val > $total_rows){
            continue;
        }
        if($val == $current){
            printf('<li class="active pagination-list"><a href="#">%s</a></li>', $val);
            continue;
        }
        printf('<li class="pagination-list"><a href="%s">%s</a></li>', $url_prefix . $val . $url_suffix, $val);
    endforeach;
    $showall = lang('Show all');
    $active = $current == $total_rows ? ' active' : '';        
    printf('<li class="pagination-list%s"><a href="%s">%s: %s</a></li>', $active, $url_prefix . $total_rows . $url_suffix, $showall, $total_rows);
    ?></ul>