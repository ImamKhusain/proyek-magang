<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mencari Asal Penumpang KA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #0052A3;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #DC143C;
        }

        .logo-container {
            background-color: white;
            padding: 8px 12px;
            border-radius: 3px;
            display: flex;
            align-items: center;
        }

        .logo {
            height: 35px;
            width: auto;
            display: block;
        }

        .welcome {
            font-size: 14px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .title-box {
            background-color: #FFC107;
            color: #000;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-label {
            background-color: #FFC107;
            color: #000;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .input-field {
            padding: 12px 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            font-size: 14px;
            outline: none;
        }

        .input-field:focus {
            border-color: #0052A3;
            background-color: white;
        }

        .button-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .generate-button {
            background-color: #FFC107;
            color: #000;
            border: none;
            padding: 12px 50px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .generate-button:hover {
            background-color: #FFB300;
        }

        .result-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            min-height: 80px;
            border-radius: 5px;
        }

        .result-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .result-content {
            color: #555;
            line-height: 1.6;
        }

        .error {
            color: #d32f2f;
        }

        .success {
            color: #388e3c;
        }

        @media (max-width: 768px) {
            .input-row {
                grid-template-columns: 1fr;
            }
            
            .container {
                margin: 20px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="assets/logo.jpeg" alt="RTS 4.0 Logo" class="logo">
        </div>
        <div class="welcome">Welcome (nama akun)</div>
=======
<?php
// Koneksi database
include 'config/config.php';
$conn = db_connect();

// Proteksi halaman (wajib login)
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: auth/login.php");
    exit;
}

$hasil_pencarian = "";
$status_class = "";

if (isset($_POST['generate'])) {
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama_penumpang']));
    $nik  = mysqli_real_escape_string($conn, trim($_POST['id_passanger']));

    if (empty($nik) || strlen($nik) < 4) {
        $hasil_pencarian = "NIK minimal 4 digit.";
        $status_class = "error";
    } else {
        $kode_awal = substr($nik, 0, 4);

        $query = mysqli_query(
            $conn,
            "SELECT asal_daerah FROM kode_daerah WHERE kode_awal = '$kode_awal'"
        );

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $hasil_pencarian = "
                <strong>Nama Penumpang:</strong> " . htmlspecialchars($nama ?: '-') . "<br>
                <strong>NIK:</strong> " . htmlspecialchars($nik) . "<br>
                <strong>Asal Daerah:</strong> " . htmlspecialchars($row['asal_daerah']);
            $status_class = "success";
        } else {
            $hasil_pencarian = "Kode wilayah <b>$kode_awal</b> tidak ditemukan.";
            $status_class = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Asal Penumpang KA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
    }

    .top-right {
        position: absolute;
        top: 20px;
        right: 30px;
        color: #fff;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logout-btn {
        padding: 6px 12px;
        background: #FFC107;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #ffff;
    }

    .header {
        background: #0052A3;
        color: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 4px solid #DC143C;
    }

    .logo {
        height: 35px;
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
    }

    .title-box {
        background: #FFC107;
        text-align: center;
        padding: 20px;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 30px;
    }

    /* TAB */
    .tabs {
        display: flex;
        border-bottom: 3px solid #0052A3;
        margin-bottom: 30px;
    }

    .tab-btn {
        flex: 1;
        padding: 15px;
        border: none;
        cursor: pointer;
        font-weight: bold;
        background: #e0e0e0;
    }

    .tab-btn.active {
        background: #0052A3;
        color: white;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* FORM */
    .form-container {
        background: white;
        padding: 35px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .input-group {
        display: flex;
        flex-direction: column;
    }

    .input-label {
        background: #FFC107;
        padding: 8px 12px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .input-field {
        padding: 12px;
        border: 1px solid #ccc;
    }

    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    .generate-button {
        background: #FFC107;
        border: none;
        padding: 12px 50px;
        font-weight: bold;
        cursor: pointer;
    }

    .result-box {
        margin-top: 25px;
        border: 1px solid #ddd;
        padding: 20px;
        background: #fafafa;
    }

    .success {
        color: #2e7d32;
    }

    .error {
        color: #c62828;
    }

    @media (max-width: 768px) {
        .input-row {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>

    <div class="header">
        <img src="assets/logo.jpeg" class="logo">
        <div>

            <div class="top-right">
                Welcome, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>
                <a href="auth/logout.php" class="logout-btn">Logout</a>

            </div>

        </div>

>>>>>>> fitur-proses-excel-andika
    </div>

    <div class="container">
        <div class="title-box">
            Aplikasi Mencari Asal Penumpang Kereta Api
        </div>

<<<<<<< HEAD
        <div class="form-container">
            <form method="POST" action="">
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label">Masukkan Nama Penumpang</label>
                        <input type="text" name="nama_penumpang" class="input-field" 
                               value="<?php echo isset($_POST['nama_penumpang']) ? htmlspecialchars($_POST['nama_penumpang']) : ''; ?>" 
                               placeholder="Masukkan nama penumpang...">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Masukkan ID Passanger</label>
                        <input type="text" name="id_passanger" class="input-field" 
                               value="<?php echo isset($_POST['id_passanger']) ? htmlspecialchars($_POST['id_passanger']) : ''; ?>" 
                               placeholder="Masukkan ID passanger...">
                    </div>
                </div>

                <div class="button-container">
                    <button type="submit" name="generate" class="generate-button">Generate</button>
                </div>

                <div class="result-box">
                    <div class="result-title">Hasil berupa Nama Penumpang dan Asal Penumpang (hasil dari validasi ID Passanger)</div>
                    <div class="result-content">
                        <?php
                        // Simulasi database penumpang
                        $penumpang_data = [
                            'P001' => ['nama' => 'Ahmad Rizki', 'asal' => 'Jakarta'],
                            'P002' => ['nama' => 'Siti Nurhaliza', 'asal' => 'Bandung'],
                            'P003' => ['nama' => 'Budi Santoso', 'asal' => 'Surabaya'],
                            'P004' => ['nama' => 'Dewi Lestari', 'asal' => 'Yogyakarta'],
                            'P005' => ['nama' => 'Eko Prasetyo', 'asal' => 'Semarang'],
                        ];

                        if (isset($_POST['generate'])) {
                            $nama = trim($_POST['nama_penumpang']);
                            $id = trim($_POST['id_passanger']);
                            
                            if (empty($nama) && empty($id)) {
                                echo '<span class="error">Silakan masukkan Nama Penumpang atau ID Passanger!</span>';
                            } else {
                                $found = false;
                                
                                // Pencarian berdasarkan ID
                                if (!empty($id)) {
                                    if (isset($penumpang_data[$id])) {
                                        $data = $penumpang_data[$id];
                                        echo '<span class="success">✓ Data ditemukan!</span><br><br>';
                                        echo '<strong>Nama Penumpang:</strong> ' . htmlspecialchars($data['nama']) . '<br>';
                                        echo '<strong>ID Passanger:</strong> ' . htmlspecialchars($id) . '<br>';
                                        echo '<strong>Asal Penumpang:</strong> ' . htmlspecialchars($data['asal']);
                                        $found = true;
                                    }
                                }
                                
                                // Pencarian berdasarkan nama jika ID tidak ditemukan
                                if (!$found && !empty($nama)) {
                                    foreach ($penumpang_data as $pid => $data) {
                                        if (stripos($data['nama'], $nama) !== false) {
                                            echo '<span class="success">✓ Data ditemukan!</span><br><br>';
                                            echo '<strong>Nama Penumpang:</strong> ' . htmlspecialchars($data['nama']) . '<br>';
                                            echo '<strong>ID Passanger:</strong> ' . htmlspecialchars($pid) . '<br>';
                                            echo '<strong>Asal Penumpang:</strong> ' . htmlspecialchars($data['asal']);
                                            $found = true;
                                            break;
                                        }
                                    }
                                }
                                
                                if (!$found) {
                                    echo '<span class="error">✗ Data tidak ditemukan!</span><br><br>';
                                    echo 'Penumpang dengan ';
                                    if (!empty($id)) echo 'ID "' . htmlspecialchars($id) . '"';
                                    if (!empty($id) && !empty($nama)) echo ' atau ';
                                    if (!empty($nama)) echo 'nama "' . htmlspecialchars($nama) . '"';
                                    echo ' tidak ditemukan dalam database.';
                                }
                            }
                        } else {
                            echo '<em>Silakan masukkan data dan klik tombol Generate untuk mencari informasi penumpang.</em>';
                        }
                        ?>
                    </div>
                </div>
            </form>
=======
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab('manual', this)">Pencarian Manual</button>
            <button class="tab-btn" onclick="openTab('excel', this)">Upload Excel</button>
        </div>

        <!-- TAB MANUAL -->
        <div id="manual" class="tab-content active">
            <div class="form-container">
                <form method="POST">
                    <div class="input-row">
                        <div class="input-group">
                            <label class="input-label">Nama Penumpang</label>
                            <input type="text" name="nama_penumpang" class="input-field"
                                value="<?= htmlspecialchars($_POST['nama_penumpang'] ?? '') ?>">
                        </div>

                        <div class="input-group">
                            <label class="input-label">NIK Penumpang</label>
                            <input type="text" name="id_passanger" maxlength="16" class="input-field"
                                value="<?= htmlspecialchars($_POST['id_passanger'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="submit" name="generate" class="generate-button">Generate</button>
                    </div>

                    <div class="result-box">
                        <strong>Hasil Analisis:</strong><br><br>
                        <span class="<?= $status_class ?>">
                            <?= $hasil_pencarian ?: '<em>Masukkan data untuk memulai.</em>' ?>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <!-- TAB EXCEL -->
        <div id="excel" class="tab-content">
            <div class="form-container">
                <form action="proses_excel.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <label class="input-label">Upload File Excel (.xls)</label>
                        <input type="file" name="file_excel" class="input-field" accept=".xls" required>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="generate-button">Proses Excel</button>
                    </div>
                </form>
            </div>
>>>>>>> fitur-proses-excel-andika
        </div>
    </div>

    <script>
<<<<<<< HEAD
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const nama = document.querySelector('input[name="nama_penumpang"]').value.trim();
            const id = document.querySelector('input[name="id_passanger"]').value.trim();
            
            if (!nama && !id) {
                e.preventDefault();
                alert('Silakan masukkan Nama Penumpang atau ID Passanger!');
            }
        });
    </script>
</body>
=======
    function openTab(tabId, el) {
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        el.classList.add('active');
    }
    </script>

</body>

>>>>>>> fitur-proses-excel-andika
</html>