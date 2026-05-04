<?php
require_once 'config/database.php';

// validasi id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?message=ID tidak valid");
    exit;
}

$id = (int) $_GET['id'];

// cek apakah data ada
$check = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$check->bind_param("i", $id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php?message=Data tidak ditemukan");
    exit;
}

// proses delete
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// cek berhasil atau tidak
if ($stmt->affected_rows > 0) {
    header("Location: index.php?message=Kategori berhasil dihapus");
} else {
    header("Location: index.php?message=Gagal menghapus kategori");
}
exit;
?>