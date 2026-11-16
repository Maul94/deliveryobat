<?php setlocale (LC_TIME, "IND"); ?>
<!-- Basic Layout -->
<div class="card mb-4">
    <div class="card-body pb-0">
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
</div>

<div class="col-12 d-flex justify-content-between">
    <button type="button" data-bs-dismiss="modal" class="btn btn-label-secondary">Batal</button>
    <button id="savePayment" type="button" class="btn btn-primary">Simpan</button>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#qwe').html(new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0}).format('<?= $item_total ?>', 3));
    });

    $('#savePayment').click(function() {
        $('#modal-Payment').modal('hide');

        let timerInterval
        Swal.fire({
            title: '<span class="text-warning">Pastikan uang telah diterima!</span>',
            html: 'Lanjut dalam <b></b> detik',
            timer: 5000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                    Swal.getHtmlContainer().querySelector('b')
                    .textContent = (Swal.getTimerLeft() / 1000)
                    .toFixed(0)
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                Swal.fire({
                    icon: 'question',
                    title: 'Konfirmasi Pembayaran!',
                    showCancelButton: true,
                    reverseButtons: false,
                    focusCancel: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Tutup',
                    buttonsStyling: !1,
                    customClass: {
                        cancelButton: 'btn btn-danger me-3',
                        confirmButton: 'btn btn-label-secondary'
                    },
                    timer: 10000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('save_payment/').urlencode(base64_encode($id_px.'471*#434'.$id_order)) ?>',
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            success: function(json){
                                if (json.status) {
                                    sweetalert(null, 'success', json.message);
                                    $('#myTabel').DataTable().ajax.reload( null, false );
                                }else{
                                    sweetalert(null, 'warning', json.message);
                                }
                            }
                        })
                    }else if (result.isDismissed) {
                        sweetalert(null, 'error', 'Pembayaran dibatalkan!');
                    }
                })
            }
        })
    })

</script>