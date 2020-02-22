<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$base_theme = 'admin_payroll';

?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title><?php echo isset($page_title) ? $page_title : sprintf('%s :: %s', $this->router->fetch_method(), $this->router->fetch_class()); ?> :: <?php echo $this->config->item('admpr_app_name'), ' - ', $this->config->item('admpr_app_ver'); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/css/bootstrap-toggle.min.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/font-awesome-4.7.0/css/font-awesome.min.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/css/dashboard.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/smartmenus-1.0.0/css/sm-core-css.css'); ?>" />
        <?php
        $use_zebra_datepicker = isset($use_zebra_datepicker) ? $use_zebra_datepicker : false;
        
        $use_fileinput        = isset($use_fileinput) ? $use_fileinput : false;
        if ($use_zebra_datepicker):
            ?><link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/zebra_datepicker/zebra_datepicker-bootstrap.css'); ?>" /><?php
        endif;
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/smartmenus-1.0.0/css/sm-simple/sm-simple-clean.css'); ?>" />
           <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/js/jquery.min.js'); ?>"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/js/html5shiv.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/js/respond.min.js'); ?>"></script>
        <![endif]-->
        <?php if(isset($script_css)):
            foreach($script_css as $v):
                ?><link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/'.$base_theme.'/css/'.$v.'.css'); ?>" />
                    <?php
            endforeach;
        endif; ?>

        <link href="<?php echo base_url('assets/themes/'.$base_theme.'/favicon.png'); ?>" type="image/x-icon" rel="icon"/>
        <link href="<?php echo base_url('assets/themes/'.$base_theme.'/favicon.png'); ?>" type="image/x-icon" rel="shortcut icon"/>
        
    </head>
    <body>
        
        <?php echo $page_body; ?>      

        
  
    <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/js/ie10-viewport-bug-workaround.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/bootstrap-3.3.5-dist/js/bootstrap-toggle.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/smartmenus-1.0.0/jquery.smartmenus.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/js/sysScript.js'); ?>"></script>
    <?php
        if ($use_zebra_datepicker):
            ?><script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/zebra_datepicker/zebra_datepicker.js'); ?>"></script>
            <?php
        endif;
        if ($use_fileinput):
            ?><script type="text/javascript" src="<?php echo base_url('assets/themes/'.$base_theme.'/js/bootstrap.file-input.js'); ?>"></script>
            <?php
        endif;
        ?>
            <?php
        if (isset($page_js)):
            foreach ($page_js as $key => $val):
                printf('<script type="text/javascript" src="%s"></script>', $val);
            endforeach;
        endif;
        ?>
    </body>
</html>
