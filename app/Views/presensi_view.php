<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Presensi Siswa</h1>

    <form id="presensiForm">
        <input type="hidden" id="student_id" name="student_id" value="1234"> <!-- ID Siswa -->
        <button type="button" onclick="getLocation()">Scan QR dan Presensi</button>
    </form>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    // Kirim data ke server menggunakan AJAX
                    $.ajax({
                        url: '/absensi/presensi',
                        method: 'POST',
                        data: {
                            student_id: $('#student_id').val(),
                            latitude: latitude,
                            longitude: longitude
                        },
                        success: function(response) {
                            alert("Presensi berhasil!");
                        }
                    });
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }
    </script>
</body>
</html>
