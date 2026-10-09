<?php
mysqli_report(MYSQLI_REPORT_OFF);
$k = mysqli_connect('localhost', 'root', '', 'db_topik_riset'); 

// Hapus topik (DELETE)
if (isset($_POST['hapus'])) {
    $id = mysqli_real_escape_string($k, $_POST['hapus']);
    mysqli_query($k, "DELETE FROM topik WHERE id = '$id'");
    header('Location: index.php');
    exit;
}

$cari = $_GET['cari'] ?? '';
$kata = mysqli_real_escape_string($k, $cari);
$hasil = mysqli_query($k, "SELECT id, nama FROM topik WHERE nama LIKE '%$kata%' ORDER BY nama");

$daftar_topik = [];
while ($r = mysqli_fetch_assoc($hasil)) {
    $daftar_topik[$r['id']] = ['nama' => htmlspecialchars($r['nama'])];
}
?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Topik Riset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px 40px;
            background-color: #fdfbf7;
        }
        .header {
            background-color: #ffe4e1;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        input[type="text"] {
            padding: 5px 8px;
            border: 1px solid #ffb6c1;
            border-radius: 4px;
        }
        .btn {
            padding: 5px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            border: 1px solid #ffb6c1;
            cursor: pointer;
            background: #ffe4e1;
            color: black;
        }
        .btn-tambah {
            background: #ffd1dc;
            font-weight: bold;
        }
        .btn-edit, .btn-hapus {
            background: #b2ebf2;
            border: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }
        th {
            background-color: #ffe4e1;
            text-align: left;
            padding: 12px;
            font-size: 14px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- Judul Atas -->
    <div class="header">
        <h1>TOPIK RISET & BIDANG MINAT</h1>
    </div>

    <!-- Pencarian & Tombol Tambah -->
    <div class="top-bar">
        <form method="get">
            <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>" placeholder="Cari topik...">
            <button type="submit" class="btn">Cari</button>
        </form>
        <a href="tambah.php" class="btn btn-tambah">+ Tambah Topik</a>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 100px;">ID</th>
                <th>Nama Topik</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($daftar_topik as $id => $topik): ?>
                <tr>
                    <td><b><?= strtoupper($id) ?></b></td>
                    <td>
                        <a href="detail.php?id=<?= $id ?>" style="color: black; text-decoration: none;">
                            <?= $topik['nama'] ?>
                        </a>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $id ?>" class="btn btn-edit">Edit</a>
                        <form method="post" style="display: inline;" onsubmit="return confirm('Hapus topik ini?')">
                            <button type="submit" name="hapus" value="<?= $id ?>" class="btn btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$daftar_topik): ?>
                <tr><td colspan="3">Topik tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>