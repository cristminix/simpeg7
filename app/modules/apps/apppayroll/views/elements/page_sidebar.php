<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// if view var set $sys_app_main_menu
if(!isset($sys_app_main_menu)) return;

// if view var has values $sys_app_main_menu
if(!$sys_app_main_menu) return;

#$current_url = isset($current_url) ? base_url().$current_url : current_url();

//
extract($sys_app_main_menu);

//init html
$li = '<li class="%s">%s</li>';
$a = '<a class="font-12 %s" href="%s">%s %s %s</a>';

//buffer
$list = "";

// if view var set $app_main_menu_all
$app_main_menu_all = isset($app_main_menu_all) ? $app_main_menu_all : array();

// if view var has values $app_main_menu_all
if(!$app_main_menu_all) return;

//create root list if they dont have any parents
$root = array();
foreach ($app_main_menu_all as $key => $val):
    if(!isset($app_main_menu_all[$val->parent_id])){
        $root[] = $val; 
    }
endforeach;
$app_main_menu_child = isset($app_main_menu_child) ? $app_main_menu_child : array();
#debug($current_menu_slug);
#debug($root);
foreach($root as $key => $val):
   
    $list .= $this->load->view('elements/page_sidebar_child', compact('val','app_main_menu_all','app_main_menu_child', 'current_menu_id'), true);
endforeach;
echo <<<PRINT
<ul id="side-menu" class="sm sm-simple-clean sm-vertical ">
{$list}
</ul>
PRINT;


/* End of file page_sidebar.php */
/* Location: ./application/views/elements/page_sidebar.php */
