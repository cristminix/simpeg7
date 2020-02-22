<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    // var_dump($ls);
    // echo bin2hex('inoshadi@gmail.com').'<hr>';
    
    echo (2019 % 10).'<hr>';
    $config = $this->config->item('apppayroll_log_archive_salt');
    $lines = [];
    
foreach ((array) $ls as $i => $r):
    $line = [];
    foreach($r as $xx):
        echo $xx . '<br>';
        $x = $config . bin2hex($xx). $config;
        $hex =bin2hex($x); 
        $line[] = $hex;
        echo $hex . '<br>';
        $bin = hex2bin($hex);
        echo $bin . '<br>';
        $e = explode($config, $bin);
        print_r($e);
        echo '<br>' . hex2bin($e[1]).'<br>-<br>';
    endforeach;        
    $lines[] = implode('|',$line);
    echo '<hr>';
    
endforeach;
echo "<pre>";
echo json_encode($lines);