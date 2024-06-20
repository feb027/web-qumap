# Projek Kelompok UAS Universitas Siliwangi - Mata Kuliah Basis Data

## Deskripsi Proyek
Proyek ini merupakan bagian dari Ujian Akhir Semester (UAS) untuk mata kuliah Basis Data di Universitas Siliwangi. Proyek ini bertujuan untuk mengembangkan sebuah aplikasi berbasis web yang dapat mengelola berbagai jenis data.

## Fitur
- **Manajemen Pengguna**: Fitur untuk menambah, mengedit, dan menghapus pengguna.
- **Manajemen Data**: Fitur untuk menambah, mengedit, dan menghapus data.
- **Autentikasi**: Sistem login dan logout untuk keamanan aplikasi.
- **Laporan**: Fitur untuk menghasilkan laporan berdasarkan data yang ada.

## Struktur Proyek
- `index.php`: Halaman utama aplikasi.
- `koneksi.php`: File untuk mengatur koneksi ke database.
- `logout.php`: File untuk menangani proses logout.
- `materi_indonesia.php`, `materi_inggris.php`, `materi_ipa.php`, `materi_ips.php`, `materi_matematika.php`, `materi_pai.php`, `materi_pjok.php`, `materi_pkn.php`: File-file untuk menampilkan materi pelajaran.
- `paket2.php`: File untuk menampilkan paket-paket data.
- `payment.php`: File untuk menangani proses pembayaran.
- `process_subscribe.php`: File untuk menangani proses langganan.
- `style.css`: File CSS untuk styling aplikasi.
- `subscribe.css`: File CSS tambahan untuk halaman langganan.
- `subscribe.php`: File untuk halaman langganan.

## Instalasi
1. Clone repository ini ke dalam direktori lokal Anda:
   ```bash
   git clone https://github.com/feb027/web-qumap.git
   ```
2. Masuk ke direktori proyek:
   ```bash
   cd web-qumap
   ```
3. Buat database dan import file SQL yang disediakan.
4. Konfigurasi file `koneksi.php` dengan detail database Anda.
5. Jalankan aplikasi di server lokal Anda.

## Penggunaan
1. Buka browser dan akses aplikasi melalui URL yang sesuai dengan konfigurasi server lokal Anda.
2. Login menggunakan akun yang telah terdaftar.
3. Gunakan fitur-fitur yang tersedia sesuai kebutuhan.

## Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, silakan fork repository ini dan buat pull request dengan perubahan yang Anda usulkan.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).
