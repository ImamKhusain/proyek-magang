<?php
/**
 * =========================================================
 * PROSES ANALISIS EXCEL – HASIL ASAL PENUMPANG KA
 * =========================================================
 */
session_start();

require 'vendor/autoload.php';
include 'config/config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

/* =========================================================
   VALIDASI EXTENSION ZIP
   ========================================================= */
if (!class_exists('ZipArchive')) {
    die("
        <div style='
            font-family:Arial;
            max-width:600px;
            margin:80px auto;
            padding:24px;
            background:#fff3cd;
            border:1px solid #ffe69c;
            border-radius:8px;
        '>
            <h2 style='color:#664d03'>Ekstensi ZIP belum aktif</h2>
            <p>PhpSpreadsheet membutuhkan <b>ZipArchive</b> untuk membaca file Excel (.xlsx).</p>
            <p>Silakan aktifkan <code>extension=zip</code> di <b>php.ini</b>, lalu restart Laragon.</p>
        </div>
    ");
}

/* =========================================================
   VALIDASI FILE
   ========================================================= */
if (!isset($_FILES['file_excel']) || $_FILES['file_excel']['error'] !== 0) {
    die("File Excel tidak ditemukan atau gagal diunggah.");
}

/* =========================================================
   KONEKSI DATABASE
   ========================================================= */
$conn = db_connect();

/* =========================================================
   LOAD EXCEL
   ========================================================= */
$fileTmp = $_FILES['file_excel']['tmp_name'];
$spreadsheet = IOFactory::load($fileTmp);
$sheet = $spreadsheet->getActiveSheet();

/* =========================================================
   VARIABEL
   ========================================================= */
$total = 0;
$valid = 0;
$tidak_ditemukan = 0;
$dataHasil = [];

/* =========================================================
   PROSES DATA
   ========================================================= */
for ($row = 7; $row <= $sheet->getHighestRow(); $row++) {

    $nama = trim((string)$sheet->getCell("J$row")->getValue());
    $nik  = trim((string)$sheet->getCell("K$row")->getValue());

    if ($nik === '') continue;
    $total++;

    if (!preg_match('/^[0-9]{16}$/', $nik)) continue;
    $valid++;

    $kode_awal = substr($nik, 0, 4);

    $query = mysqli_query(
        $conn,
        "SELECT asal_daerah FROM kode_daerah WHERE kode_awal = '$kode_awal'"
    );

    if (mysqli_num_rows($query) > 0) {
        $asal = mysqli_fetch_assoc($query)['asal_daerah'];
        $status = 'found';
    } else {
        $asal = 'Tidak ditemukan';
        $status = 'notfound';
        $tidak_ditemukan++;
    }

    $dataHasil[] = [
        'nama' => $nama,
        'nik'  => $nik,
        'kode' => $kode_awal,
        'asal' => $asal,
        'status' => $status
    ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Asal Penumpang KA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    :root {
        --blue: #0052A3;
        --red: #DC143C;
        --yellow: #FFC107;
        --shadow: 0 6px 18px rgba(0, 0, 0, .08);
    }

    * {
        box-sizing: border-box
    }

    body {
        margin: 0;
        font-family: Segoe UI, Arial, sans-serif;
        background: #f4f6f8;
    }

    /* ================= NAVBAR ================= */
    .header {
        background: var(--blue);
        color: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .header::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 4px;
        background: var(--red);
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-left img {
        height: 36px
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 14px;
    }

    .logout-btn {
        padding: 6px 14px;
        background: #FFC107;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 700;
    }

    .logout-btn:hover {
        background: #ffff;
    }

    /* ================= CONTENT ================= */
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .title-wrap {
        text-align: center
    }

    .title {
        background: var(--yellow);
        display: inline-block;
        padding: 12px 30px;
        font-weight: 800;
        margin: 24px auto;
        border-radius: 4px;
        box-shadow: var(--shadow);
    }

    .summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .card {
        background: #fff;
        padding: 18px;
        border-radius: 6px;
        box-shadow: var(--shadow);
    }

    .card span {
        color: #6b7280;
        font-size: 13px
    }

    .card h3 {
        margin: 8px 0 0;
        font-size: 28px
    }

    .table-box {
        background: #fff;
        border-radius: 6px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-title {
        padding: 14px 18px;
        font-weight: 700;
    }

    .table-scroll {
        max-height: 480px;
        overflow: auto
    }

    table {
        width: 100%;
        border-collapse: collapse
    }

    thead th {
        position: sticky;
        top: 0;
        background: var(--blue);
        color: #fff;
        padding: 12px;
        text-align: left;
    }

    tbody td {
        padding: 12px;
        border-bottom: 1px solid #eee
    }

    tbody tr:nth-child(even) {
        background: #f9fbfd
    }

    .badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .found {
        background: #e6f4ea;
        color: #1e7e34
    }

    .notfound {
        background: #fff3cd;
        color: #856404
    }
    </style>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <div class="header">
        <div class="nav-left">
            <img src="assets/logo.jpeg" alt="Logo">
        </div>
        <div class="nav-right">
            Welcome, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>
            <a href="auth/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">

        <a href="dashboard.php">←</a>

        <div class="title-wrap">
            <div class="title">Hasil Asal Penumpang KA</div>
        </div>

        <div class="summary">
            <div class="card">
                <span>Total Data Dibaca</span>
                <h3><?= $total ?></h3>
            </div>
            <div class="card">
                <span>NIK Valid</span>
                <h3><?= $valid ?></h3>
            </div>
            <div class="card">
                <span>Tidak Ditemukan</span>
                <h3><?= $tidak_ditemukan ?></h3>
            </div>
        </div>

        <div class="table-box">
            <div class="table-title">Hasil Analisis Data Penumpang</div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Kode</th>
                            <th>Asal Daerah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataHasil as $i => $d): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= htmlspecialchars($d['nama']) ?></td>
                            <td><?= $d['nik'] ?></td>
                            <td><?= $d['kode'] ?></td>
                            <td><?= htmlspecialchars($d['asal']) ?></td>
                            <td>
                                <span class="badge <?= $d['status'] ?>">
                                    <?= $d['status']==='found'?'Ditemukan':'Tidak ditemukan' ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>