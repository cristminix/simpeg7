<?php

/*
 * The MIT License
 *
 * Copyright Error: on line 6, column 29 in Templates/Licenses/license-mit.txt
  The string doesn't match the expected date/time format. The string to parse was: "03 Feb 16". The expected format was: "MMM d, yyyy". Tris.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
$list     = isset($val) ? $val : array();

$base_url = base_url();
//init html
$li       = '<li class="%s">%s</li>';
$a        = '<a class="%s" href="%s">%s %s %s</a>';
$class    = "";
$url      = $list->slug == '#' ? $list->slug : site_url($list->slug);
#$current   = $val->menu_id == $current_menu_id ? 'current' : '';
//$current   = str_replace('/','',str_replace('/index','',$val->slug)) == str_replace('/','',str_replace('/index','',$current_menu_slug)) ? 'current' : '';
$content   = sprintf($a, $val->current, $url, $val->menu_text_before, $list->menu_text, $list->menu_text_after);
$valid     = $list->id;
$has_child = isset($app_main_menu_child[$valid]) ? true : false;
if($list->slug == "#" && !$has_child):
    return;
endif;

if ($has_child):
    $content .= '<ul>';
    foreach ($app_main_menu_child[$valid] as $key => $val):
        $content .= $this->load->view('elements/page_sidebar_child', compact('val', 'app_main_menu_all', 'app_main_menu_child', 'current_menu_id'), true);
    endforeach;
    $content .= '</ul>';

endif;
printf($li, $class, $content);


// 

/* End of file page_sidebar_child.php */
/* Location: ./application/views/elements/page_sidebar_child.php */
