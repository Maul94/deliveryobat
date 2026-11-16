<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="en" class="light-style  customizer-hide" dir="ltr" data-theme="theme-semi-dark" data-assets-path="<?= config_item('assets'); ?>" data-template="vertical-menu-template-semi-dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register | SiapLumah</title>

    <meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= config_item('assets'); ?>favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="<?= config_item('assets'); ?>fonts.googleapis.com/index.html">
    <link rel="preconnect" href="<?= config_item('assets'); ?>fonts.gstatic.com/index.html" crossorigin>
    <link href="<?= config_item('assets'); ?>fonts.googleapis.com/css28ebe.css?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/css/rtl/theme-semi-dark.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= config_item('assets'); ?>css/demo.css" />

    <!-- Vendors CSS -->
    <!-- Vendor -->
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.css" />

    <!-- Page -->
    <link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/css/pages/page-auth.css">

    <!-- Helpers -->
    <script src="<?= config_item('assets'); ?>vendor/js/helpers.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= config_item('assets'); ?>js/config.js"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');


        function numOnly(e) {
            if (/\D/g.test(e.value)) {
                e.value = e.value.replace(/\D/g, '');
            }
        }
    </script>

    <style type="text/css">
        .align-left {
            text-align: left;
        }
    </style>
    <!-- Custom notification for demo -->
    <!-- beautify ignore:end -->

</head>

