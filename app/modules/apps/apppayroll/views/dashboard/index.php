
<h1>Dashboard Sistem Informasi Gaji Pegawai</h1>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total['permanent']->cnt_gross_sal; ?></div>
                        <div><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($bruto['permanent']->sum_gross_sal, 2, ",", "."); ?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo lang('Probation & Permanent Employement'); ?></span>
                    <!--span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span-->
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-industry fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total['contract']->cnt_gross_sal; ?></div>
                        <div><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($bruto['contract']->sum_gross_sal, 2, ",", "."); ?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo lang('Contract Employement'); ?></span>
                    <!--span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span-->
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-institution fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total['directors']->cnt_gross_sal; ?></div>
                        <div><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($bruto['directors']->sum_gross_sal, 2, ",", "."); ?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo lang('Directors'); ?></span>
                    <!--span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span-->
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-legal fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total['supervisory_boards']->cnt_gross_sal; ?></div>
                        <div><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($bruto['supervisory_boards']->sum_gross_sal, 2, ",", "."); ?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo lang('Supervisory Boards'); ?></span>
                    <!--span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span-->
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-line-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo date('m/y',strtotime($ptp['permanent']->print_dt)); ?></div>
                        <div><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($ptp['permanent']->ptp, 2, ",", "."); ?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo lang('Employee Maximum Netpay (EMN)'); ?></span>
                    <!--span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span-->
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->