                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                , made by <a href="#" target="_blank" class="footer-link fw-bolder">DevApik</a>
                            </div>
                            <div>
                                <a href="#" class="footer-link me-4" target="_blank">License</a>
                                <a href="#" target="_blank" class="footer-link me-4">More Themes</a>
                                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                                <a href="https://themeselection.com/support/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
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
    
    <script type="text/javascript">

        function giveRate(order_id){
            $('#basicModal #ModalHeader').html('Beri Penilaian');
            $('#basicModal #ModalContent').load('<?= base_url('give_rate/') ?>'+order_id);
            $('#basicModal').modal('show');
        }

        $('#basicModal').on('hidden.bs.modal', function () {
            setTimeout(function(){ 
                $('#ModalHeader, #ModalContent, #ModalFooter').html('');
            }, 500);
        });


        
        // $(document).ready(function() {
        $(window).on('load', function() {
            $.ajax({
                url: '<?= base_url('get_notif') ?>',
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(json){
                    if (json.num_rows > 0) {
                        $('.badge-notifications').html(json.num_rows)
                        $('.badge-notifications').show();
                        
                        // html = '<li class="dropdown-menu-header border-bottom">'
                        // html += '<div class="dropdown-header d-flex align-items-center py-3">'
                        // html += '<h5 class="text-body mb-0 me-auto">Notification</h5>'
                        // html += '<a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>'
                        // html += '</div>'
                        // html += '</li>'
                        // html += '<li class="dropdown-notifications-list scrollable-container">'
                        // html += '<ul class="list-group list-group-flush">'
                        html = '';
                        $.each(json.notifs, function (i, item) {
                            // html += '<li class="list-group-item list-group-item-action dropdown-notifications-item">';
                            // html += '<div class="d-flex">';
                            // html += '<div class="flex-grow-1">';
                            // html += '<h6 class="mb-1">Congratulation Lettie 🎉</h6>';
                            // html += '<p class="mb-0">Won the monthly best seller gold badge</p>';
                            // html += '<small class="text-muted">1h ago</small>';
                            // html += '</div>';
                            // html += '<div class="flex-shrink-0 dropdown-notifications-actions">';
                            // html += '<a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>';
                            // html += '<a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>';
                            // html += '</div>';
                            // html += '</div>';
                            // html += '</li>';

                            html += '<li class="list-group-item list-group-item-action dropdown-notifications-item">'
                            html += '<div class="d-flex">'
                            html += '<div class="flex-grow-1">'
                            html += '<h6 class="mb-1">'+item.ntf_title+'</h6>'
                            html += '<p class="mb-0">'+item.ntf_text+'</p>'
                            html += '<small class="text-muted">'+item.entrydate+'</small>'
                            html += '</div>'
                            html += '<div class="flex-shrink-0 dropdown-notifications-actions">'
                            html += '<a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>'
                            html += '<a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>'
                            html += '</div>'
                            html += '</div>'
                            html += '</li>'
                        });

                        // html += '</ul>'
                        // html += '</li>'
                        // html += '<li class="dropdown-menu-footer border-top">'
                        // html += '<a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">View all notifications</a>'
                        // html += '</li>'

                        $('.notif').html(html);
                    }else{
                    }
                },
                complete: function() {
                    const m = document.querySelector(".dropdown-notifications-all");
                    c = document.querySelectorAll(".dropdown-notifications-read");
                    p = (m && m.addEventListener("click", e => {
                            c.forEach(e => {
                                e.closest(".dropdown-notifications-item").classList.add("marked-as-read")
                            })
                        }),
                        c && c.forEach(t => {
                            t.addEventListener("click", e => {
                                t.closest(".dropdown-notifications-item").classList.toggle("marked-as-read")
                            })
                        }),
                        document.querySelectorAll(".dropdown-notifications-archive")),
                    p.forEach(t => {
                            t.addEventListener("click", e => {
                                t.closest(".dropdown-notifications-item").remove()
                                // console.log(p);
                            })
                    });
                }
            });


        });
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