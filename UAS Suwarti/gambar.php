<?php
// Start session untuk menyimpan data sementara
session_start();

// Inisialisasi data jika belum ada
if (!isset($_SESSION['dataPerson'])) {
    $_SESSION['dataPerson'] = [
        ['id' => 1, 'nama' => 'Ahmad', 'nik' => '1234567890', 'tgl_lahir' => '1990-01-01', 'jenis_kelamin' => 'Laki-Laki', 'no_hp' => '081234567890', 'email' => 'ahmad@example.com', 'alamat' => 'Jakarta', 'foto' => 'foto1.jpg'],
        ['id' => 2, 'nama' => 'Siti', 'nik' => '0987654321', 'tgl_lahir' => '1995-05-15', 'jenis_kelamin' => 'Perempuan', 'no_hp' => '081987654321', 'email' => 'siti@example.com', 'alamat' => 'Bandung', 'foto' => 'foto2.jpg']
    ];
}

// Tambah/Edit Data
if (isset($_POST['simpan'])) {
    $id = $_POST['id'] ? $_POST['id'] : count($_SESSION['dataPerson']) + 1;
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $foto = $_POST['foto'];

    if (isset($_POST['edit_id']) && $_POST['edit_id'] !== '') {
        // Edit data
        $index = $_POST['edit_id'];
        $_SESSION['dataPerson'][$index] = compact('id', 'nama', 'nik', 'tgl_lahir', 'jenis_kelamin', 'no_hp', 'email', 'alamat', 'foto');
    } else {
        // Tambah data baru
        $_SESSION['dataPerson'][] = compact('id', 'nama', 'nik', 'tgl_lahir', 'jenis_kelamin', 'no_hp', 'email', 'alamat', 'foto');
    }
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($_SESSION['dataPerson'][$id]);
    $_SESSION['dataPerson'] = array_values($_SESSION['dataPerson']); // Reindex array
}

$dataPerson = $_SESSION['dataPerson'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Person</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ddd; text-align: center; }
        th, td { padding: 10px; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 4px; }
        .btn-edit { background-color: #f1c40f; }
        .btn-hapus { background-color: #e74c3c; }
        input, button { padding: 5px; }
        form { margin: 10px 0; }
        img { width: 50px; height: 50px; border-radius: 50%; }
    </style>
</head>
<body>
    <h2>Data Person</h2>

    <!-- Form Tambah/Edit Data -->
    <h3>Form Tambah/Edit Data</h3>
    <form method="POST">
        <input type="hidden" name="edit_id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="text" name="nik" placeholder="NIK" required>
        <input type="date" name="tgl_lahir" required>
        <input type="text" name="jenis_kelamin" placeholder="Jenis Kelamin" required>
        <input type="text" name="no_hp" placeholder="No Handphone" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="text" name="foto" placeholder="Nama File Foto (contoh: foto1.jpg)" required>
        <button type="submit" name="simpan">Simpan</button>
    </form>

    <!-- Tabel Data -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>No Handphone</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php if (count($dataPerson) > 0): ?>
            <?php foreach ($dataPerson as $index => $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                    <td><?php echo htmlspecialchars($item['nik']); ?></td>
                    <td><?php echo htmlspecialchars($item['tgl_lahir']); ?></td>
                    <td><?php echo htmlspecialchars($item['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($item['no_hp']); ?></td>
                    <td><?php echo htmlspecialchars($item['email']); ?></td>
                    <td><?php echo htmlspecialchars($item['alamat']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['foto']); ?>" alt="Foto"></td>
                    <td>
                        <a href="inputdata.php" class="btn btn-edit">Edit</a>
                        <a href="?hapus=<?php echo $index; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-hapus">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">Tidak ada data.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>