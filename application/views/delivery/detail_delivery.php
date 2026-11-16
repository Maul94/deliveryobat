<?php setlocale (LC_TIME, "IND"); ?>

<!-- Basic Layout -->
<div class="card mb-4">
    <?php
    if($ord_status == 1) {
    ?>
    <div class="alert alert-success d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2"><i class='bx bx-check fs-1'></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Selesai!</h6>
            <span>This is a success solid alert — check it out!</span>
        </div>
    </div>
    <?php
    }else if($ord_status == 2) {
    ?>
    <div class="alert alert-info d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-info border-label-info p-3 me-2"><i class='bx bxs-ambulance fs-1'></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Sedang dilayani!</h6>
            <span>This is a warning solid alert — check it out!</span>
        </div>
    </div>            
    <?php
    }else if($ord_status == 3) {
    ?>
    <div class="alert alert-warning d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2"><i class='fs-1'>!</i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Dalam Antrian!</h6>
            <span>This is a warning solid alert — check it out!</span>
        </div>
    </div>
    <?php
    }else if($ord_status == 4) {
    ?>
    <div class="alert alert-secondary d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-secondary border-label-secondary p-3 me-2"><i class='fs-1'>!</i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Harap Sabar Menunggu!</h6>
            <span>This is a warning solid alert — check it out!</span>
        </div>
    </div>
    <?php
    }else if($ord_status == 0) {
    ?>
    <div class="alert alert-danger d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2"><i class="bx bx-x fs-1"></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Dibatalkan!!</h6>
            <span>This is a danger solid alert — check it out!</span>
        </div>
    </div>
    <?php } ?>
    
    <div class="card-body py-0">
        <div class="row">
            <span class="text-light fw-semibold"><?= $px_name ?></span>
            <span class="text-light fw-semibold"><?= $px_norm ?></span>
            <dl class="mt-2">
                <div class="row">
                    <dt class="col-sm-3">No. Invoice</dt>
                    <dd class="col-sm-9"><?= $ord_invoice ?></dd>
                </div>
                <div class="row">
                    <dt class="col-sm-3">Tgl. Pemeriksaan</dt>
                    <dd class="col-sm-9 text-warning"><?= strftime("%e %B %Y", strtotime($ord_date)) ?></dd>
                </div>
                <div class="row">
                    <dt class="col-sm-3">Jenis Rawat Luka</dt>
                    <dd class="col-sm-9"><?= $item_name ?></dd>
                </div>
                <div class="row">
                    <dt class="col">Harga</dt>
                    <dd class="col text-end fw-bold text-danger" id="qwe"></dd>
                </div>
                
            </dl>
        </div>
    </div>
    <?php if ($ord_usr_id != 0) { ?>
    <hr class="my-0">
    <div class="card-body py-0">
        <div class="mt-2">
            <div class="row">
                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">
                    <?= $ord_detail_address ?>
                    <br><?= $ord_city ?> - <?= $ord_district ?><br><?= $ord_prov ?>
                </dd>
            </div>
            <hr>
            <dl class="row">
                <dt class="col-sm-3">Nama Petugas</dt>
                <dd class="col-sm-9"><?= $usr_fullname ?></dd>
            </dl>
        </div>
    </div>
    <?php } ?>
</div>

<div class="col-12 d-flex justify-content-end">
    <button type="button" data-bs-dismiss="modal" class="btn btn-label-secondary">Tutup</button>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#qwe').html(new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0}).format('<?= $item_total ?>', 3));
    });
</script>