<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.min.css" /> 
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/leaflet/leaflet.css" />
<link rel="stylesheet" href="<?= config_item('assets'); ?>vendor/libs/select2/select2.css" />

<h4 class="fw-bold py-2 mb-2"><?= $pageTitle ?></h4>
<style>
    textarea {
        resize: none;
    }

@media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}

</style>
<!-- Basic Layout -->
<div class="row" id="no-print-this">
    <div class="col-xl">
        <form id="form-id" onsubmit="return false">
            <input type="hidden" name="delivery_id" value="<?= $data->id_delivery ?>">
            <div class="row mb-3">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="col mb-3">
                                <label class="form-label">Unit Pengirim</label>
                                <input type="text" class="form-control" value="RSUD R.A. Basoeni" readonly>
                            </div>
                            <div class="row mb-3">
                                <label class="form-label">Tgl. Pengiriman</label>
                                <div class="col">
                                    <input type="hidden" class="form-control" id="delDate" name="delDate" placeholder="Tanggal Pengiriman" value="<?= $data->delivery_date ?>">
                                    <input type="text" class="form-control" id="delDateShow" name="delDateShow" placeholder="Tanggal Pengiriman" value="" disabled>
                                </div>
                                <div class="col">
                                    <!-- <label for="flatpickr-time" class="form-label">Time Picker</label> -->
                                    <input type="text" class="form-control text-center" placeholder="Waktu Pengiriman" id="delTime" name="delTime" value="<?= date('H:i', strtotime($data->delivery_time)) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="col mb-3">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" class="form-control" required id="delName" name="delName" placeholder="Nama Penerima" value="<?= $data->receiver_name ?>">
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" class="form-control" required id="delPhone" name="delPhone" placeholder="08123..." onkeypress='return check_int(event)' value="<?= $data->receiver_phone ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row row-cols-3 row-cols-md-3 justify-content-md-between">
                            <div class="col">
                                <label class="form-label">Alamat Penerima</label>
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="provName" name="provName" value="<?= $data->prov_name ?>" readonly>
                                    <input type="hidden" id="idProv" name="idProv" value="<?= $data->prov_id ?>">
                                </div>
                                <div class="mb-2">
                                    <input type="hidden" id="cityName" name="cityName" value="<?= $data->city_name ?>">
                                    <select id="idCity" name="idCity" class="select2 form-select">
                                        <option value="<?= $data->city_id ?>" selected><?= $data->city_name ?></option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <input type="hidden" id="disName" name="disName" value="<?= $data->dis_name ?>">
                                    <select id="idDis" name="idDis" class="select2 form-select">
                                        <option value="<?= $data->dis_id ?>" selected><?= $data->dis_name ?></option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <input type="hidden" id="subdisName" name="subdisName" value="<?= $data->subdis_name ?>">
                                    <select id="idSubdis" name="idSubdis" class="select2 form-select">
                                        <option value="<?= $data->subdis_id ?>" selected><?= $data->subdis_name ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label">Jarak</label>
                                    <input type="text" class="form-control" id="delJarak" name="delJarak" value="<?= $data->distance ?>" readonly>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Total Ongkir</label>
                                    <input type="hidden" class="form-control" id="delTotal" name="delTotal" value="<?= $data->total ?>">
                                    <input type="text" class="form-control" id="delOngkirDisplay" name="delOngkirDisplay" value="Rp <?= number_format($data->total, 0, ",", ".") ?>" readonly>
                                        <option value="" selected></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row col-md-6">
                                <div class="row row-cols-2 row-cols-md-2">
                                    <div class="row mb-3">
                                        <label class="col-3 col-form-label">RT</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="delRT" name="delRT" placeholder="RT" onkeypress='return check_int(event)' value="<?= $data->rt_address ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-3 col-form-label">RW</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="delRW" name="delRW" placeholder="RW" onkeypress='return check_int(event)' value="<?= $data->rw_address ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Detail Alamat</label>
                                    <textarea class="form-control" rows="5" required id="delDetailAddress" name="delDetailAddress" placeholder="Nama Jalan, Gedung, No Rumah, Warna Rumah"><?= $data->detail_address ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="loader" id="loaderResult"></div>
                        <div class="row row-cols-2 row-cols-md-2">
                            <div class="col-md-4">
                                <textarea hidden class="form-control" id="delAddress" name="delAddress"><?= $data->address ?></textarea>
                                <ul id="result-list" class="list-group">
                                    <li class="list-group-item list-group-item-action" lat="<?= $data->lat ?>" lon="<?= $data->lon ?>"><?= $data->address ?></li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control"  id="searchinmap" name="searchinmap" placeholder="Cari di peta" disabled>
                                    <button class="btn btn-label-secondary" type="button" id="btnSearch" disabled><i class='bx bx-search-alt'></i> Cari</button>
                                </div>
                                <div class="leaflet-map mb-2" id="map"></div>
                                <div class="row row-cols-2 row-cols-md-2">
                                    <div class="row mb-3">
                                        <label class="col-3 col-form-label">Lat</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="dellat" name="dellat" value="<?= $data->lat ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-3 col-form-label">Lon</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="dellon" name="dellon" value="<?= $data->lon ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="col mb-3">
                                <label class="form-label">Rincian Resep</label>
                                <textarea type="text" class="form-control" required id="delResep" name="delResep" placeholder="paracetamol 3x1 sesudah makan&#13;&#10;tuzalos 3x1 sesudah makan&#13;&#10;becomzet 3x1 sesudah makan" rows="5"><?= $data->resep ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="col mb-3">
                                <label class="form-label">Nama Kurir</label>
                                <input type="hidden" id="idKurir" name="idKurir" value="<?= $kurir[0]->kurir_id; ?>">
                                <input type="text" class="form-control" id="delKurir" name="delKurir" value="<?= $kurir[0]->kurir_name; ?>" placeholder="Ketik Nama Kurir" readonly>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select id="delPayment" name="delPayment" class="select2 form-select">
                                    <option value="cod">Cash On Delivery (COD)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                <a href="<?= base_url('delivery_list'); ?>" type="button" class="btn btn-outline-secondary"><i class='bx bxs-x-square'></i> BATAL</a>
                <button id="btnSimpan" type="button" class="btn btn-primary"><i class='bx bx-save' ></i> SIMPAN</button>
            </div>
            <input type="hidden" name="typePost" value="edit">
        </form>
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
                    <dl class="row mt-2" id="print-it">
                        <table style='border-bottom: 1px solid' width='100%'>
                            <thead class='text-center'>
                                <tr><th colspan='3'>DELIVERY OBAT</th></tr>
                                <tr style='border-bottom: 5px double black;'><th colspan='3'>RSUD R.A. Basoeni</th></tr>
                            </thead>
                            <tbody style='vertical-align: top;'>
                                <tr><th class='ps-3'>Penerima : </th></tr>
                                <tr>
                                <td class='ps-4' colspan='3' id="mdName"></td>
                                </tr>
                                <tr><th class='ps-3'>No Telepon : </th></tr>
                                <tr><td class='ps-4' colspan='3' id="mdPhone"></td></tr>
                                <tr><th class='ps-3'>Tgl. Pengiriman : </th></tr>
                                <tr><td class='ps-4' colspan='3' id="mdDate">"</td></tr>
                                <tr><th class='ps-3'>Alamat : </th></tr>
                                <tr><td class='ps-4' colspan='3' id="mdAddress">".$alamat."</td></tr>
                                <tr><th class='ps-3'>Rincian Resep : </th></tr>
                                <tr><td class='ps-4' colspan='3' id="mdResep" style='white-space: pre-wrap; border-bottom: 5px double black;'></td></tr>
                                <tr>
                                    <th class='pe-3 text-end pe-3'>Jarak</th>
                                    <th class='text-end'>:</th>
                                    <td class='pe-5 text-end' width='50%' id="mdJarak"></td>
                                </tr>
                                <tr>
                                    <th class='pe-3 text-end' height='50'>Total</th>
                                    <th class='text-end'>:</th>
                                    <td class='pe-5 text-end' id="mdTotal"></td>
                                </tr>
                            </tbody>
                            <tfoot class='text-center' style='vertical-align: top;'>
                                <tr><th colspan='3'>Terima Kasih</th></tr>
                                <tr><th colspan='3'>Layanan Konsumen</th></tr>
                                <tr><th colspan='3' height='100'><i class='bx bxl-whatsapp fs-3'></i>WA 085123456789</th></tr>
                            </tfoot>
                        </table>
                    </dl>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button id="submit" class="btn btn-success btn-submit btn-save">OK <i class="bx bx-save bx-sm me-sm-n2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<script src="<?= config_item('assets'); ?>vendor/libs/jquery-validate/jquery.validate.min.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/flatpickr.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/flatpickr/id.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/select2/select2.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/i18n/datepicker-id.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/leaflet/leaflet.js"></script>
