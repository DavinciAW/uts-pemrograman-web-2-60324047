Nama: Davin Aurellio Widyadhana
NIM: 60324047

Deskripsi: Website ini merupakan sebuah Sistem Manajemen Kategori Buku yang digunakan untuk mengelola data buku berdasarkan kategori tertentu. Melalui website ini, pengguna dapat melakukan berbagai operasi seperti melihat daftar buku, menambahkan data buku baru, mengubah informasi buku, serta menghapus data buku yang sudah ada. Sistem ini dirancang untuk memudahkan pengelolaan data buku secara terstruktur dan efisien.

Cara Menggunakan:
Untuk menggunakan website ini, pengguna dapat mengikuti langkah-langkah berikut:
1. Pastikan telah menginstal web server (seperti XAMPP/Laragon) yang mendukung PHP dan MySQL.
2. Import file database (.sql) ke dalam phpMyAdmin atau database MySQL yang digunakan.
3. Letakkan folder project ke dalam direktori server (misalnya htdocs pada XAMPP).
4. Jalankan web server (Apache dan MySQL).
5. Akses website melalui browser dengan mengetikkan alamat localhost/uts_60324047.

Setelah website berjalan, pengguna dapat melakukan beberapa fungsi utama berikut:
- Melihat daftar buku berdasarkan kategori yang ditandai dengan format ID “KAT-XXX” (contoh: KAT-001, KAT-002, dan seterusnya).
- Menambahkan buku baru dengan menekan tombol “+ Tambahkan Buku”, kemudian mengisi data seperti ID kategori, judul, dan deskripsi buku.
- Mengedit data buku dengan menekan tombol “Edit”, lalu memperbarui informasi yang diperlukan.
- Menghapus buku dengan menekan tombol “Delete”. Perlu diperhatikan bahwa proses penghapusan bersifat permanen dan tidak dapat dibatalkan.

Struktur Folder:
uts_60324047/
├── config/
│   └── database.php
├── index.php
├── create.php
├── edit.php
├── delete.php
└── uts_60324047.sql (Database SQL)

Link repository:
https://github.com/DavinciAW/uts-pemrograman-web-2-60324047
