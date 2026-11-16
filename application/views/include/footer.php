                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                , made by <a target="_blank" class="footer-link fw-bolder">DevApik</a>
                            </div>

                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                    </div>
                    <!-- / Content wrapper -->
                    </div>
                    <!-- / Layout page -->
                    </div>
                    <!-- / Layout container -->

                    <!-- Overlay -->
                    <div class="layout-overlay layout-menu-toggle"></div>

                    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
                    <div class="drag-target"></div>

                    </div>
                    <!-- / Layout wrapper -->
                    <!-- <input name="inptPass" id="inptPass" > -->


                    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title fw-bold mb-0" id="ModalHeader"></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="ModalContent">
                                </div>
                                <div class="modal-footer" id="ModalFooter"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="changePassModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title fw-bold mb-0" id="ModalHeader">Ganti Password</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="ModalContent">
                                    <form id="formchangpass" onsubmit="return false">
                                        <label class="form-label">Password Lama</label>
                                        <div class="input-group input-group-merge mb-3">
                                            <input type="password" id="oldPass" class="form-control form-control-sm" name="oldPass" aria-describedby="oldPasswordToggler" />
                                            <span id="oldPasswordToggler" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                        <label class="form-label">Password Baru</label>
                                        <div class="input-group input-group-merge mb-3">
                                            <input type="password" id="inptPass" class="form-control form-control-sm changepass" name="inptPass" aria-describedby="passwordToggler" />
                                            <span id="passwordToggler" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                        <label class="form-label">Ulangi Password Baru</label>
                                        <div class="input-group input-group-merge mb-3">
                                            <input type="password" id="repeatinptPass" class="form-control form-control-sm" name="repeatinptPass" aria-describedby="repeatPasswordToggler" />
                                            <span id="repeatPasswordToggler" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                        <li><span class="text-danger minchar">Minimal 6 karakter</span></li>
                                        <!-- <li><span class="text-danger mustnumalpha">Wajib terdiri angka dan huruf</span></li> -->
                                    </form>
                                </div>
                                <div class="modal-footer" id="ModalFooter">
                                    <button type="reset" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                                    <button type="button" id="savechangepass" class="btn btn-sm btn-primary" disabled>Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        // function giveRate(order_id) {
                        //     $('#basicModal #ModalHeader').html('Beri Penilaian');
                        //     $('#basicModal #ModalContent').load('<?= base_url('give_rate/') ?>' + order_id);
                        //     $('#basicModal').modal('show');
                        // }

                        $('#basicModal').on('hidden.bs.modal', function() {
                            setTimeout(function() {
                                $('#ModalHeader, #ModalContent, #ModalFooter').html('');
                            }, 500);
                        });

                        $('#changePassModal').on('hidden.bs.modal', function() {
                            $('#formchangpass').trigger("reset");
                            $('#savechangepass').attr('disabled', true);
                            $('.minchar').removeClass('text-success').addClass('text-danger');
                            $('#formchangpass input').attr('type', 'password');
                            $('#formchangpass .cursor-pointer i').removeClass('bx-show').addClass('bx-hide');
                        });

                        function validateChangePassForm() {
                            var oldPass = $('#oldPass').val();
                            var newPass = $('#inptPass').val();
                            var repeatPass = $('#repeatinptPass').val();

                            if (newPass.length >= 6) {
                                $('.minchar').removeClass('text-danger').addClass('text-success');
                            } else {
                                $('.minchar').removeClass('text-success').addClass('text-danger');
                            }

                            var isValid = oldPass.length > 0 && newPass.length >= 6 && newPass === repeatPass;
                            $('#savechangepass').attr('disabled', !isValid);
                        }

                        $(document).on('keyup change', '#oldPass, #inptPass, #repeatinptPass', validateChangePassForm);

                        $(document).on('click', '#savechangepass', function(e) {
                            e.preventDefault();
                            var $btn = $(this);
                            $btn.attr('disabled', true);

                            $.ajax({
                                url: '<?= base_url('change_password') ?>',
                                type: 'POST',
                                cache: false,
                                data: $('#formchangpass').serialize(),
                                dataType: 'json',
                                success: function(json) {
                                    if (json.status == 1) {
                                        sweetalert2(json.alert, json.pesan);
                                        $('#changePassModal').modal('hide');
                                    } else {
                                        sweetalert2(json.alert, json.pesan);
                                        validateChangePassForm();
                                    }
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    sweetalert2('warning', xhr.status + ' ' + thrownError);
                                    validateChangePassForm();
                                }
                            });
                        });

                        /* Show Hide Password*/
                        $('.cursor-pointer').click(function() {
                            if ($(this).siblings('input').attr('type') == 'password') {
                                $(this).siblings('input').attr('type', 'text');
                                $(this).children().removeClass('bx-hide').addClass('bx-show');
                            } else if ($(this).siblings('input').attr('type') == 'text') {
                                $(this).siblings('input').attr('type', 'password');
                                $(this).children().removeClass('bx-show').addClass('bx-hide');
                            }
                        })

                        // $(document).ready(function() {
                        // $(window).on('load', function() {
                        //     $.ajax({
                        //         url: '<?= base_url('get_notif') ?>',
                        //         type: 'GET',
                        //         cache: false,
                        //         dataType: 'json',
                        //         success: function(json) {
                        //             if (json.num_rows > 0) {
                        //                 $('.badge-notifications').html(json.num_rows)
                        //                 $('.badge-notifications').show();

                        //                 // html = '<li class="dropdown-menu-header border-bottom">'
                        //                 // html += '<div class="dropdown-header d-flex align-items-center py-3">'
                        //                 // html += '<h5 class="text-body mb-0 me-auto">Notification</h5>'
                        //                 // html += '<a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>'
                        //                 // html += '</div>'
                        //                 // html += '</li>'
                        //                 // html += '<li class="dropdown-notifications-list scrollable-container">'
                        //                 // html += '<ul class="list-group list-group-flush">'
                        //                 html = '';
                        //                 $.each(json.notifs, function(i, item) {
                        //                     // html += '<li class="list-group-item list-group-item-action dropdown-notifications-item">';
                        //                     // html += '<div class="d-flex">';
                        //                     // html += '<div class="flex-grow-1">';
                        //                     // html += '<h6 class="mb-1">Congratulation Lettie 🎉</h6>';
                        //                     // html += '<p class="mb-0">Won the monthly best seller gold badge</p>';
                        //                     // html += '<small class="text-muted">1h ago</small>';
                        //                     // html += '</div>';
                        //                     // html += '<div class="flex-shrink-0 dropdown-notifications-actions">';
                        //                     // html += '<a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>';
                        //                     // html += '<a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>';
                        //                     // html += '</div>';
                        //                     // html += '</div>';
                        //                     // html += '</li>';

                        //                     html += '<li class="list-group-item list-group-item-action dropdown-notifications-item">'
                        //                     html += '<div class="d-flex">'
                        //                     html += '<div class="flex-grow-1">'
                        //                     html += '<h6 class="mb-1">' + item.ntf_title + '</h6>'
                        //                     html += '<p class="mb-0">' + item.ntf_text + '</p>'
                        //                     html += '<small class="text-muted">' + item.entrydate + '</small>'
                        //                     html += '</div>'
                        //                     html += '<div class="flex-shrink-0 dropdown-notifications-actions">'
                        //                     html += '<a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>'
                        //                     html += '<a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>'
                        //                     html += '</div>'
                        //                     html += '</div>'
                        //                     html += '</li>'
                        //                 });

                        //                 // html += '</ul>'
                        //                 // html += '</li>'
                        //                 // html += '<li class="dropdown-menu-footer border-top">'
                        //                 // html += '<a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">View all notifications</a>'
                        //                 // html += '</li>'

                        //                 $('.notif').html(html);
                        //             } else {}
                        //         },
                        //         complete: function() {
                        //             const m = document.querySelector(".dropdown-notifications-all");
                        //             c = document.querySelectorAll(".dropdown-notifications-read");
                        //             p = (m && m.addEventListener("click", e => {
                        //                         c.forEach(e => {
                        //                             e.closest(".dropdown-notifications-item").classList.add("marked-as-read")
                        //                         })
                        //                     }),
                        //                     c && c.forEach(t => {
                        //                         t.addEventListener("click", e => {
                        //                             t.closest(".dropdown-notifications-item").classList.toggle("marked-as-read")
                        //                         })
                        //                     }),
                        //                     document.querySelectorAll(".dropdown-notifications-archive")),
                        //                 p.forEach(t => {
                        //                     t.addEventListener("click", e => {
                        //                         t.closest(".dropdown-notifications-item").remove()
                        //                         // console.log(p);
                        //                     })
                        //                 });
                        //         }
                        //     });


                        // });
                    </script>

                    <script src="<?= config_item('assets'); ?>vendor/libs/popper/popper.js"></script>
                    <script src="<?= config_item('assets'); ?>vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

                    <script src="<?= config_item('assets'); ?>vendor/libs/hammer/hammer.js"></script>
                    <script src="<?= config_item('assets'); ?>vendor/js/myown.js"></script>
                    <script src="<?= config_item('assets'); ?>vendor/js/menu.js"></script>
                    <script src="<?= config_item('assets'); ?>js/main.js"></script>
                    <script src="<?= config_item('assets'); ?>vendor/libs/rateyo/rateyo.js"></script>


                    </body>

                    </html>