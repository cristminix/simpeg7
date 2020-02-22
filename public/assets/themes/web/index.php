<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title><?=$nama_app;?> | <?=$slogan_app;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('public/assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?=base_url('public/assets/css/font-awesome/4.2.0/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- jQuery Version 1.11.0 -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/jquery/jquery-1.11.0.min.js');?>"></script>
    <!-- Bootstrap Core JavaScript -->
	<script type="text/javascript" src="<?=base_url('public/assets/js/bootstrap.min.js');?>"></script>

</head>


  <body  style="padding-top:0px;">

<div class="headertt">
<?php
echo Modules::run("theme_web/header/index");
echo Modules::run("theme_web/navbar/index","0");
?>
</div><!--//header-->


<style>
.panel.panel-default .panel-body  {	padding:0px;	}
.panel-default .panel-heading  { padding:7px 0px 3px 7px; border-bottom: 1px dotted #ccc; color:#0000FF;	}
.panel-default .panel-body .nav-tabs { background-color:#eee;padding-left:5px;padding-top:3px; }
.panel-default .panel-body .nav-tabs li a { padding-right: 5px; padding-left: 5px; padding-top:7px; padding-bottom:7px; margin-left:0px;	}

.panel.panel-baru  {border: 1px solid #ccc;	}
.panel-baru .panel-heading  { padding:7px 0px 3px 7px; background-color:#ddd; border-bottom: 1px solid #ccc; color:#0000FF;	}
.panel-baru .panel-body  {padding:0px;background-color:#eee;	}
.panel-baru .panel-body .col-lg-12  {padding:0px 8px 0px 8px;	}
.panel-baru .panel-body .col-lg-6  {padding:0px 8px 0px 8px;	}

.item { clear:both; border-bottom: 1px solid #ccc; display:table; width:100%; cursor:pointer; }
.item:hover { color:#FF0000; }
.item .atas {	font-weight:bold;	}
.item .kiri { float:left;background-color:#FFFF00;width:40%; }
.item .kanan { padding-left:10px; float:left;background-color:#00FFFF;width:60%; }
</style>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Selamat datang!</h1>
        <p>Selamat datang di Aplikasi Sistem Informasi Kepegawaian daerah (SIKDA) yang dikembangkan oleh Badan Kepegawaian, Pendidikan dan Pelatihan Pemerintah Kota Tangerang.</p>
        <p><a class="btn btn-primary btn-lg" role="button">Pelajari lebih lanjut &raquo;</a></p>
      </div>
    </div>

    <div class="container">
  <div class="row" style="display:none;">
					<div class="col-lg-8">
		<div class="panel panel-default">
                        <div class="panel-body">
							<div class="panel-heading"><b>PANEL BARU</b></div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tugas_pokok" data-toggle="tab"><i class="fa fa-briefcase"></i> Tugs pok</a></li>
                                <li><a href="#tugas_tambahan" data-toggle="tab" id="key_tugas_tambahan"><i class="fa fa-ra"></i> Tugs lain</a></li>
                                <li><a href="#kreatifitas" data-toggle="tab" id="key_kreatifitas"><i class="fa fa-trophy"></i> Kreattas</a></li>
                            </ul>
                            <!-- Tab panes -->
							<div style="padding:10px;">
										<div class="item">Yang ini baru item</div>
										<div class="item">Yang ini baru item</div>
										<div class="item">Yang ini baru item</div>
							</div>
						</div>
                        <!-- panel body -->
		</div>
        <!-- panel -->

							<div class="panel panel-baru">
								<div class="panel-heading"><b>PANEL BARU</b></div>
								<div class="panel-body">
									<div>
									<div class="col-lg-12">
										<div>ini bukan item</div>
										<div class="item">Yang ini baru item</div>
										<div class="item">
											<div class="kiri">jka hah ajd sdj  asdg asgdhg ashgdh hasgdhg asdg jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
											<div class="kanan">jkjk ni block kiri asdgh kaggsd hawe hasdgh ahsgdh hasdgh ri</div>
										</div>
										<div class="item">
											<div class="kiri">jkjk ni block kiri asdgh kaggsd</div>
											<div class="kanan">jk sdfh sdjfh sjdhf jshdfa hah ajd sdj  asdg asgdhg ashgdh hasgdhg asdg jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
										</div>
										<div>ini juga bukan item</div>
									</div>
									</div>
								</div>
							</div>
							<div class="panel panel-baru">
								<div class="panel-heading"><b>PANEL BARU</b></div>
								<div class="panel-body">
									<div>
									<div class="col-lg-6">
										<div class="item">ini block kiri ri ri ri ri</div>
										<div class="item">ini block kiri ri ri ri ri</div>
										<div class="item">
											<div class="atas">JUDULNYA</div>
											<div class="kiri">jkjk ni block kiri ri</div>
											<div class="kanan">jka hah ajd sdj jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
										</div>
										<div class="item">
											<div class="atas">JUDULNYA</div>
											<div class="kiri">jkjk ni block kiri ri</div>
											<div class="kanan">jka hah ajd sdj jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
										</div>
										<div class="item">
											<div class="atas">JUDULNYA</div>
											<div class="kiri">jkjk ni block kiri ri</div>
											<div class="kanan">jka hah ajd sdj jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
										</div>
										<div class="item">ini block kiri ri ri ri ri</div>
										<div class="item">ini block kiri ri ri ri ri</div>
									</div>
									<div class="col-lg-6">
										<div class="item">
											<div class="kiri">jkjk ni block kiri ri</div>
											<div class="kanan">jka hah ajd sdj jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
										</div>
										<div class="item">ini block ka n nnn nan... jaklsdj jaljds jkajsd jkasdj asdjk jkjasd</div>
										<div class="item">ini b cc ll oo lock kanan... jaklsdj jaljds jkajsd jkasdj asdjk jkjasd</div>
										<div class="item">
											<div class="kiri">jka hah ajd sdj jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
											<div class="kanan">jkjk ni block kiri ri</div>
										</div>
									</div>
									</div>
									<div style="clear:both;padding-top:20px;">
									<div class="col-lg-6">
										hjhj kkjj
									</div>
									<div class="col-lg-6">
										hjhj kkjj
									</div>
									</div>
									<div style="clear:both;padding-top:20px;">
									<div class="col-lg-12">
										hjhj kkjj
									</div>
									</div>
								</div>
							</div>
					</div>



					<div class="col-lg-4">
							<div class="panel panel-baru">
								<div class="panel-heading"><b>PANEL BARU</b></div>
								<div class="panel-body">
									<div>
									<div class="col-lg-12">
										<div>ini bukan item</div>
										<div class="item">
											<div class="kiri">jka hah ajd sdj  asdg asgdhg ashgdh hasgdhg asdg jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
											<div class="kanan">jkjk ni block kiri asdgh kaggsd hawe hasdgh ahsgdh hasdgh ri</div>
										</div>
										<div class="item">
											<div class="kiri">jkjk ni block kiri asdgh kaggsd</div>
											<div class="kanan">jk sdfh sdjfh sjdhf jshdfa hah ajd sdj  asdg asgdhg ashgdh hasgdhg asdg jaljds jkajsd jka sdj jaljds jkajsd jka ahdg jk</div>
										</div>
										<div>ini juga bukan item</div>
									</div>
									</div>
									<div style="clear:both;">
									<div class="col-lg-12">
										jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
										jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
										jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
										jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
									</div>
									</div>
								</div>
							</div>
		<div class="panel panel-default">
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tugas_pokok" data-toggle="tab"><i class="fa fa-briefcase"></i> Tug okok</a></li>
                                <li><a href="#tugas_tambahan" data-toggle="tab" id="key_tugas_tambahan"><i class="fa fa-ra"></i> Tugas lain</a></li>
                                <li><a href="#kreatifitas" data-toggle="tab" id="key_kreatifitas"><i class="fa fa-trophy"></i> Kreas</a></li>
                            </ul>
                            <!-- Tab panes -->
							<div style="padding:10px;">
							jahsd jashd<br>
							jahsd jashd<br>
							jahsd jashd<br>
							</div>
						</div>
                        <!-- panel body -->
		</div>
        <!-- panel -->
							<div class="panel">
								<div class="panel-body" style="padding:2px;">
								jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
								jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
								jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
								jaklsdj jaljds jkajsd jkasdj asdjk jkjasd
								</div>
							</div>
					</div>
</div>
<!-- /.row -->

      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Data Kepegawaian</h2>
          <p>Data Pegawai berisikan biodata, riwayat pendidikan, riwayat kepegawaian, kepangkatan, jabatan dan pelatihan. </p>
          <p><a class="btn btn-default" href="#" role="button">Selengkapnya &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>SKP Online</h2>
          <p>Sasaran Kinerja Pegawai secara online telah dikembangkan oleh BKPP tidak hanya sebagai penerapan dari PP 46 tahun 2011 namun juga sebagai dasar pembayaran Tunjangan Prestasi Pegawai (TPP). </p>
          <p><a class="btn btn-default" href="#" role="button">Selengkapnya &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Dokumen Elektronik</h2>
          <p>Dokumen Pegawai diubah dari bentuk Fisik menjadi bentuk Elektronik (Scan - Upload).</p>
          <p><a class="btn btn-default" href="#" role="button">Selengkapnya &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; BKPP Kota Tangerang 2014</p>
      </footer>
  </body>
</html>
