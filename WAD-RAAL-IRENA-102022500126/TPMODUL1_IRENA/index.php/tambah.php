<?php
mysqli_report(MYSQLI_REPORT_OFF);
$k = mysqli_connect('localhost', 'root', '', 'db_topik_riset'); 
$pesan = '';

if (isset($_POST['simpan'])) {
    $id = strtolower(trim($_POST['id']));
    $nama = trim($_POST['nama']);
    $topik_utama = trim($_POST['topik_utama']);
    $keywords = trim($_POST['keywords']);
    $deskripsi = trim($_POST['deskripsi']);
    $studi_kasus = trim($_POST['studi_kasus']);

    if (!preg_match('/^[a-z0-9_-]{1,50}$/', $id)) {
        $pesan = 'ID hanya boleh huruf kecil, angka, - dan _';
    } else {
        $stmt = mysqli_prepare($k, "INSERT INTO topik (id, nama, topik_utama, keywords, deskripsi, studi_kasus) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssss', $id, $nama, $topik_utama, $keywords, $deskripsi, $studi_kasus);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit;
        }
        $pesan = "Gagal menyimpan, ID '$id' mungkin sudah dipakai";
    }
}
?>
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Tambah Topik</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px 40px; background-color: #fdfbf7; }
        .header { background-color: #ffe4e1; padding: 20px; text-align: center; border-radius: 10px; margin-bottom: 25px; }
        .header h1 { margin: 0; font-size: 24px; letter-spacing: 1px; }
        .box { max-width: 560px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 10px; }
        label { display: block; font-weight: bold; margin: 12px 0 5px; font-size: 14px; }
        input[type="text"], textarea { width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ffb6c1; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px; }
        textarea { min-height: 70px; }
        small { color: #888; font-weight: normal; }
        .btn { padding: 6px 14px; border-radius: 4px; text-decoration: none; font-size: 13px; border: 1px solid #ffb6c1; cursor: pointer; background: #ffe4e1; color: black; }
        .btn-simpan { background: #ffd1dc; font-weight: bold; }
        .error { background: #f8d7da; color: #842029; padding: 8px 12px; border-radius: 4px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header"><h1>TAMBAH TOPIK</h1></div>
    <div class="box">
        <?php if ($pesan): ?><div class="error"><?= htmlspecialchars($pesan) ?></div><?php endif; ?>
        <form method="post">
            <label>ID <small>(contoh: datamining)</small></label>
            <input type="text" name="id" value="<?= htmlspecialchars($_POST['id'] ?? '') ?>" required>

            <label>Nama Topik</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>

            <label>Topik Riset Utama</label>
            <input type="text" name="topik_utama" value="<?= htmlspecialchars($_POST['topik_utama'] ?? '') ?>">

            <label>Kata Kunci <small>(pisahkan dengan koma)</small></label>
            <input type="text" name="keywords" value="<?= htmlspecialchars($_POST['keywords'] ?? '') ?>">

            <label>Deskripsi Fokus</label>
            <textarea name="deskripsi"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>

            <label>Studi Kasus</label>
            <textarea name="studi_kasus"><?= htmlspecialchars($_POST['studi_kasus'] ?? '') ?></textarea>

            <br><br>
            <a href="index.php" class="btn">Batal</a>
            <button type="submit" name="simpan" class="btn btn-simpan">Simpan</button>
        </form>
    </div>
</body>
</html>