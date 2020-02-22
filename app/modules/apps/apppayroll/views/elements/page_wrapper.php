<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo $page_header_nav; ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php echo $page_sidebar; ?>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php
            $toggle_filter = '';
            if (isset($page_form_filter)):
                $showfilter_text = lang('Filter Shown');
                $hidefilter_text = lang('Filter Hidden');
                $toggle_filter   = <<<TOGGLE
                <input data-toggle="toggle" data-on="<i class='fa fa-filter'></i> {$showfilter_text}" data-off="<i class='fa fa-filter'></i> {$hidefilter_text}" type="checkbox" id="toggle-filter"> 
TOGGLE;
            endif;
            ?>

            <?php
            // echo $this->load->view('elements/page_action_top_menu');
            echo $this->load->view('elements/flash_message');
            echo isset($page_title) ? sprintf('<h3>%s%s</h3>', $toggle_filter, $page_title) : $toggle_filter;
            echo isset($page_form_filter) ? $page_form_filter  : "";
            echo $page_content;
            ?>
        </div>
    </div>
</div>