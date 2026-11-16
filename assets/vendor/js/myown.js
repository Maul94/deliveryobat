"use strict";

// function sweetalert(xtitle = null, xicon = null, xmessage = null){
//     var asd = '';
//     Swal.fire({
//     	title: xtitle,
//         icon: xicon,
//         title: xmessage,
//         showConfirmButton: false,
//         timer: 1900,
//     // }).then((result) => {
//     //     if (result.isConfirmed) {
//     //         // stepperForm.next()
//     //         // $('#pxName').val(json.px['px_name']);
//     //         // $('#pxAddress').val(json.px['px_address']);
//     //         // $('#pxNoKtp').val(json.px['px_noktp']);
//     //     } else if (result.isDismissed) {
//     //         // pxNoRm.val('');
//     //         // $('.flatpickr-input').val('');
//     //         // qwe();
//     //     }
//     })
// }

function sweetalert2(alert, pesan, title = "Eror!", link = "", data = "", callback = ""){
    if (alert == 'success') {
        Swal.fire({
            title: 'Sukses',
            html: pesan,
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        })
    }
    else if (alert == 'error') {
        Swal.fire({
            title: title,
            html: pesan,
            icon: 'error'
        })
    }
    else if (alert == 'warning') {
        Swal.fire({
            title: 'Peringatan!',
            html: pesan,
            icon: 'warning',
            showConfirmButton: false,
            timer: 2000
        })
    }
    else if (alert == 'question') {
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-sm btn-success mg-l-5',
            cancelButton: 'btn btn-sm btn-danger'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: title,
          html: pesan,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'YA!',
          cancelButtonText: 'TIDAK!',
          reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var hasil = false;
                $.ajax({
                    url: link,
                    type: "POST",
                    data: data,
                    cache: false,
                    dataType:'json',
                    success: function(data){
                        if (data.status == 1) {
                            sweetalert2(data.alert, data.pesan);
                            hasil = true;
                            // if (tipe == "ubahpass") {
                            //  hasil = true;
                            //  window.location.href = "logout";
                            // }else if(tipe == "akses"){
                            //  itemaksesjson();
                            // }else{
                            //  $('#my-grid').DataTable().ajax.reload( null, false );
                            // }
                        }else if (data.status == 2) {
                            sweetalert2(data.alert, data.pesan);
                            hasil = false;
                        }
                        callback(hasil);
                    }
                });
            }else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Dibatalkan!',
                  'Data batal diproses',
                  'error'
                )
            }
        })

    }
}