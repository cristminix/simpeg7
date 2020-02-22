<?php

if (!function_exists('debug')) {

    function debug($mixed, $print = true) {
        if (ENVIRONMENT != 'development') {
            return;
        }
        $content = "<pre>";
        ob_start();
        var_dump($mixed);
        $content .= ob_get_clean();
        $content .= "<pre>";
        if (!$print) {
            return $content;
        }
        echo $content;
    }

}