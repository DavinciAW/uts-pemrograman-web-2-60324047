<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';

    // query data kategori
    $query = "SELECT id_kategori, kode_kategori, nama_kategori, deskripsi, status 
              FROM kategori 
              ORDER BY id_kategori DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Kategori Buku</h2>
            <a href="create.php" class="btn btn-primary">Tambah Kategori</a>
        </div>
        
        <!-- pesan untuk sukses/error -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th width="120">Kode</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="120">Status</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // untuk cek query
                        if ($result->num_rows > 0) {
                            $no = 1;
                            // buat loop data
                            while ($row = $result->fetch_assoc()) {

                                // badge status
                                if ($row['status'] === 'Aktif') {
                                    $statusBadge = '<span class="badge bg-success">Aktif</span>';
                                } else {
                                    $statusBadge = '<span class="badge bg-danger">Nonaktif</span>';
                                }
                        ?>
                        <!-- untuk tampilkan data -->
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['kode_kategori']); ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                            <td><?= $statusBadge; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_kategori']; ?>" 
                                   class="btn btn-warning btn-sm">Edit</a>
                                <button onclick="confirmDelete(<?= $row['id_kategori']; ?>)" 
                                        class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data kategori</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>