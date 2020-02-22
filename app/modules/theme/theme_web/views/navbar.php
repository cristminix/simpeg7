    <div class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0px;border-top:1px solid #eee;">
      <div class="container">
        <div class="navbar-header"  style="clear:both;">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div style="padding:15px 0px 0px 15px;"><?php date_default_timezone_set('Asia/Jakarta');?> <?=date('D');?>, <?=date('d-m-Y');?></div>
        </div><!--/.navbar-header -->
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form" method="POST" action="<?=site_url('login');?>">
            <button type="submit" class="btn btn-success">Login</button>
          </form>
		  		<?=$list_menu;?>
        </div><!--/.navbar-collapse -->
      </div><!--/.container-->
    </div><!--/.navbar -->

