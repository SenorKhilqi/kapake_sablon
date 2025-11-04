# Sablon Custom - PHP Native E-commerce (Minimal)

Instalasi cepat untuk menjalankan project di XAMPP (Windows):

1. Copy folder ini ke `C:\xampp\htdocs\sablon` (sudah berada di sana jika Anda bekerja di workspace ini).
2. Import database: buka `phpmyadmin` -> Buat database bernama `sablon_custom` -> Import file `database/sablon_custom.sql`.
3. Pastikan konfigurasi database di `includes/config.php` sesuai (DB_HOST, DB_USER, DB_PASS).
4. Ubah nomor admin WhatsApp di `includes/config.php` (konstanta ADMIN_WA) ke format internasional tanpa tanda `+`.
5. Jalankan aplikasi: buka http://localhost/sablon

Catatan:
- Gambar produk pada SQL menunjuk ke `assets/img/*.jpg`. Letakkan gambar dengan nama yang sesuai di folder `assets/img`.
- Folder `assets/uploads` dibuat otomatis untuk menyimpan file desain yang diupload user.
- Admin default ada di tabel `users` (email: admin@sablonku.com). Password hash pada SQL adalah dummy — buat akun admin via pendaftaran lalu ubah role ke `admin` di database, atau insert user admin manual.

Jika Anda sudah mengimpor database lama yang menggunakan status 'Diproses', jalankan query berikut di phpMyAdmin untuk menyesuaikan kolom `status`:

```sql
ALTER TABLE `orders` MODIFY `status` ENUM('Menunggu Pembayaran','Sudah Dibayar','Selesai') DEFAULT 'Menunggu Pembayaran';
```


Perbaikan yang direkomendasikan:
- Tambahkan validasi, handling error lebih lengkap, dan CSRF protection.
- Tambahkan pagination, search, dan image thumbnails.