<script src="<?= config_item('assets'); ?>vendor/libs/printThis/printThis.min.js"></script>

<script type="text/javascript">
    var map = null;
    var marker = null;
    const currentMarkers = [];
    var latitude = -7.4560158877101435;
    var longitude = 112.39420315449877;
    var delDate = $('input[name=delDate]');
    var form = $("#form-id");
    const searchInput = document.getElementById('search');
    const resultList = document.getElementById('result-list');


    $('#idCity').select2({
        placeholder: 'Kota / Kabupaten',
        allowClear: false,
    });
  
    $('#idDis').select2({
        placeholder: 'Kecamatan',
        allowClear: false,
    });

    $('#idSubdis').select2({
        placeholder: 'Kelurahan',
        allowClear: false,
    });

    $('#idCity').on('select2:select', function(e) {
        $('#cityName').val($('#idCity :selected').text());
        $.ajax({
            url: '<?= base_url('getDis/')?>'+ $(this).val(),
            type: 'GET',
            cache: true,
            dataType: 'json',
            success: function(json){
                $("#idDis").empty();
                $.each(json.data, function (i, item) {

                    var newOption = new Option(item.name, item.id, false, false);
                    $('#idDis').append(newOption).trigger('change');
                });
                $("#idDis").val("");
            }
        });  
    })

    $('#idDis').on('select2:select', function(e) {
        $('#disName').val($('#idDis :selected').text());
        $('#idSubdis').attr('disabled', false);
        $.ajax({
            url: '<?= base_url('getSubdis/')?>'+ $(this).val(),
            type: 'GET',
            cache: true,
            dataType: 'json',
            success: function(json){
                $("#idSubdis").empty();
                $.each(json.data, function (i, item) {
                    var newOption = new Option(item.name, item.id, false, false);
                    $('#idSubdis').append(newOption).trigger('change');
                });
                $("#idSubdis").val("");
            }
        });  
    })

    $('#idSubdis').on('select2:select', function(e) {
        // document.getElementById('loader').style.display = 'block';

        $('#subdisName').val($('#idSubdis :selected').text());
        $('#searchinmap').attr('disabled', false);
        $('#btnSearch').attr('disabled', false);
        $("#searchinmap").val($('#subdisName').val()+' '+$('#cityName').val()+' '+$('#provName').val());

        getAddress(null, null, 1);
    })

    $("#delDetailAddress").each( function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
        }).on("input", function () {
            this.style.height = "auto";
            this.style.height = (this.scrollHeight) + "px";
        }
    );

    $('#btnSimpan').click(function() {
        if (form.valid()) {
            $('#mdName').html($('#delName').val().toUpperCase());
            $('#mdPhone').html($('#delPhone').val());
            $('#mdDate').html($.datepicker.formatDate('dd MM yy', new Date($('input[name=delDate]').val()))+'&nbsp;&nbsp;&nbsp;&nbsp;'+$('input[name=delTime]').val());
            // $('#fgh').html(harga);
            var alamat = $('textarea[name=delDetailAddress]').val();
            alamat += '<br>RT : '+$('input[name=delRT]').val()+' / RW : '+$('input[name=delRW]').val();
            alamat += '<br>'+$('textarea[name=delAddress]').val();
            $('#mdAddress').html(alamat);
            $('#mdResep').html($('textarea[name=delResep]').val());
            $('#mdJarak').html($('input[name=delJarak]').val()+' Km');
            $('#mdTotal').html($('input[name=delOngkirDisplay]').val());
            // $('#rty]').html($('#latitude').val()+', '+$('#longitude').val());
            $('#modal-Detail').modal({backdrop: 'static', keyboard: false});
            $('#modal-Detail').modal('show');
        }
    });

    $('#submit').click(function() {
        $(this).attr('disabled', true);

        var FormData = '&' + $('#form-id input, textarea, select').serialize();
        // console.log(FormData);
        $.ajax({
            url: '<?= base_url('save_delivery')?>',
            type: 'POST',
            cache: false,
            data: FormData,
            dataType: 'json',
            success: function(json) {
                if (json.status == 1) {
                    $('#print-it').printThis();

                    sweetalert2(json.alert, json.pesan);

                    $('#modal-Detail').modal('hide');
                    setTimeout(function(){ 
                        window.location.href = "<?= site_url('delivery_list'); ?>";
                    }, 1000);
                }else{
                    sweetalert2(json.alert, json.pesan);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                sweetalert2('warning', xhr.status+' '+thrownError);
            }
        });
    });  

    $('#btnSearch').click(function() {
        getAddress(null, null, 1);
    });

    $('#searchinmap').on('keypress',function(e) {
        if(e.which == 13) {
            getAddress(null, null, 1);
        }
    });

    /* Map Leaflet */
    function setResultList(parsedResult) {
        resultList.innerHTML = "";
        // console.log(parsedResult.length);
        if (parsedResult.length > 0) {
            for (const marker of currentMarkers) {
                map.removeLayer(marker);
            }
            for (const result of parsedResult) {
                const li = document.createElement('li');
                li.classList.add('list-group-item', 'list-group-item-action');

                address = result.display_name.replace("East Java", "Jawa Timur");
                address = address.replace(", Indonesia", "");
                li.innerHTML = address;
                
                const lat = document.createAttribute("lat");
                lat.value = result.lat;
                li.setAttributeNode(lat)
                const lon = document.createAttribute("lon");
                lon.value = result.lon;
                li.setAttributeNode(lon)
                // li.innerHTML += JSON.stringify({
                //     lat: result.lat,
                //     lon: result.lon,
                //     // boundingbox: result.boundingbox
                // }, undefined, 2);
                li.addEventListener('click', (event) => {
                    for(const child of resultList.children) {
                        child.classList.remove('active');
                    }
                    event.target.classList.add('active');
                    var lat = $(event.target).attr("lat");
                    var lon = $(event.target).attr("lon");
                    // const clickedData = JSON.parse(event.target.lat);
                    const position = new L.LatLng(lat, lon);
                    // const bounds = [[clickedData.boundingbox[0], clickedData.boundingbox[2]], [clickedData.boundingbox[1], clickedData.boundingbox[3]]];
                    // const boundingBox = L.rectangle(bounds, {color: "#f03", fillColor: '#ff7800', weight: 1});
                    // let marker2 = new L.marker(position).addTo(map);
                    // map.removeLayer(boundingBox);
                    // map.addLayer(boundingBox)
                    distance(lat, lon);
                    map.removeLayer(marker);
                    map.addLayer(marker);
                    marker.setLatLng(position).update()
                    map.flyTo(position, 13);

                    $('#delAddress').val(ucwords($('#disName').val())+', '+event.target.innerHTML);

                    // console.log(clickedData.boundingbox[0]);
                })
                
                // currentMarkers.push(new L.marker(position).addTo(map));
                resultList.appendChild(li);
                // document.getElementById('loader').style.display = 'none';
            }
            const position = new L.LatLng(parsedResult[0].lat, parsedResult[0].lon);
            // let marker2 = new L.marker(parsedResult[0].lat, parsedResult[0].lon).addTo(map);
            // const bounds = [[parsedResult[0].boundingbox[0], parsedResult[0].boundingbox[2]], [parsedResult[0].boundingbox[1], parsedResult[0].boundingbox[3]]];
            // const boundingBox = L.rectangle(bounds, {color: "#f03", fillColor: '#ff7800', weight: 1});
            // map.removeLayer(boundingBox);
            // map.addLayer(boundingBox)
            distance(parsedResult[0].lat, parsedResult[0].lon);
            map.removeLayer(marker);
            map.addLayer(marker);
            marker.setLatLng(position).update();
            map.flyTo(position, 13);

            address = parsedResult[0].display_name.replace("East Java", "Jawa Timur");
            address = address.replace(", Indonesia", "");

            $('#delAddress').val(ucwords($('#disName').val())+', '+address);

        }else{
            map.removeLayer(marker);

            const li = document.createElement('li');
            li.classList.add('list-group-item', 'list-group-item-action');
            li.innerHTML = '<p style="color:red;">Lokasi tidak ditemukan!</p> coba lakukan pencarian secara manual!';
            resultList.appendChild(li);
            $('#delAddress').val("");
        }
    }

    function createMap(position) {
        this.map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);

        $('#dellat').val(position.coords.latitude);
        $('#dellon').val(position.coords.longitude);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // L.circle([latitude, longitude], {
        //     color: 'red',
        //     fillColor: '#f03',
        //     fillOpacity: .3,
        //     radius: 20000
        // }).addTo(map);

        // this.marker = new L.marker([position.coords.latitude, position.coords.longitude], {draggable: 'true', icon: greenIcon}).addTo(map);
        this.marker = new L.marker([position.coords.latitude, position.coords.longitude], {draggable: 'true', icon: greenIcon});
        
        new L.marker([position.coords.latitude, position.coords.longitude], {draggable: 'true', icon: hospitalIcon}).addTo(map)

        distance(position.coords.latitude, position.coords.longitude);
        // if (distance(position.coords.latitude, position.coords.longitude) == false) {
        //     // marker.bindPopup('<p style="color:red;">Lokasi anda terlalu jauh!').openPopup();
        // }else{
        //     // marker.bindPopup('<p style="color:green;">Lokasi anda berada dalam jangkauan! <i class="bx bx-check"></i></p>').openPopup();
        // }

        this.map.on('click', function(e) {
            map.removeLayer(marker);
            map.addLayer(marker);
            marker.setLatLng(e.latlng, {
                draggable: 'true'
            }).bindPopup(e.latlng).update();
            // console.log(e.latlng.lat, e.latlng.lng)
            distance(e.latlng.lat, e.latlng.lng);
            // if (distance(e.latlng.lat, e.latlng.lng) == false) {
            //     // marker.bindPopup('<p style="color:red;">Lokasi anda terlalu jauh!').openPopup();
            // }else{
            //     // marker.bindPopup('<p style="color:green;">Lokasi anda berada dalam jangkauan! <i class="bx bx-check"></i></p>').openPopup();
            // }

            // $('#latitude').val(e.latlng.lat);
            // $('#longitude').val(e.latlng.lng);

            /* Get address */
            getAddress(e.latlng.lat, e.latlng.lng, 2);
        });

        this.marker.on('dragend', function(e) {
            map.removeLayer(marker);
            map.addLayer(marker);
            position = marker.getLatLng();
            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(position).update();
            // console.log(position);
            distance(position.lat, position.lng);
            // if (distance(position.lat, position.lng) == false) {
            //     // marker.bindPopup('<p style="color:red;">Lokasi anda terlalu jauh!').openPopup();
            // }else{
            //     // marker.bindPopup('<p style="color:green;">Lokasi anda berada dalam jangkauan! <i class="bx bx-check"></i></p>').openPopup();
            // }

            // $('#latitude').val(position.lat);
            // $('#longitude').val(position.lng);
            
            /* Get address */
            getAddress(position.lat, position.lng, 2);
        });

        this.map.attributionControl.setPrefix(false);
        this.map.scrollWheelZoom.disable();
        // map.addLayer(marker);
    }

    function getAddress(lat, lon, type){
        if (type == 1) {
            const query = $("#searchinmap").val();

            link = "https://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&q=" + query;
        }else if (type == 2) {
            if (lat == null && lon == null) {
                lat = $('#dellat').val();
                lon = $('#dellon').val();
            }

            link = "https://nominatim.openstreetmap.org/search.php?q="+lat+","+lon+"&polygon_geojson=1&format=json";
        }
        
        $.ajax({
            url: link,
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function(json){
                if (type == 1) {
                    setResultList(json);
                }else if (type == 2) {
                    resultList.innerHTML = "";
                    // console.log(json[0].display_name)
                    address = json[0].display_name.replace("East Java", "Jawa Timur");
                    address = address.replace(", Indonesia", "");

                    const li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.innerHTML = address;
                    resultList.appendChild(li);
                    $('#delAddress').val(ucwords($('#disName').val())+', '+address);
                }
            },
            beforeSend: function() {
                $('#loaderResult').css('display', 'block');
            },
            complete: function() {
                $('#loaderResult').css('display', 'none');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                sweetalert2('warning', xhr.status+' '+thrownError);
            }
        })
    }

    function degToRad(x) {
        return x * Math.PI / 180;
    }

    function distance(lat2 = null, lon2 = null) {
        lat1 = latitude;
        lon1 = longitude;

        if (lat2 == null && lon2 == null) {
            lat2 = $('#dellat').val();
            lon2 = $('#dellon').val();
        }

        R = 6371;
        halfDLat = degToRad(lat2 - lat1) / 2;
        halfDLon = degToRad(lon2 - lon1) / 2;
        a = Math.sin(halfDLat) * Math.sin(halfDLat) + Math.cos(degToRad(lat1)) * Math.cos(degToRad(lat2)) * Math.sin(halfDLon) * Math.sin(halfDLon);
        c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        hasil = (R * c);
        // Log.i(TAG, "jarak: "+hasil);
        // return hasil;
        // Log.i(TAG, "distance: "+radius);
        $('#delJarak').val(Math.round(hasil));
        $('#dellat').val(lat2);
        $('#dellon').val(lon2);

        $('#delTotal').val(Math.round(hasil) * 2000);
        $('#delOngkirDisplay').val(to_rupiah(Math.round(hasil) * 2000));

        // if (hasil < 20000) {
        //     return true;
        // }else{
        //     return false;
        // }
    }
    
    /* end Map Leaflet */

    $(document).ready(function() {
        /* Form Validate */
        form.validate({
            rules: {
                delDate: {
                    required: true
                },
                delName: {
                    required: true
                },
                delTime: {
                    required: true
                },
                delPhone: {
                    required: true
                },
                idProv: {
                    required: true
                },
                idCity: {
                    required: true
                },
                idDis: {
                    required: true
                },
                idSubdis: {
                    required: true
                },
                delJarak: {
                    required: true
                },
                delTotal: {
                    required: true
                },
                delDetailAddress: {
                    required: true
                },
                delAddress: {
                    required: true
                },
                dellat: {
                    required: true
                },
                dellon: {
                    required: true
                },
                delKurir: {
                    required: true
                }
            },
            messages: {
                delDate: {
                    required: "Harap pilih tanggal pengiriman",
                },
                delTime: {
                    required: "Masukkan waktu pengiriman",
                },
                delName: {
                    required: "Masukkan nama penerima",
                },
                delPhone: {
                    required: "Masukkan nomor telepon",
                },
                idProv: {
                    required: "Harap pilih provinsi",
                },
                idCity: {
                    required: "Harap pilih kota / kabupaten"
                },
                idDis: {
                    required: "Harap pilih kecamatan",
                },
                idSubdis: {
                    required: "Harap pilih kelurahan",
                },
                delJarak: {
                    required: "Jarak kosong",
                },
                delTotal: {
                    required: "Total Kosong",
                },
                delDetailAddress: {
                    required: "Masukkan detail alamat"
                },
                delAddress: {
                    required: "Harap pilih alamat",
                },
                dellat: {
                    required: "latitude tidak boleh kosong",
                },
                dellon: {
                    required: "longitude tidak boleh kosong",
                },
                delResep: {
                    required: "Masukkan resep",
                },
                delKurir: {
                    required: "Harap pilih kurir",
                }
            },
            errorPlacement: function ( error, element ) {
                if(element.parent().hasClass('form-check-label')){
                    error.insertAfter( element.parent().parent().parent().parent() );
                }else{
                    error.insertAfter( element );
                }
            },
            onfocusout: false,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {                    
                    validator.errorList[0].element.focus();
                }
            } 
        })
        /* end Form Validate */

        /* Flatpickr */
        // flatpickr('#delDate', {
        //     locale: "id",
        //     // allowInput: true,
        //     altInput: true,
        //     altFormat: 'j F Y',
        //     dateFormat: 'Y-m-d',
        //     // defaultDate: '2023-03-23',
        //     disableMobile: true,
        //     minDate: '<?= $data->delivery_date ?>',
        // });

        $('#delDateShow').val($.datepicker.formatDate('dd MM yy', new Date($('#delDate').val())));

        flatpickr('#delTime', {
            locale: "id",
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            // altFormat: 'H:i',
            // dateFormat: 'H:i',
            // defaultDate: '<?= date("H:ii")?>',
            minuteIncrement: 1,
        });
        /* end Flatpickr */
    });

    $(window).on('load', function() {
        $.ajax({
            url: '<?= base_url('getCity/')?>'+ $('#idProv').val(),
            type: 'GET',
            cache: false,
            dataType: 'json',
            success: function(json){
                $.each(json.data, function (i, item) {
                    if (item.id == <?= $data->city_id ?>) {
                        var newOption = new Option(item.name, item.id, true, true);
                    }else{
                        var newOption = new Option(item.name, item.id, false, false);
                    }
                    $('#idCity').append(newOption).trigger('change');
                });
                $.ajax({
                    url: '<?= base_url('getDis/')?>'+ $('#idCity').val(),
                    type: 'GET',
                    cache: true,
                    dataType: 'json',
                    success: function(json){
                        $("#idDis").empty();
                        $.each(json.data, function (i, item) {
                            if (item.id == <?= $data->dis_id ?>) {
                                var newOption = new Option(item.name, item.id, true, true);
                            }else{
                                var newOption = new Option(item.name, item.id, false, false);
                            }
                            $('#idDis').append(newOption).trigger('change');
                        });
                        // $("#idDis").val("");
                    }
                }); 
            }
        });


        let position = {coords:{
            latitude: <?= $data->lat ?>,
            longitude: <?= $data->lon ?>,
        }};

        createMap(position);
    })

    function to_rupiah(angka) {
        var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2    = '';
        for(var i = 0; i < rev.length; i++) {
            rev2  += rev[i];
            if((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return 'Rp. ' + rev2.split('').reverse().join('');
    }

    function check_int(evt){
        var charCode = ( evt.which ) ? evt.which : event.keyCode;
        return ( charCode >= 48 && charCode <= 57 || charCode == 8 ); //48 s/d 57 = 0-9, 8 = backspace
    }

    function ucwords(str) {
        return str.toLowerCase().replace(/^([a-z])|\s+([a-z])/g, function ($1) {
            return $1.toUpperCase();
        });
    }
</script>