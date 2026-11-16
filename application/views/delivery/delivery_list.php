<?php setlocale(LC_TIME, "IND"); ?>
<style type="text/css">
    /*#print-it hr {
    display: block!important;
    height: 1px;
    background: transparent;
    width: 100%;
    border: none;
    border-top: solid 2px black;
}*/
</style>
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.min.css" />

<h4 class="fw-bold py-2 mb-2"><?= $pageTitle ?></h4>
<!-- Basic Layout -->
<div class="row" id="no-print-this">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-datatable table-responsive" style="min-height: 400px;">
                    <div class="row justify-content-between">
                        <div class="col">
                            <a href="<?= base_url('entry_delivery') ?>" class="btn btn-primary btn-sm"><i class='bx bx-plus'></i> Input Pengiriman</a>
                        </div>
                        <div class="row col">
                            <div class="col">
                                <select id="delType" name="delType" class="select2 form-select form-select-sm">
                                    <option value="semua">Semua</option>
                                    <option value="1">Selesai</option>
                                    <option value="2">Delivery</option>
                                    <option value="3">Proses</option>
                                    <option value="0">Batal</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm flatpickr-input" id="delDate" name="delDate" placeholder="Tanggal Pengiriman" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                    <table class="datatables-ajax table table-striped" id="myTabel">
                        <thead>
                            <tr>
                                <th class="th-1">#</th>
                                <th class="th-2">Nama Penerima</th>
                                <th class="th-3">Alamat</th>
                                <!-- <th class="th-4">Kurir</th> -->
                                <th class="th-5">Status Pengiriman</th>
                                <th class="th-6">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-Detail" tabindex="-1" aria-hidden="true">
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
                    <div class="col-8">
                        <button id="cetak" class="btn btn-info">Cetak <i class="bx bx-printer bx-sm me-sm-n2"></i></button>
                        <a id="cetaktanpanominal" class="btn btn-secondary">Cetak Tanpa Nominal</a>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-Detail2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <dl class="row mt-2" id="print-it2"></dl>
                </div>
                <div class="row">
                    <div class="col">
                        <button id="cetak2" class="btn btn-info">Cetak <i class="bx bx-printer bx-sm me-sm-n2"></i></button>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-Resend" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <input type="hidden" id="delId" name="delId">
                    <input type="hidden" id="delResend" name="delResend">
                    <input type="hidden" id="resendDate2" name="resendDate2">
                    <input type="hidden" id="resendTime2" name="resendTime2">
                    <label class="form-label">Tanggal Pengiriman</label>
                    <div class="col">
                        <input type="text" class="form-control flatpickr-input text-center" id="resendDate" name="resendDate">
                        <!-- <input type="text" class="form-control flatpickr-input text-center" id="resendDate" name="resendDate" value="2023-03-31"> -->
                    </div>
                    <div class="col">
                        <input type="text" class="form-control flatpickr-input text-center" id="resendTime" name="resendTime">
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-between">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close"><i class='bx bxs-x-square'></i> Batal</button>
                        <button class="btn btn-primary" id="resendSimpan"><i class="bx bx-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= config_item('assets'); ?>vendor/libs/i18n/datepicker-id.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/id.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables/jquery.dataTables.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-responsive/datatables.responsive.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/printThis/printThis.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var showTableLoader = true;
        var dataTable = $('#myTabel').DataTable({
            ajax: {
                url: '<?= base_url('deliveryjson/') ?>' + $('#delDate').val() + "/" + $('#delType').val(),
                dataSrc: 'data',
                beforeSend: function() {
                    if (showTableLoader) {
                        $('#loader').css('display', 'block');
                    }
                },
                complete: function() {
                    if (showTableLoader) {
                        setTimeout(() => {
                            $('#loader').css('display', 'none');
                        }, 500);
                    }
                    showTableLoader = false;
                }
            },
            oLanguage: {
                sSearch: '<i class="bx bx-search"></i>',
                sInfo: "Tampil _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
                sZeroRecords: "Pencarian tidak ditemukan",
                sEmptyTable: "Data kosong",
                sLoadingRecords: "Harap Tunggu...",
                sInfoFiltered: "(difilter dari _MAX_ total data)",
                sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman",
            },
            columns: [{
                    data: 'nomor'
                },
                {
                    data: 'receiver_name',
                    render: $.fn.dataTable.render.text()
                },
                {
                    data: 'address',
                    render: $.fn.dataTable.render.text()
                },
                // { data: 'usr_fullname' },
                {
                    data: 'delivery_type',
                    width: '5%',
                    render: function(data, type, full, row) {
                        html = ``;
                        if (data == 1) {
                            html = `<span class="badge bg-label-success me-1">Berhasil</span>`;
                        } else if (data == 2) {
                            html = `<span class="badge bg-label-info me-1">Delivery</span>`;
                        } else if (data == 3) {
                            html = `<span class="badge bg-label-secondary me-1">Sedang Prosess</span>`;
                        } else if (data == 0) {
                            html = `<span class="badge bg-label-danger me-1">Batal</span>`;
                        }

                        if (full[`resend`] == 1) {
                            html += `<br><span class="badge bg-label-warning me-1">Kirim Ulang Pertama</span>`;
                        } else if (full[`resend`] == 2) {
                            html += `<br><span class="badge bg-label-warning me-1">Kirim Ulang Kedua</span>`;
                        }

                        return html;
                    }
                },
                {
                    data: 'delivery_type',
                    render: function(data, type, full, row) {
                        html = `<div class="btn-group">`;
                        html += `<button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>`
                        html += `<ul class="dropdown-menu dropdown-menu-end">`;
                        html += `<li><a class="dropdown-item" id="detail" href="<?= base_url('detail_delivery/') ?>` + full[`id_delivery`] + `"><i class="bx bx-receipt"></i> Detail</a></li>`;

                        if (data == 1) {} else if (data == 2) {
                            html += `<li><a class="dropdown-item" id="batal" href="<?= base_url('batal_delivery/') ?>` + full[`id_delivery`] + `"><i class="bx bxs-trash text-danger me-1"></i> Batal</a></li>`;
                        } else if (data == 3) {
                            html += `<li><a class="dropdown-item" id="edit" href="<?= base_url('edit_delivery/') ?>` + full[`id_delivery`] + `"><i class="bx bx-edit-alt text-warning me-1"></i> Edit</a></li>`;
                            html += `<li><a class="dropdown-item" id="batal" href="<?= base_url('batal_delivery/') ?>` + full[`id_delivery`] + `"><i class="bx bxs-trash text-danger me-1"></i> Batal</a></li>`;
                        } else if (data == 0) {}

                        if ((full[`resend`] < 2 && data == 3) || (full[`resend`] < 2 && data == 2)) {
                            html += `<li><a class="dropdown-item" id="resend" href="<?= base_url('resend_delivery/') ?>` + full[`id_delivery`] + `"><i class='bx bx-mail-send me-1'></i> Kirim Ulang</a></li>`;
                        }

                        html += `</ul>`;
                        html += `</div>`;
                        return html;
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                if (data['delivery_type'] == 0) {
                    $(row).addClass('table-danger');
                }
                if (data['delivery_type'] == 1) {
                    $(row).addClass('table-success');
                }
            },
            sPaginationType: "simple_numbers",
            iDisplayLength: 10,
            aLengthMenu: [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"]
            ],
        });

        /* Flatpickr */
        flatpickr('#delDate', {
            locale: "id",
            // allowInput: true,
            altInput: true,
            altFormat: 'j F Y',
            dateFormat: 'Y-m-d',
            disableMobile: true,
            onChange: function(selectedDates, dateStr, instance) {
                showTableLoader = true;
                dataTable.ajax.url('<?= base_url('deliveryjson/') ?>' + $('#delDate').val() + "/" + $('#delType').val()).load();
            },
        });
        /* end Flatpickr */

        $('#delType').change(function() {
            showTableLoader = true;
            dataTable.ajax.url('<?= base_url('deliveryjson/') ?>' + $('#delDate').val() + "/" + $('#delType').val()).load();
        });

        setInterval(() => {
            if (document.hidden || $('.modal.show').length > 0 || $('.swal2-container').length > 0 || $('.dropdown-menu.show').length > 0) {
                return;
            }
            dataTable.ajax.reload(null, false);
        }, 7000);

        $(document).on('click', '#batal', function(e) {
            e.preventDefault();
            var Link = $(this).attr('href');
            Swal.fire({
                icon: 'question',
                text: 'Alasan batal pengiriman ?',
                showCancelButton: true,
                reverseButtons: false,
                focusCancel: true,
                confirmButtonText: 'Ya, Batal',
                cancelButtonText: 'Tutup',
                customClass: {
                    cancelButton: 'btn btn-danger',
                    confirmButton: 'btn btn-label-secondary me-5'
                },
                input: 'textarea',
                inputValidator: function(inputValue) {
                    return new Promise(function(resolve, reject) {
                        if (inputValue && inputValue.length > 0) {
                            resolve();
                        } else {
                            resolve('Harap masukkan alasan!');
                        }
                    });
                },
                buttonsStyling: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: Link,
                        type: 'POST',
                        data: { reason: result.value },
                        cache: false,
                        dataType: 'json',
                        success: function(json) {
                            if (json.status == 1) {
                                sweetalert2(json.alert, json.pesan);
                                dataTable.ajax.url('<?= base_url('deliveryjson/') ?>' + $('#delDate').val() + "/" + $('#delType').val()).load();
                            } else {
                                sweetalert2(json.alert, json.pesan);
                            }
                        }
                    })
                }
            })
        });

        $(document).on('click', '#resend', function(e) {
            e.preventDefault();
            var Link = $(this).attr('href');
            $.ajax({
                url: Link,
                type: 'POST',
                cache: false,
                dataType: 'json',
                success: function(json) {
                    // console.log(json);
                    if (json.status == 1) {
                        flatpickr('#resendDate', {
                            locale: "id",
                            // allowInput: true,
                            altInput: true,
                            altFormat: 'j F Y',
                            dateFormat: 'Y-m-d',
                            defaultDate: json.delivery_date,
                            disableMobile: true,
                            minDate: json.delivery_date,
                        });
                        // $('#resendDate').val(json.delivery_date);
                        flatpickr('#resendTime', {
                            locale: "id",
                            enableTime: true,
                            noCalendar: true,
                            allowInput: true,
                            time_24hr: true,
                            altFormat: 'H:i',
                            dateFormat: 'H:i',
                            defaultDate: json.delivery_time,
                            minuteIncrement: 1,
                        });
                        $('#resendTime').val(json.delivery_time);
                        $('#resendDate2').val(json.delivery_date);
                        $('#resendTime2').val(json.delivery_time);
                        $('#delId').val(json.id_delivery);
                        $('#delResend').val(json.resend);
                        $('#modal-Resend').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#modal-Resend').modal('show');

                    } else {
                        sweetalert2(json.alert, json.pesan);
                    }
                }
            })
            // $('#modal-Detail #print-it').load(Link);
        });

        $(document).on('click', '#resendSimpan', function(e) {
            var FormData = '&' + $('#modal-Resend input').serialize();

            $.ajax({
                url: '<?= base_url('save_resend') ?>',
                type: 'POST',
                cache: false,
                data: FormData,
                dataType: 'json',
                success: function(json) {
                    // console.log(json);
                    if (json.status == 1) {
                        sweetalert2(json.alert, json.pesan);
                        dataTable.ajax.url('<?= base_url('deliveryjson/') ?>' + $('#delDate').val() + "/" + $('#delType').val()).load();
                        $('#modal-Resend').modal('hide');
                    } else {
                        sweetalert2(json.alert, json.pesan);
                    }
                }
            })
        });
    });

    $(document).on('click', '#detail', function(e) {
        e.preventDefault();
        var Link = $(this).attr('href');
        $('#modal-Detail #print-it').load(Link);
        $('#cetaktanpanominal').attr('href', Link);
        $('#modal-Detail').modal('show');
    });

    $('#modal-Detail').on('hidden.bs.modal', function(e) {
        $('#print-it').html("");
    })

    $(document).on('click', '#cetak', function(e) {
        // $('#print-it').css({'color':'black','font-family':'sans-serif'});
        $('#print-it').printThis();
    });

    $(document).on('click', '#cetak2', function(e) {
        // $('#print-it').css({'color':'black','font-family':'sans-serif'});
        $('#print-it2').printThis();
    });

    $(document).on('click', '#cetaktanpanominal', function(e) {
        e.preventDefault();
        var Link = $(this).attr('href');

        $('#modal-Detail').modal('hide');
        $('#modal-Detail2 #print-it2').load(Link + "/cetak2");
        $('#modal-Detail2').modal('show');

        // $('#print-it').css({'color':'black','font-family':'sans-serif'});
        // $('#print-it').printThis();
    });

    $('#modal-Detail2').on('hidden.bs.modal', function(e) {
        $('#print-it2').html("");
    })





    /* OLD */



    $(document).on('click', '#updtStatus', function(e) {
        e.preventDefault();
        var Link = $(this).attr('href');

        if ($(this).children().html() == 'Dilayani' || $(this).children().html() == 'Antrian') {
            $('#submitNurse').attr('data-url', Link);
            user_id = $(this).parent().parent().siblings('input').val();
            if (user_id != 0) {
                $('.selectpicker').selectpicker('val', user_id);
            }
            $('#modal-SelectNurse').modal('show');
        } else if ($(this).children().html() == 'Selesai') {
            $('#modal-Payment #ModalBody').load(Link);
            $('#modal-Payment').modal('show');
        } else {
            updtStatus(Link);
        }
    })

    $('#submitNurse').click(function() {
        if ($('#nurse :selected').val()) {
            $('#modal-SelectNurse').modal('hide');
            var Link = $(this).attr("data-url");
            updtStatus(Link + '/' + $('#nurse :selected').val());
        } else {
            sweetalert(null, 'warning', 'Harap pilih petugas!');
        }
    })

    function updtStatus(Link) {
        $.ajax({
            url: Link,
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function(json) {
                if (json.status) {
                    sweetalert(null, 'success', json.message);
                    $('#myTabel').DataTable().ajax.reload(null, false);
                } else {
                    sweetalert(null, 'warning', json.message);
                }
            }
        })
        $(this).parent().parent().parent().siblings().removeClass();
        $(this).parent().parent().parent().siblings().html($(this).children().html());
        $(this).parent().parent().parent().siblings().addClass($(this).children().attr('class'));
    }

    $(document).on('click', '#updtNurse', function(e) {
        e.preventDefault();
        var ord_id = $(this).parent().parent().siblings('input').val();
        var Link = $(this).children().attr('href');

        $.ajax({
            url: Link + '/' + ord_id,
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function(json) {
                if (json.status) {
                    sweetalert(null, 'success', json.message);
                    $('#myTabel').DataTable().ajax.reload(null, false);
                } else {
                    sweetalert(null, 'warning', json.message);
                }
            }
        })
    })

    function getNurse(jsonData) {
        $.ajax({
            url: '<?= base_url('get_nurse') ?>',
            type: 'GET',
            cache: false,
            async: false,
            dataType: 'json',
            success: function(json) {
                jsonData(json);
            },
        });
    }

    $(window).on('load', function() {

        // getNurse(function(output){
        //     $.each(output.users, function (i, item) {
        //         var newOption = new Option(item.usr_fullname, item.id_user, false, false);
        //         $('#nurse').append(newOption);
        //     })
        //     $('.selectpicker').selectpicker('refresh');
        // })
    })

    $('#modal-SelectNurse').on('hidden.bs.modal', function(e) {
        $('#formNurse').trigger("reset");
        $('.selectpicker').selectpicker('refresh');
    })

    $('modal-DetailOrder').on('hidden.bs.modal', function(e) {
        setTimeout(function() {
            $('#ModalBody').html('');
        }, 500);
    });

    $('#modal-Payment').on('hidden.bs.modal', function(e) {
        setTimeout(function() {
            $('#ModalBody').html('');
        }, 500);
    });
</script>