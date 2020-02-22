<?php

if (!isset($top_menu))
    return;
if (!$top_menu)
    return;
?>
<div class="row">
    <div class="col-xs-12">
        <ul class="nav nav-tabs">
            <?php
            foreach ($top_menu as $i => $v):
                //use full query string to match active menu
                $full_url_for_active = isset($v['full_url_for_active']) ? $v['full_url_for_active'] : false;
                $route_prefix = isset($v['route_prefix']) ? $v['route_prefix'] : "";
                $route_class = $this->router->fetch_class();
                $route_method = $this->router->fetch_method();
                $base_route = $route_prefix.$route_class . '/' . $route_method;
                if(isset($v['show_on'])):
                    if($v['show_on']):
                        if(!in_array($base_route, $v['show_on'])):
                            continue;
                        endif;
                    endif;
                endif;
                $active = false;
                $segment = $route_prefix.$v['class'] . '/' . $v['method'];
                if($full_url_for_active !== true){
                    $active = $segment == $base_route ? true : false;
                }
                if(isset($v['query_string'])):
                    if($v['query_string']):
                        $segment .= '/'. implode('/',$v['query_string']);
                    endif;
                endif;
                if($full_url_for_active === true){
                    
                    $active = site_url($segment) == current_url() ? true : false;
                }
                echo '<li role="presentation"';
                echo $active ? ' class="active"':'';
                echo '>';
                echo anchor($segment, $v['text'], $v['attr']);
                echo '</li>';
            endforeach;
            ?></ul>
        <br>
    </div>
</div>