<body>
<!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <defs>
                                            <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                            <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                                            <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                                            <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                                        </defs>
                                        <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                                <g id="Icon" transform="translate(27.000000, 15.000000)">
                                                    <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                        <mask id="mask-2" fill="white">
                                                            <use xlink:href="#path-1"></use>
                                                        </mask>
                                                        <use fill="#696cff" xlink:href="#path-1"></use>
                                                        <g id="Path-3" mask="url(#mask-2)">
                                                            <use fill="#696cff" xlink:href="#path-3"></use>
                                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                                        </g>
                                                        <g id="Path-4" mask="url(#mask-2)">
                                                            <use fill="#696cff" xlink:href="#path-4"></use>
                                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                                        </g>
                                                    </g>
                                                    <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                                        <use fill="#696cff" xlink:href="#path-5"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder">
                                    siap<span class="app-brand-text demo text-body fw-bolder" style="color: #FFB319 !important;">lumah</span>
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2">Ayo, Buruan Daftar! 🚀</h4>
                        <p class="mb-3">Silakan masukan RM dan Tanggal Lahir Anda terlebih dahulu</p>

                        <div id="wizard-register" class="bs-stepper vertical mt-2 mb-4">
                            <div class="bs-stepper-header">
                                <div class="step" data-target="#user-check">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle">
                                            <i class='bx bxs-user-check'></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Verif data</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#user-details">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-circle">
                                            <i class='bx bxs-user-detail'></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Detail User</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="bs-stepper-content">
                                <form id="wizard-register-form" onSubmit="return false">
                                    <!-- User Check -->
                                    <div id="user-check" class="content">
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="iprm" class="form-label">RM</label>
                                                    <input type="text" class="form-control" id="iprm" name="pxNoRm" minlength="6" maxlength="6" placeholder="RM" onkeyup="numOnly(this)">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pxBirthDate" class="form-label">Tgl. Lahir</label>
                                                    <input class="form-control flatpickr-input" id="pxBirthDate" name="pxBirthDate" placeholder="Tanggal Lahir">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <button class="btn btn-label-secondary" disabled><i class="bx bx-chevron-left bx-sm ms-sm-n2"></i><span class="align-middle d-sm-inline-block d-none">Previous</span></button>
                                                <button id="btnNext-1" type="button" class="btn btn-label-secondary btn-next" disabled><span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span><i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                                                <!-- <button type="button" class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button> -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- User Details -->
                                    <div id="user-details" class="content">
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <input type="hidden" id="pxName" name="pxName">
                                                <input type="hidden" id="pxAddress" name="pxAddress">
                                                <input type="hidden" id="pxNoKtp" name="pxNoKtp">
                                                <div class="mb-3">
                                                    <label class="form-label" for="pxPassword">Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="pxPassword" class="form-control" name="pxPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="passwordToggler" />
                                                        <span id="passwordToggler" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="pxPassword2">Ulangi Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="pxPassword2" class="form-control" name="pxPassword2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="passwordToggler2" />
                                                        <span id="passwordToggler2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                    <!-- </div> -->
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="pxEmail">Email</label>
                                                    <input type="text" id="pxEmail" name="pxEmail" class="form-control" placeholder="john.doe@example.com" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="pxPhone">No. Handphone</label>
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">(+62)</span>
                                                        <input type="text" id="pxPhone" name="pxPhone" class="form-control contact-number-mask" placeholder="202 555 0111" aria-describedby="pxPhone" onkeyup="numOnly(this)" />
                                                    </div>
                                                    <div class="form-text">Nomor Telepon yang terdaftar di WA</div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <button class="btn btn-primary btn-prev"><i class="bx bx-chevron-left bx-sm ms-sm-n2"></i><span class="align-middle d-sm-inline-block d-none">Previous</span></button>
                                                <button class="btn btn-success btn-submit btn-save"><span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span><i class="bx bx-save bx-sm me-sm-n2"></i></button>
                                                <!-- <button class="btn btn-label-secondary btn-submit btn-save" disabled><span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span><i class="bx bx-save bx-sm me-sm-n2"></i></button> -->
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <p class="text-center">
                        <span>Sudah punya akun?</span>
                        <a href="<?= base_url('login'); ?>">
                            <span>Masuk</span>
                        </a>
                    </p>

                    <div class="divider my-4">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                            <i class="tf-icons bx bxl-facebook"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                            <i class="tf-icons bx bxl-google-plus"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                            <i class="tf-icons bx bxl-twitter"></i>
                        </a>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <script src="<?= config_item('assets'); ?>vendor/libs/jquery/jquery-3.6.0.min.js"></script>
    <script src="<?= config_item('assets'); ?>vendor/js/myown.js"></script>
    <script src="<?= config_item('assets'); ?>vendor/libs/jquery-validate/jquery.validate.min.js"></script>
    <script src="<?= config_item('assets'); ?>vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="<?= config_item('assets'); ?>vendor/libs/bs-stepper/bs-stepper.min.js"></script>
    <script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/id.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var pxNoRm = $('input[type=text][name=pxNoRm]');
            var pxBirthDate = $('input[name=pxBirthDate]');
            var btnNext_1 = $('.btn-next');
            var form = $("#wizard-register-form");
            var showhidePswd = $('.cursor-pointer');

            form.validate({
                rules: {
                    pxNoRm: {
                        required: true,
                        number: true
                    },
                    pxBirthDate: {
                        required: true
                    },
                    pxPassword: {
                        required: true,
                        minlength: 6
                    },
                    pxPassword2: {
                        required: true,
                        minlength: 6,
                        equalTo: "#pxPassword"
                    },
                    pxPhone: {
                        required: true,
                        minlength: 10,
                        number: true,
                    },
                    pxEmail: {
                        email: true,
                    },
                },
                messages: {
                    pxNoRm: {
                        required: "Masukkan RM",
                        minlength: "Minimal 6 angka",
                        number: "Harus angka"
                    },
                    pxBirthDate: {
                        required: "Masukkan Tanggal Lahir"
                    },
                    pxPassword: {
                        required: "Masukkan password",
                        minlength: "Minimal 6 karakter"
                    },
                    pxPassword2: {
                        required: "Ulangi password",
                        minlength: "Minimal 6 karakter",
                        equalTo: "Password harus sama"
                    },
                    pxPhone: {
                        required: "Masukkan nomor telepon",
                        minlength: "Minimal 10 angka",
                        number: "Harus angka"
                    },
                    pxEmail: "Email tidak valid"
                },
                errorPlacement: function ( error, element ) {
                    if(element.parent().hasClass('input-group')){
                        error.insertAfter( element.parent() );
                    }else{
                        error.insertAfter( element );
                    }
                },
            })

            /* Wizard Form bs-strepper */
            !function() {
                var stepperFormEl = document.querySelector('#wizard-register')
                    stepperForm = new Stepper(stepperFormEl, {
                    animation: true
                })

                var btnNext = document.querySelector('.btn-next')
                var btnPrev = document.querySelector('.btn-prev')

                btnNext.addEventListener('click', function () {
                    // stepperForm.next()
                    user_check();
                })

                btnPrev.addEventListener('click', function () {
                    stepperForm.previous()
                })

            }();

            /* Flatpickr */
            flatpickr('#pxBirthDate', {
                locale: "id",
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                disableMobile: true,
                maxDate: '<?= date("Y-m-d")?>'
            });

            pxNoRm.keyup(function(){
                qwe();
            });

            pxBirthDate.change(function(){
                qwe();
            });

            /* Validate Input RM */
            function qwe() {
                if(pxNoRm.val().length == pxNoRm.attr('minlength') && pxBirthDate.val() != '') {
                    btnNext_1.removeClass('btn-label-secondary').addClass('btn-primary');
                    btnNext_1.prop('disabled', false);
                }else{
                    btnNext_1.removeClass('btn-primary').addClass('btn-label-secondary');
                    btnNext_1.prop('disabled', true);
                }
            }

            function user_check() {
                // var result  = '';
                var FormData = '&pxNoRm='+pxNoRm.val();
                    FormData += '&pxBirthDate='+pxBirthDate.val();

                $.ajax({
                    url: '<?= base_url('get_px')?>',
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: FormData,
                    dataType:'json',
                    success: function(json){
                        if (json.status) {
                            Swal.fire({
                                html:
                                    '<div class="align-left">'+
                                    'Nama : '+json.px['px_name']+
                                    '<br>Tanggal Lahir : '+json.px['px_birthdate']+
                                    '<br>Alamat : '+json.px['px_address']+
                                    '<br>NIK : '+json.px['px_noktp']+
                                    '</div>',
                                icon: 'question',
                                showCancelButton: !0,
                                reverseButtons: true,
                                confirmButtonText: 'Ya, Benar',
                                cancelButtonText: 'Batal',
                                customClass: {
                                    cancelButton: 'btn btn-label-secondary',
                                    confirmButton: 'btn btn-primary me-3'
                                },
                                buttonsStyling: !1
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    stepperForm.next()
                                    $('#pxName').val(json.px['px_name']);
                                    $('#pxAddress').val(json.px['px_address']);
                                    $('#pxNoKtp').val(json.px['px_noktp']);
                                } else if (result.isDismissed) {
                                    // pxNoRm.val('');
                                    // $('.flatpickr-input').val('');
                                    // qwe();
                                }
                            })
                        }else{
                            sweetalert(null, 'warning', json.message);
                        }
                    }
                });
                // return result;
            }

            /* Show Hide Password*/
            showhidePswd.click(function(){
                if ($(this).siblings('input').attr('type') == 'password') {
                    $(this).siblings('input').attr('type', 'text');
                    $(this).children().removeClass('bx-hide').addClass('bx-show');
                }else if ($(this).siblings('input').attr('type') == 'text') {
                    $(this).siblings('input').attr('type', 'password');
                    $(this).children().removeClass('bx-show').addClass('bx-hide');
                }
            })

            $('.btn-submit').click(function() {
                if(form.valid()){
                    var FormData = '&' + $('#wizard-register-form input').serialize();

                    // console.log('simpan');
                    $.ajax({
                        url: '<?= base_url('simpan_register')?>',
                        type: 'POST',
                        cache: false,
                        data: FormData,
                        dataType:'json',
                        success: function(json){
                            if (json.status) {
                                sweetalert(null, 'success', json.message);
                                setTimeout(function(){ 
                                    window.location.href = '<?= site_url('login'); ?>';
                                }, 1000);
                            }else{
                                sweetalert(null, 'warning', json.message);
                            }
                        }

                    });
                }    
            });
        });
    </script>
</body>

</html>
