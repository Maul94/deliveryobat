<?php setlocale(LC_TIME, "IND"); ?>
<!-- <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables.bootstrap5.css"> -->
<!-- <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css"> -->
<!-- <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/bootstrap-select/bootstrap-select.css" /> -->
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.min.css" />
<h4 class="fw-bold py-2 mb-2"><?= $pageTitle ?></h4>
<!-- Basic Layout -->
<div class="row" id="no-print-this">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
                Laporan Pendapatan
            </div>
            <div class="card-body justify-content-center">
                <form id="form-id" method="POST" action="<?= base_url('print_report') ?>" target="_blank">
                    <div class="row card-text mb-2">
                        <div class="col-4 text-end">
                            <div>Jenis Laporan</div>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm" value="Harian" id="reportType" name="reportType" readonly>
                        </div>
                    </div>
                    <div class="row card-text mb-2">
                        <div class="col-4 text-end">
                            <div>Tanggal</div>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm flatpickr-input" id="reportDate" name="reportDate" placeholder="Tanggal Pengiriman" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="row card-text mb-5">
                        <div class="col-4 text-end">
                            <div>Unit</div>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm" value="RSUD R.A. Basoeni" id="unit_id" name="unit_id" readonly>
                        </div>
                    </div>
                    <div class="row card-text mb-2">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-info btn-sm"><i class='bx bxs-report me-1'></i>Tampilkan</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- <div class="modal fade" id="modal-Detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <dl class="row mt-2" id="print-it"></dl>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-between">
                        <button id="cetak" class="btn btn-secondary">Cetak <i class="bx bx-printer bx-sm me-sm-n2"></i></button>
                        <button class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  -->
<script src="<?= config_item('assets'); ?>vendor/libs/i18n/datepicker-id.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/id.js"></script>
<!-- <script src="<?= config_item('assets'); ?>vendor/libs/datatables/jquery.dataTables.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-responsive/datatables.responsive.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/printThis/printThis.min.js"></script> -->
<script type="text/javascript">
    /* Flatpickr */
    flatpickr('#reportDate', {
        locale: "id",
        // allowInput: true,
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        disableMobile: true,
        onChange: function(selectedDates, dateStr, instance) {
            // dataTable.ajax.url('<?= base_url('deliveryjson/') ?>'+$('#delDate').val()).load();
        },
    });
    /* end Flatpickr */
</script>