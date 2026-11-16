<?php setlocale (LC_TIME, "IND"); ?>

<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.min.css" /> 

<div class="col-12 d-flex justify-content-between">
    <h4 class="d-flex align-items-center fw-bold py-2 mb-2"><?= $pageTitle ?></h4>
    <div class="col-5 col-sm-3">
        <input type="text" class="form-control form-control-sm flatpickr-input mb-2" id="delDate" name="delDate" placeholder="Tanggal Pengiriman" value="<?= date('Y-m-d')?>">
        <select id="delType" name="delType" class="select2 form-select form-select-sm">
            <option value="semua">Semua</option>
            <option value="1">Selesai</option>
            <option value="2">Delivery</option>
            <option value="3">Proses</option>
            <option value="0">Batal</option>
        </select>
    </div>
</div>
<hr>
<!-- Basic Layout -->
<div class="row">
    <div class="col-xl" id="result-list">
    </div>
</div>

<div class="modal fade" id="modal-Ordinary" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold mb-0">Pilih Urutan Pengiriman</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2" id="ModalBody">
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

<script type="text/javascript">
    $(document).ready(function(){
        function ajaxjson() {
            $.ajax({
                url: "<?= base_url("deliveryjson/") ?>"+$('#delDate').val()+"/"+$('#delType').val()+"/<?= $this->session->userdata('s_usr_id') ?>",
                type: 'POST',
                cache: false,
                dataType: 'json',
                success: function(json){
                    if (json.status == 1) {
                        html = "";
                        $.each(json.data, function(index, key) {
                            iconType = ``;
                            btnConfirm = ``;
                            bgAlert = ''
                            if (key.delivery_type == 1) {
                                iconType = `<span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                                            <i class='bx bx-check fs-2'></i>
                                        </span>`;
                                bgAlert = `<div class="alert alert-success">`;
                            }else if (key.delivery_type == 2) {
                                iconType = `<span class="badge badge-center rounded-pill bg-info border-label-info p-3 me-2">
                                            <i class='bx bx-cycling bx-tada fs-2'></i>
                                        </span>`;
                                bgAlert = `<div class="alert alert-info">`;
                            }else if (key.delivery_type == 3) {
                                iconType = `<span class="badge badge-center rounded-pill bg-secondary border-label-secondary p-3 me-2">
                                            <i class='bx bxs-package fs-2'></i>
                                        </span>`;
                                bgAlert = `<div class="alert alert-info">`;
                            }else if (key.delivery_type == 0) {
                                iconType = `<span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">
                                            <i class='bx bx-x fs-2'></i>
                                        </span>`;
                                bgAlert = `<div class="alert alert-danger">`;
                            }

                            if ($.datepicker.formatDate('yy-mm-dd', new Date()) == key.delivery_date) {
                                if (key.delivery_type == 1) {
                                }else if (key.delivery_type == 2) {
                                    btnConfirm = `<div class="d-grid d-flex justify-content-end">
                                                <a type="button" class="btn btn-sm btn-success" id="selesai" href='<?= base_url('selesai_delivery/') ?>`+key.id_delivery+`'>Selesaikan Pengiriman</a>
                                            </div>`;
                                }else if (key.delivery_type == 3) {
                                    btnConfirm = `<div class="d-grid d-flex justify-content-end">
                                                <button type="button" class="btn btn-sm btn-info" onclick="setOrdinary(`+key.id_delivery+`)">Kirim Obat</button>
                                            </div>`;
                                }
                            }

                            resend = ``

                            if (key.resend == 1) {
                                resend += `<span class="badge bg-label-warning me-1">Kirim Ulang Pertama</span>`;
                            }else if (key.resend == 2) {
                                resend += `<span class="badge bg-label-warning me-1">Kirim Ulang Kedua</span>`;
                            }
                            
                            var nohp = "";
                            //let text = key.receiver_phone;
                            
                            if(key.receiver_phone.substr(0,2) == "62"){
                                var nohp = key.receiver_phone;
                            	
                            }else{
                            	var nohp = "62"+key.receiver_phone.substring(1);
                            }

                            html += `<div class="card">
                                <h5 class="card-header p-3">
                                    <div class="d-flex">
                                        `+iconType+`
                                        <div class="d-flex flex-column ps-1">
                                            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">`+key.receiver_name+`</h6>
                                            <span><i class='bx bxl-whatsapp-square text-success'></i> <a class="text-success" href="https://wa.me/`+nohp+`">`+key.receiver_phone+`</a></span>
                                        </div>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    `+resend+`
                                    <hr class="mt-2">
                                    <h5>`+key.address+`</h5>
                                    Detail Alamat : 
                                    <h5 class="ps-2">`+key.detail_address+`</h5>

                                    <div class="mb-3 col-12 mb-0">
                                        `+bgAlert+`
                                            <h5 class="alert-heading fw-bold mb-1">Rincian Resep</h5>
                                            <p class="mb-0" style='white-space: pre-wrap;'>`+key.resep+`</p>
                                        </div>
                                    </div>
                                    
                                    <form id="formAccountDeactivation" onsubmit="return false">
                                        `+btnConfirm+`
                                    </form>
                                </div>
                            </div>
                            <hr>`;
                        });

                        $('#result-list').html(html);
                    }else if(json.status == 2) {
                        html = `<div class="card col-lg-8 ">
                                    <div class="d-flex align-items-end row">
                                      <div class="col-sm-7">
                                        <div class="card-body">
                                          <h5 class="card-title text-danger">Maaf belum ada pengiriman hari ini !</h5>
                                          <p class="mb-4">
                                          </p>
                                        </div>
                                      </div>
                                      <div class="col-sm-5 text-center text-sm-left">
                                        <div class="card-body pb-0 px-0 px-md-4">
                                          <img
                                            src="<?= config_item('img'); ?>/illustrations/page-misc-error-light.png"
                                            height="140"
                                            alt="View Badge User"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png"
                                          />
                                        </div>
                                      </div>
                                    </div>
                                  </div>`;
                        $('#result-list').html(html);

                    }
                },
                beforeSend: function() {
                    $('#loader').css('display', 'block');
                },
                complete: function() {
                    $('#loader').css('display', 'none');
                },
            })
        };

        ajaxjson();

        setInterval(ajaxjson, 7000);

        /* Flatpickr */
        flatpickr('#delDate', {
            locale: "id",
            // allowInput: true,
            altInput: true,
            altFormat: 'j F Y',
            dateFormat: 'Y-m-d',
            disableMobile: true,
        });
        /* end Flatpickr */
        
        $('#delDate').change(function() {
            ajaxjson();
        });

        $('#delType').change(function() {
            ajaxjson();
        });
        
        $(document).on('click', '#submitOrdinary', function(e){
            // console.log($('#delivery_id').val()+"-"+$('#ordinary :selected').val());
            $.ajax({
                url: '<?= base_url('set_ordinary/') ?>'+$('#delivery_id').val()+"/"+$('#ordinary :selected').val(),
                type: 'POST',
                cache: false,
                dataType: 'json',
                success: function(json){
                    if (json.status == 1) {
                        sweetalert2(json.alert, json.pesan);
                        ajaxjson();
                        $('#modal-Ordinary').modal('hide');

                    }else{
                        sweetalert2(json.alert, json.pesan);
                    }

                }
            })
        });

        $(document).on('click', '#selesai', function(e){
            e.preventDefault();
            var Link = $(this).attr('href');
            Swal.fire({
                icon: 'question',
                showCancelButton: true,
                reverseButtons: false,
                focusCancel: true,
                confirmButtonText: 'Ya, Yakin',
                cancelButtonText: 'Tutup',
                customClass: {
                    cancelButton: 'btn btn-danger',
                    confirmButton: 'btn btn-label-success me-5'
                },
                input: 'checkbox',
                inputPlaceholder:'Yakin obat telah diterima?',
                inputValidator: function(inputValue) {
                    return new Promise(function(resolve, reject) {
                        if (inputValue) {
                            resolve();
                        } else {
                            resolve('Oops!!');
                        }
                    });
                },
                buttonsStyling: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: Link,
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        success: function(json){
                            if (json.status == 1) {
                                sweetalert2(json.alert, json.pesan);
                                ajaxjson();
                            }else{
                                sweetalert2(json.alert, json.pesan);
                            }
                        }
                    })
                }
            })
        })
    });

    function setOrdinary(id_delivery) {
        $('#modal-Ordinary #ModalBody').load('<?= base_url('get_ordinary/') ?>'+id_delivery);
        $('#modal-Ordinary').modal('show');
    }


    /* OLD */
    function detail(e, id_order, user_id) {
        // $('#modal-DetailOrder #ModalBody').load('<?= base_url('detail_order') ?>/'+id_order+'/'+user_id);
        $('#modal-DetailOrder').modal('show');
    }

    $(document).on('click', '#batal', function(e){
        e.preventDefault();
        var Link = $(this).attr('href');
        Swal.fire({
            icon: 'question',
            text: 'Apakah anda yakin ingin membatalkan pemeriksaan?',
            showCancelButton: true,
            reverseButtons: false,
            focusCancel: true,
            confirmButtonText: 'Ya, Batal',
            cancelButtonText: 'Tutup',
            customClass: {
                cancelButton: 'btn btn-danger me-3',
                confirmButton: 'btn btn-label-secondary'
            },
            buttonsStyling: !1
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: Link,
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
            }
        })
    })

    $(document).on('click', '#updtStatus', function(e){
        e.preventDefault();
        var Link = $(this).attr('href');

        if ($(this).children().html() == 'Dilayani' || $(this).children().html() == 'Antrian') {
            $('#submitNurse').attr('data-url', Link);
            user_id = $(this).parent().parent().siblings('input').val();
            if (user_id != 0) {
                $('.selectpicker').selectpicker('val', user_id);
            }
            $('#modal-SelectNurse').modal('show');
        }else if ($(this).children().html() == 'Selesai') {
            $('#modal-Payment #ModalBody').load(Link);
            $('#modal-Payment').modal('show');
        }else{
            updtStatus(Link);
        }
    })

    $('#submitNurse').click(function() {
        if ($('#nurse :selected').val()) {
            $('#modal-SelectNurse').modal('hide');
            var Link = $(this).attr( "data-url" );
            updtStatus(Link+'/'+$('#nurse :selected').val());
        }else{
            sweetalert(null, 'warning', 'Harap pilih petugas!');          
        }
    })

    function updtStatus(Link) {
        $.ajax({
            url: Link,
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
        $(this).parent().parent().parent().siblings().removeClass();
        $(this).parent().parent().parent().siblings().html($(this).children().html());
        $(this).parent().parent().parent().siblings().addClass($(this).children().attr('class'));
    }

    $(document).on('click', '#updtNurse', function(e){
        e.preventDefault();
        var ord_id = $(this).parent().parent().siblings('input').val();
        var Link = $(this).children().attr('href');

        $.ajax({
            url: Link+'/'+ord_id,
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
    })

    function getNurse(jsonData){
        $.ajax({
            url: '<?= base_url('get_nurse') ?>',
            type: 'GET',
            cache: false,
            async: false,
            dataType: 'json',
            success: function(json){
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

    $('#modal-SelectNurse').on('hidden.bs.modal', function (e) {
        $('#formNurse').trigger("reset");
        $('.selectpicker').selectpicker('refresh');
    })

    $('modal-DetailOrder').on('hidden.bs.modal', function (e) {
        setTimeout(function(){ 
            $('#ModalBody').html('');
        }, 500);
    });

    $('#modal-Payment').on('hidden.bs.modal', function (e) {
        setTimeout(function(){ 
            $('#ModalBody').html('');
        }, 500);
    });    
</script>