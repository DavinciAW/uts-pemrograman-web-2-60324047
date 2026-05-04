<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
require_once 'config/database.php';

$errors = [];

// ambil id dari get
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?message=ID tidak valid");
    exit;
}

$id = (int) $_GET['id'];

// retrieve data
$stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php?message=Data tidak ditemukan");
    exit;
}

$data = $result->fetch_assoc();

// set default dari database
$kode = $data['kode_kategori'];
$nama = $data['nama_kategori'];
$deskripsi = $data['deskripsi'];
$status = $data['status'];

// bagian proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ambil & sanitasi
    $kode = htmlspecialchars(trim($_POST['kode']));
    $nama = htmlspecialchars(trim($_POST['nama']));
    $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
    $status = isset($_POST['status']) ? $_POST['status'] : 'Aktif';

    // validasi kode kategri
    if (empty($kode)) {
        $errors[] = "Kode kategori wajib diisi";
    } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
        $errors[] = "Kode kategori harus 4-10 karakter";
    } elseif (!preg_match('/^KAT\-/', $kode)) {
        $errors[] = "Kode harus diawali dengan 'KAT-'";
    }

    // validsi nama
    if (empty($nama)) {
        $errors[] = "Nama kategori wajib diisi";
    } elseif (strlen($nama) < 3) {
        $errors[] = "Nama kategori minimal 3 karakter";
    } elseif (strlen($nama) > 50) {
        $errors[] = "Nama kategori maksimal 50 karakter";
    }

    // validasi deskripsi
    if (!empty($deskripsi) && strlen($deskripsi) > 200) {
        $errors[] = "Deskripsi maksimal 200 karakter";
    }

    // validasi status
    if (!in_array($status, ['Aktif', 'Nonaktif'])) {
        $errors[] = "Status tidak valid";
    }

    // cek duplikat
    if (empty($errors)) {
        $check = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
        $check->bind_param("si", $kode, $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errors[] = "Kode kategori sudah digunakan";
        }
    }

    // update data
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE kategori SET kode_kategori=?, nama_kategori=?, deskripsi=?, status=? WHERE id_kategori=?");
        $stmt->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

        if ($stmt->execute()) {
            header("Location: index.php?message=Kategori berhasil diupdate");
            exit;
        } else {
            $errors[] = "Gagal mengupdate data";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Edit Kategori</h4>
                </div>
                <div class="card-body">

                    <!-- error! -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <!-- kode kategori -->
                        <div class="mb-3">
                            <label class="form-label">Kode Kategori</label>
                            <input type="text" name="kode" class="form-control"
                                   value="<?= $kode; ?>" required>
                        </div>

                        <!-- nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?= $nama; ?>" required>
                        </div>

                        <!-- deskripsi -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"><?= $deskripsi; ?></textarea>
                        </div>

                        <!-- status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label><br>

                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="Aktif"
                                    <?= ($status == 'Aktif') ? 'checked' : ''; ?>>
                                <label>Aktif</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="Nonaktif"
                                    <?= ($status == 'Nonaktif') ? 'checked' : ''; ?>>
                                <label>Nonaktif</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>