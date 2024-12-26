<?php
// Pastikan fungsi hitungPosterior sudah didefinisikan di function.php dan di-include di sini
include('function.php');

// Ambil data JSON untuk training
$filePath = 'C:\\xampp_7\\htdocs\\NaiveBayes\\training.json'; 
$data = ambilDataJSON($filePath);

// Variabel untuk menampung hasil
$prediksi = '';
$posterior = '';
$atributValues = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai atribut dari form
    $umur = $_POST['umur'];
    $jenisKelamin = $_POST['jenis_kelamin'];
    $kelas = $_POST['kelas'];
    $tempatTinggal = $_POST['tempat_tinggal'];
    $gunakanHP = $_POST['gunakan_hp'];
    $gunakanLaptop = $_POST['gunakan_laptop'];

    // Masukkan atribut tersebut dalam array untuk perhitungan posterior
    $atributValues = [
        'Umur' => $umur,
        'Jenis Kelamin' => $jenisKelamin,
        'Kelas' => $kelas,
        'Tempat Tinggal' => $tempatTinggal,
        'Gunakan HP' => $gunakanHP,
        'Gunakan Laptop' => $gunakanLaptop
    ];

    // Hitung posterior probability berdasarkan atribut
    $posterior = hitungPosterior($data, $atributValues);

    // Prediksi Akses Internet berdasarkan inputan
    $prediksi = prediksiAksesInternet($data, $atributValues);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Akses Internet</title>
    <!-- Link ke Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-bs-theme="dark">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Prediksi Akses Internet Berdasarkan Data Pengguna</h1>
        
        <!-- Form inputan pengguna sudah ada sebelumnya, sekarang fokus pada hasil -->
        
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <!-- Tampilkan hasil prediksi -->
            <div class="alert alert-info">
                <h4>Hasil Prediksi:</h4>
                <p><strong>Akses Internet: </strong> <?= $prediksi ?></p>
            </div>
            
            <!-- Tampilkan hasil perhitungan posterior -->
            <div class="alert alert-secondary">
                <h4>Posterior Probability:</h4>
                <pre><?= print_r($posterior, true); ?></pre>
            </div>

            <!-- Tampilkan inputan pengguna -->
            <h5>Data yang Dimasukkan:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Fitur</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($atributValues as $fitur => $nilai): ?>
                        <tr>
                            <td><?= $fitur ?></td>
                            <td><?= $nilai ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Tampilkan semua data training yang digunakan -->
            <h5>Data Training:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Tempat Tinggal</th>
                        <th>Gunakan HP</th>
                        <th>Gunakan Laptop</th>
                        <th>Akses Internet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= $row['Umur'] ?></td>
                            <td><?= $row['Jenis Kelamin'] ?></td>
                            <td><?= $row['Kelas'] ?></td>
                            <td><?= $row['Tempat Tinggal'] ?></td>
                            <td><?= $row['Gunakan HP'] ?></td>
                            <td><?= $row['Gunakan Laptop'] ?></td>
                            <td><?= $row['Akses Internet'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Link ke JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
