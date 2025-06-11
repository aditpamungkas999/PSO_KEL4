<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    public function presensi()
    {
        $studentId = $this->request->getPost('student_id');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $waktuPresensi = date('H:i:s');

        // Simpan data presensi ke dalam database
        $model = new AbsensiModel();
        $model->save([
            'student_id' => $studentId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'waktu_presensi' => $waktuPresensi,
        ]);

        // Anda bisa mengarahkan pengguna ke halaman konfirmasi
        return redirect()->to('/absensi/success');
    }
}
