<?php

use App\Libraries\enums\TipeUser;

switch ($type) {
    case TipeUser::Siswa:
?>
      <h3 class="text-success">Absen <?= esc($waktu); ?> berhasil</h3>
      <div class="row w-100">
          <div class="col">
              <p>Nama : <b><?= esc($data['nama_siswa']); ?></b></p>
              <p>NIS : <b><?= esc($data['nis']); ?></b></p>
              <p>Kelas : <b><?= esc($data['kelas'] . ' ' . $data['jurusan']); ?></b></p>
          </div>
          <div class="col">
              <?= jam($presensi); ?>
          </div>
      </div>
    <?php break;

    case TipeUser::Guru:
    ?>
      <h3 class="text-success">Absen <?= esc($waktu); ?> berhasil</h3>
      <div class="row w-100">
          <div class="col">
              <p>Nama : <b><?= esc($data['nama_guru']); ?></b></p>
              <p>NUPTK : <b><?= esc($data['nuptk']); ?></b></p>
              <p>No HP : <b><?= esc($data['no_hp']); ?></b></p>
          </div>
          <div class="col">
              <?= jam($presensi); ?>
          </div>
      </div>
    <?php break;

    default:
    ?>
      <h3 class="text-danger">Tipe tidak valid</h3>
    <?php
        break;
}

function jam($presensi)
{
    ?>
    <p>Jam masuk : <b class="text-info"><?= esc($presensi['jam_masuk'] ?? '-'); ?></b></p>
    <p>Jam pulang : <b class="text-info"><?= esc($presensi['jam_keluar'] ?? '-'); ?></b></p>
<?php
}
?>

<!-- Kartu untuk Laporan Posisi Maps -->
<div class="card mt-4">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">map</i>
        </div>
        <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Laporan Posisi</p>
            <h4 class="mb-0">Lokasi Presensi Anda</h4>
        </div>
    </div>
    <hr class="dark horizontal my-0">
    <div class="card-body">
        <div id="map" style="height: 400px; width: 100%; border-radius: .75rem; background-color: #eee;"></div>
    </div>
</div>
