<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <style>
        body { background-color: #f8f9fa; }
        .form-label { font-weight: bold; }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm">
            <div class="card-header text-center bg-primary text-white">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus" value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" value="<?php echo isset($_POST['nim']) ? $_POST['nim'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="Wajib > 70 untuk lulus" min="0" max="100" value="<?php echo isset($_POST['kehadiran']) ? $_POST['kehadiran'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" min="0" max="100" value="<?php echo isset($_POST['tugas']) ? $_POST['tugas'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" min="0" max="100" value="<?php echo isset($_POST['uts']) ? $_POST['uts'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" min="0" max="100" value="<?php echo isset($_POST['uas']) ? $_POST['uas'] : ''; ?>">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['proses'])) {
                    $nama = $_POST['nama'];
                    $nim = $_POST['nim'];
                    // Gunakan floatval agar desimal aman
                    $kehadiran = floatval($_POST['kehadiran']);
                    $tugas = floatval($_POST['tugas']);
                    $uts = floatval($_POST['uts']);
                    $uas = floatval($_POST['uas']);

                    // 1. Validasi Input Kosong
                    if (empty($nama) || empty($nim)) {
                        echo "<div class='alert alert-danger mt-3' role='alert'>Kolom Nama dan NIM harus diisi!</div>";
                    } else {
                        // 2. Hitung Nilai Akhir
                        $nilai_akhir = ($kehadiran * 0.10) + ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.40);

                        // 3. Tentukan Grade (Sesuai Aturan Baru)
                        if ($nilai_akhir >= 85) { $grade = "A"; }
                        elseif ($nilai_akhir >= 70) { $grade = "B"; }
                        elseif ($nilai_akhir >= 55) { $grade = "C"; }
                        elseif ($nilai_akhir >= 40) { $grade = "D"; }
                        else { $grade = "E"; }

                        // 4. Tentukan Status Lulus/Tidak (Logika Kompleks)
                        // Syarat Lulus: NA >= 60 DAN Absen > 70 DAN Semua Komponen >= 40
                        if ($nilai_akhir >= 60 && $kehadiran > 70 && $tugas >= 40 && $uts >= 40 && $uas >= 40) {
                            $status = "LULUS";
                            $warna_tema = "success"; // Hijau
                        } else {
                            $status = "TIDAK LULUS";
                            $warna_tema = "danger"; // Merah
                        }

                        // 5. Tampilan Hasil (Card & Tombol menyesuaikan warna tema)
                        echo "<div class='card mt-3 shadow-sm border-$warna_tema'>";
                        // Header Card berubah warna sesuai $warna_tema
                        echo "<div class='card-header bg-$warna_tema text-white fw-bold'>Hasil Penilaian</div>";
                        echo "<div class='card-body'>";
                        
                        echo "<h5 class='card-title mb-3'>Nama: $nama <span class='float-end fs-6'>NIM: $nim</span></h5>";

                        echo "<ul class='list-group list-group-flush mb-3'>";
                        echo "<li class='list-group-item d-flex justify-content-between'>Nilai Kehadiran: <span>$kehadiran</span></li>";
                        echo "<li class='list-group-item d-flex justify-content-between'>Nilai Tugas: <span>$tugas</span></li>";
                        echo "<li class='list-group-item d-flex justify-content-between'>Nilai UTS: <span>$uts</span></li>";
                        echo "<li class='list-group-item d-flex justify-content-between'>Nilai UAS: <span>$uas</span></li>";
                        
                        echo "<li class='list-group-item d-flex justify-content-between fw-bold'>Nilai Akhir: <span>" . number_format($nilai_akhir, 2) . "</span></li>";
                        echo "<li class='list-group-item d-flex justify-content-between fw-bold'>Grade: <span>$grade</span></li>";
                        
                        // Menampilkan Status dengan warna teks sesuai tema
                        echo "<li class='list-group-item d-flex justify-content-between fw-bold'>Status: <span class='text-$warna_tema'>$status</span></li>";
                        echo "</ul>";

                        // Info tambahan kenapa tidak lulus (Opsional, agar user paham)
                        if ($status == "TIDAK LULUS") {
                            echo "<div class='alert alert-warning py-2 small'>";
                            echo "<strong>Catatan:</strong> Tidak lulus jika Kehadiran ≤ 70, Nilai Akhir < 60, atau ada komponen nilai < 40.";
                            echo "</div>";
                        }

                        // Tombol Selesai berubah warna sesuai $warna_tema
                        echo "<a href='' class='btn btn-$warna_tema w-100'>Selesai</a>";
                        
                        echo "</div>"; // end card-body
                        echo "</div>"; // end card
                    }
                }
                ?>
                </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>
</html>