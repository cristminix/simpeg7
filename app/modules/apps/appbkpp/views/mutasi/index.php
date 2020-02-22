<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?= $satu; ?></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="content-wrapper" style="padding-bottom:30px;">

    <div class="row">
        <div class="col-lg-3">
            <form id="cari_nip" method="post">
                <div class="form-group input-group">
                    <input class="form-control" type="text" name="nip" id="nip" placeholder="Masukkan NIP...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="cari_nip();"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <!-- /.col-lg-3 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.content -->
<div id="form-wrapper" style="padding-bottom:30px; display:none;"></div>

<script type="text/javascript">
    function cari_nip() {
        $.ajax({
            type: "POST",
            url: "<?= site_url(); ?>appbkpp/mutasi/cari_nip",
            data: $("#cari_nip").serialize(),
            beforeSend: function () {
                $('#content-wrapper').hide();
                $('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>').show();
            },
            success: function (data) {
//			if((data.id_pegawai.length)>0){
                if (data.id_pegawai) {
                    setForm("jabatan", data.id_pegawai);
                } else {
                    alert("Pegawai dengan NIP tersebut TIDAK DITEMUKAN... Masukkan NIP Lain!!");
                    $('#content-wrapper').show();
                    $('#form-wrapper').hide();
                }
            }, // end success
            dataType: "json"}); // end ajax
    }

    function setForm(aksi, idd) {
        $.ajax({
            type: "POST",
            url: "<?= site_url(); ?>appbkpp/pegawai/form" + aksi,
            data: {"hal": 1, "batas": 1, "cari": 2, "idd": idd},
            beforeSend: function () {
                $('#content-wrapper').hide();
                $('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>').show();
            },
            success: function (data) {
                $('#form-wrapper').html(data);
            }, // end success
            dataType: "html"}); // end ajax
    }
    function batal(aksi, idd) {
        $('#content-wrapper').show();
        $('#form-wrapper').hide();
    }
</script>
<style>
    table th {	text-align:center; vertical-align:middle;	}
    .pagingframe {	float:right;	}
    .pagingframe div {	padding-left:7px;padding-right:7px;	}

    .panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>
