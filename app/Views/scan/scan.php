<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<a href="<?= base_url('/admin'); ?> " class="btn btn-primary pull-right pl-3">
    <i class="material-icons mr-2">dashboard</i>
    Dashboard
</a>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<?php
   $oppBtn = '';
   $waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';
?>
<!-- **PERBAIKAN**: Menambahkan sedikit CSS untuk memastikan peta pas di dalam kartu -->
<style>
    #map {
        width: 100%;
        height: 400px;
        border-radius: .75rem;
        background-color: #eee;
    }
    .leaflet-container {
        border-radius: .75rem;
    }
</style>

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row mx-auto">
                <div class="col-lg-3 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mt-2"><b>Tips</b></h3>
                            <ul class="pl-3">
                                <li>Tunjukkan qr code sampai terlihat jelas di kamera</li>
                                <li>Posisikan qr code tidak terlalu jauh maupun terlalu dekat</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="col-10 mx-auto card-header card-header-primary">
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title"><b>Absen <?= $waktu; ?></b></h4>
                                    <p class="card-category">Silahkan tunjukkan QR Code anda</p>
                                </div>
                                <div class="col-md-auto">
                                    <a href="<?= base_url("scan/$oppBtn"); ?>" class="btn btn-<?= $oppBtn == 'masuk' ? 'success' : 'warning'; ?>">
                                        Absen <?= $oppBtn; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body my-auto px-5">
                            <h4 class="d-inline">Pilih kamera</h4>
                            <select id="pilihKamera" class="custom-select w-50 ml-2" aria-label="Default select example" style="height: 35px;">
                                <option selected>Select camera devices</option>
                            </select>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 mx-auto">
                                    <div class="previewParent">
                                        <div class="text-center">
                                            <h4 class="d-none w-100" id="searching"><b>Mencari...</b></h4>
                                        </div>
                                        <video id="previewKamera"></video>
                                    </div>
                                </div>
                            </div>
                            <div id="hasilScan"></div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mt-2"><b>Penggunaan</b></h3>
                            <ul class="pl-3">
                                <li>Jika berhasil scan maka akan muncul data siswa/guru dibawah preview kamera</li>
                                <li>Klik tombol <b><span class="text-success">Absen masuk</span> / <span class="text-warning">Absen pulang</span></b> untuk mengubah waktu absensi</li>
                                <li>Untuk melihat data absensi, klik tombol <span class="text-primary"><i class="material-icons" style="font-size: 16px;">dashboard</i> Dashboard Petugas</span></li>
                                <li>Untuk mengakses halaman petugas anda harus login terlebih dahulu</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/plugins/zxing/zxing.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/jquery-3.5.1.min.js') ?>"></script>
<script type="text/javascript">
    let selectedDeviceId = null;
    let audio = new Audio("<?= base_url('assets/audio/beep.mp3'); ?>");
    const codeReader = new ZXing.BrowserMultiFormatReader();
    const sourceSelect = $('#pilihKamera');
    let mapInstance = null;

    $(document).on('change', '#pilihKamera', function() {
        selectedDeviceId = $(this).val();
        if (codeReader) {
            codeReader.reset();
            initScanner();
        }
    })

    function initScanner() {
        codeReader.listVideoInputDevices()
            .then(videoInputDevices => {
                if (videoInputDevices.length < 1) {
                    alert("Camera not found!");
                    return;
                }
                if (selectedDeviceId == null) {
                    selectedDeviceId = videoInputDevices.length <= 1 ? videoInputDevices[0].deviceId : videoInputDevices[1].deviceId;
                }
                if (videoInputDevices.length >= 1) {
                    sourceSelect.html('');
                    videoInputDevices.forEach((element) => {
                        const sourceOption = document.createElement('option')
                        sourceOption.text = element.label
                        sourceOption.value = element.deviceId
                        if (element.deviceId == selectedDeviceId) {
                            sourceOption.selected = 'selected';
                        }
                        sourceSelect.append(sourceOption)
                    })
                }

                $('#previewParent, #previewKamera').removeClass('d-none');
                $('#searching').addClass('d-none');

                codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                    .then(result => {
                        cekData(result.text);
                        $('#previewKamera, #previewParent').addClass('d-none');
                        $('#searching').removeClass('d-none');
                        if (codeReader) {
                            codeReader.reset();
                            setTimeout(() => initScanner(), 2500);
                        }
                    })
                    .catch(err => console.error(err));
            })
            .catch(err => console.error(err));
    }

    if (navigator.mediaDevices) {
        initScanner();
    } else {
        alert('Cannot access camera.');
    }

    function activateMap() {
        const mapDiv = document.getElementById('map');
        if (!mapDiv) return;

        if (mapInstance) {
            mapInstance.remove();
        }
        
        if (typeof L === 'undefined') {
            mapDiv.innerHTML = '<div class="alert alert-danger text-white text-center" role="alert">Komponen peta (Leaflet) tidak termuat.</div>';
            return;
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    
                    mapInstance = L.map('map', {
                        center: [lat, lon],
                        zoom: 16, // Zoom awal
                        dragging: false,
                        touchZoom: false,
                        scrollWheelZoom: false,
                        doubleClickZoom: false,
                        boxZoom: false,
                        keyboard: false,
                        zoomControl: false,
                        // **PERBAIKAN**: Batasi zoom agar tidak terlalu jauh atau terlalu dekat
                        minZoom: 16, 
                        maxZoom: 16
                    });
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                    }).addTo(mapInstance);

                    L.marker([lat, lon]).addTo(mapInstance);
                },
                function(error) {
                    let pesanError = 'GAGAL MENGAMBIL LOKASI. ';
                    switch(error.code) {
                        case error.PERMISSION_DENIED: pesanError += "Izin lokasi diblokir."; break;
                        case error.POSITION_UNAVAILABLE: pesanError += "Informasi lokasi tidak tersedia."; break;
                        case error.TIMEOUT: pesanError += "Waktu permintaan lokasi habis."; break;
                    }
                    mapDiv.innerHTML = `<div class="alert alert-danger text-white text-center" role="alert">${pesanError}</div>`;
                }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        } else {
            mapDiv.innerHTML = '<div class="alert alert-warning text-white text-center" role="alert">Browser Anda tidak mendukung Geolocation.</div>';
        }
    }

    async function cekData(code) {
        jQuery.ajax({
            url: "<?= base_url('scan/cek'); ?>",
            type: 'post',
            data: {
                'unique_code': code,
                'waktu': '<?= strtolower($waktu); ?>'
            },
            success: function(response, status, xhr) {
                audio.play();
                $('#hasilScan').html(response);
                
                $('html, body').animate({
                    scrollTop: $("#hasilScan").offset().top
                }, 500, function() {
                    // Panggil fungsi peta SETELAH animasi selesai
                    activateMap();
                });
            },
            error: function(xhr, status, thrown) {
                $('#hasilScan').html(thrown);
            }
        });
    }
</script>

<?= $this->endSection(); ?>
