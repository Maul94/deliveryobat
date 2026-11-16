<!-- Basic Layout -->
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/bootstrap-select/bootstrap-select.css" />
<h4 class="fw-bold py-2 mb-2"><?= $pageTitle ?></h4>

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-datatable table-responsive" style="min-height: 400px;">
                    <a href="#" id="adduser" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-adduser"><i class='bx bx-plus'></i> Tambah User</a>
                    <table class="datatables-ajax table table-striped" id="myTabel">
                        <thead>
                            <tr>
                                <th class="th-2">Nama</th>
                                <th class="th-3">Username</th>
                                <th class="th-5">Hak Akses</th>
                                <th class="th-5">Status</th>
                                <th class="th-6">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edituser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail User</h5>
                <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditUser" onsubmit="return false">
                    <input type="hidden" id="editiduser" name="id_user">
                    <div class="col mb-3">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" id="editnama" name="nama" maxlength="50">
                            </div>
                            <div class="col">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" id="editusername" name="username" maxlength="10">
                                <div class="form-text">username digunakan untuk akses login (6-10 karakter)</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="change_pass">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Ganti Password
                                    </label>
                                </div>
                                <input type="password" class="form-control" id="editpassword" minlength="6" name="password" placeholder="Masukkan Password" disabled>
                                <div class="form-text text-danger minchar">Minimal 6 karakter</div>
                            </div>
                            <div class="col">
                                <label class="form-label mb-2"></label>
                                <input type="password" class="form-control" id="editrptpassword" name="rptpassword" placeholder="Ulangi Password" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" id="editstatus" name="status" value="1" checked="">
                                    <label class="form-check-label" for="editstatus">Status user</label>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label">Hak Akses</label>
                                <select class="form-select" id="editaccess" name="access" aria-label="Default select example">
                                    <option selected readonly disabled>- Pilih Hak Akses -</option>
                                    <?php foreach ($role_list as $key) {
                                        echo '<option value="' . $key->id_role . '">' . $key->role_name . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class='bx bxs-x-square'></i> Batal</button>
                            <button type="button" class="btn btn-primary" id="editSimpan"><i class="bx bx-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-adduser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail User</h5>
                <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddUser" onsubmit="return false">
                    <div class="col mb-3">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="50">
                            </div>
                            <div class="col">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" maxlength="10">
                                <div class="form-text">username digunakan untuk akses login (6-10 karakter)</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" minlength="6" name="password" placeholder="Masukkan Password">
                                <div class="form-text text-danger minchar">Minimal 6 karakter</div>
                            </div>
                            <div class="col">
                                <label class="form-label mb-2"></label>
                                <input type="password" class="form-control" id="rptpassword" name="rptpassword" placeholder="Ulangi Password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked="">
                                    <label class="form-check-label" for="status">Status user</label>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label">Hak Akses</label>
                                <select class="form-select" id="access" name="access" aria-label="Default select example">
                                    <option selected readonly disabled>- Pilih Hak Akses -</option>
                                    <?php foreach ($role_list as $key) {
                                        echo '<option value="' . $key->id_role . '">' . $key->role_name . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class='bx bxs-x-square'></i> Batal</button>
                            <button type="button" class="btn btn-primary" id="addSimpan"><i class="bx bx-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= config_item('assets'); ?>vendor/libs/datatables/jquery.dataTables.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-responsive/datatables.responsive.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var dataTable = $('#myTabel').DataTable({
            ajax: {
                url: '<?= base_url('userjson') ?>',
                dataSrc: 'data',
                beforeSend: function() {
                    $('#loader').css('display', 'block');
                },
                complete: function() {
                    setTimeout(() => {
                        $('#loader').css('display', 'none');
                    }, 500);
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
                    data: 'usr_fullname',
                    render: $.fn.dataTable.render.text()
                },
                {
                    data: 'usr_name',
                    render: $.fn.dataTable.render.text()
                },
                {
                    data: 'role_name',
                    render: $.fn.dataTable.render.text()
                },
                {
                    data: 'status',
                    render: function(data, type, full, row) {
                        if (data == 0) {
                            html = `<span class="badge bg-label-danger">Non Aktif</span>`;
                        } else {
                            html = `<span class="badge bg-label-info">Aktif</span>`;
                        }
                        return html;
                    }
                },
                {
                    data: 'status',
                    render: function(data, type, full, row) {
                        html = `<a type="button" class="btn" id="edituser" href="<?= base_url('edituser/') ?>` + full[`id_user`] + `"><i class="bx bx-edit-alt text-warning me-1"></i> Edit</a>`
                        return html;
                    }
                }
            ],
            aaSorting: [
                [3, "desc"]
            ],
            sPaginationType: "simple_numbers",
            iDisplayLength: 10,
            aLengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, "All"]
            ],
        });

        $(document).on('click', '#addSimpan', function(e) {
            e.preventDefault();

            if ($('#password').val() === $('#rptpassword').val()) {
                $(this).attr('disabled', true);
                var FormData = $('#formAddUser').serialize();
                $.ajax({
                    url: '<?= base_url('addUser') ?>',
                    type: 'POST',
                    cache: false,
                    data: FormData,
                    dataType: 'json',
                    success: function(json) {
                        if (json.status == 1) {
                            sweetalert2(json.alert, json.pesan);

                            $('#modal-adduser').modal('hide');
                            $('#formAddUser').trigger("reset")
                            dataTable.ajax.reload(null, false);
                        } else {
                            sweetalert2(json.alert, json.pesan);
                            $('#addSimpan').attr('disabled', false);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        sweetalert2('warning', xhr.status + ' ' + thrownError);
                        $('#addSimpan').attr('disabled', false);
                    }
                });
            } else {
                sweetalert2('warning', 'Verifikasi password tidak sama');
            }
        });

        $(document).on('change', '#defaultCheck1', function() {
            var checked = $(this).is(':checked');
            $('#editpassword, #editrptpassword').prop('disabled', !checked);
            if (!checked) {
                $('#editpassword, #editrptpassword').val('');
            }
        });

        $(document).on('click', '#edituser', function(e) {
            e.preventDefault();
            var Link = $(this).attr('href');
            $.ajax({
                url: Link,
                type: 'POST',
                cache: false,
                dataType: 'json',
                success: function(json) {
                    if (json.status == 1) {
                        $('#editiduser').val(json.data.id_user);
                        $('#editnama').val(json.data.usr_fullname);
                        $('#editusername').val(json.data.usr_name);
                        $('#editstatus').prop('checked', json.data.status == 1);
                        $('#defaultCheck1').prop('checked', false);
                        $('#editpassword, #editrptpassword').prop('disabled', true).val('');
                        $('#editaccess').val(json.data.usr_role);
                        $('#modal-edituser').modal('show');
                    } else {
                        sweetalert2(json.alert, json.pesan);
                    }
                }
            })
        });

        $(document).on('click', '#editSimpan', function(e) {
            e.preventDefault();

            if ($('#defaultCheck1').is(':checked') && $('#editpassword').val() !== $('#editrptpassword').val()) {
                sweetalert2('warning', 'Verifikasi password tidak sama');
                return;
            }

            $(this).attr('disabled', true);
            var FormData = $('#formEditUser').serialize();
            $.ajax({
                url: '<?= base_url('updateUser') ?>',
                type: 'POST',
                cache: false,
                data: FormData,
                dataType: 'json',
                success: function(json) {
                    if (json.status == 1) {
                        sweetalert2(json.alert, json.pesan);
                        $('#modal-edituser').modal('hide');
                        dataTable.ajax.reload(null, false);
                    } else {
                        sweetalert2(json.alert, json.pesan);
                        $('#editSimpan').attr('disabled', false);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    sweetalert2('warning', xhr.status + ' ' + thrownError);
                    $('#editSimpan').attr('disabled', false);
                }
            });
        });
    })

    $('#modal-adduser').on('hidden.bs.modal', function() {
        $('#formAddUser').trigger("reset");
        $('#addSimpan').attr('disabled', false);
    });

    $('#modal-edituser').on('hidden.bs.modal', function() {
        $('#formEditUser').trigger("reset");
        $('#editiduser').val('');
        $('#defaultCheck1').prop('checked', false);
        $('#editpassword, #editrptpassword').prop('disabled', true).val('');
        $('#editSimpan').attr('disabled', false);
    });
</script>