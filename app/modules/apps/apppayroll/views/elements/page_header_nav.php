<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand ">
                <?php
                
                echo anchor(index_page(), $this->config->item('admpr_app_name') . ' - '.$this->config->item('admpr_app_ver'));
                ?>
            </div>
            <!--div class="navbar-brand collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                
                </div-->
        </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?php echo $usr->nama_user;?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                          //  printf('<li>%s</li>', anchor('sysadmin', '<span class="fa fa-user"></span> ' . lang('profile')));
                            printf('<li>%s</li>', anchor('login/out', '<span class="fa fa-sign-out"></span> ' . lang('Sign Out')));
                            /*
                              if (isset($profileMenu)):
                              if ($profileMenu):
                              foreach ($profileMenu as $i => $v):
                              if (isset($v['resources_type'])):
                              if ($v['resources_type'] == 'cake_anchor'):
                              ?><li>
                              <?php
                              echo $this->SysHtml->resToCakeUrl($v);
                              ?>
                              </li><?php
                              endif;
                              if ($v['resources_type'] == 'bs_dropdown_sep'):
                              ?><li role="separator" class="divider"></li><?php
                              endif;
                              endif;
                              endforeach;
                              endif;
                              endif;
                             */
                            ?>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-right">
                    <!--input type="text" class="form-control" placeholder="Search..."-->
                </form>
            </div>
        </div>
</nav>

