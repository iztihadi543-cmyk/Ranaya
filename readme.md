# RANAYA OUTDOOR

**Sistem Informasi Penyewaan Perlengkapan Outdoor**

## 1. Deskripsi Proyek

Ranaya Outdoor merupakan sistem informasi berbasis web yang dikembangkan untuk membantu proses pengelolaan penyewaan perlengkapan outdoor. Sistem ini dirancang untuk mempermudah pelanggan dalam melihat perlengkapan yang tersedia serta membantu pengelola dalam mengatur data barang, kategori, pesanan, dan pembayaran.

Sistem ini dikembangkan untuk satu usaha penyewaan perlengkapan outdoor, bukan sebagai marketplace.

## 2. Tujuan Pengembangan

Tujuan pengembangan sistem Ranaya Outdoor adalah:

- Mempermudah pelanggan dalam memperoleh informasi perlengkapan outdoor.
- Mempermudah pengelolaan data barang dan kategori.
- Membantu pengelola mengatur pesanan penyewaan.
- Mendukung pencatatan pembayaran dan verifikasi secara manual.
- Membantu pengelolaan unit barang dan kondisi perlengkapan.

## 3. Teknologi yang Digunakan

Teknologi yang digunakan dalam pengembangan sistem:

| Teknologi | Kegunaan |
|---|---|
| PHP Native | Pengembangan backend |
| MySQL | Pengelolaan database |
| HTML | Struktur halaman web |
| CSS | Tampilan antarmuka |
| JavaScript | Interaksi pada halaman web |
| Laragon | Lingkungan pengembangan lokal |
| phpMyAdmin | Pengelolaan database |

## 4. Struktur Folder

```text
ranaya-outdoor/
│
├── config/
│   ├── database.php
│   └── auth.php
│
├── proses/
│   ├── login.php
│   ├── register.php
│   ├── barang.php
│   ├── kategori.php
│   └── pesanan.php
│
├── admin/
│   ├── dashboard.php
│   ├── barang.php
│   ├── kategori.php
│   └── pesanan.php
│
├── penyewa/
│   ├── dashboard.php
│   ├── katalog.php
│   ├── keranjang.php
│   └── pesanan.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── index.php
├── login.php
├── register.php
├── logout.php
└── README.md
```

## 5. Persyaratan Sistem

Sebelum menjalankan proyek, pastikan perangkat telah memiliki:

- Windows 10 atau Windows 11.
- Laragon.
- PHP.
- MySQL.
- Browser seperti Google Chrome atau Mozilla Firefox.
- Editor kode seperti Visual Studio Code.

## 6. Cara Instalasi dan Menjalankan Sistem

### A. Menyiapkan Proyek

1. Pastikan Laragon sudah terinstal.
2. Letakkan folder `ranaya-outdoor` di dalam direktori:

   ```text
   C:\laragon\www\
   ```

3. Pastikan struktur folder proyek sudah sesuai.

### B. Menjalankan Laragon

1. Buka aplikasi Laragon.
2. Klik tombol **Start All**.
3. Pastikan Apache dan MySQL berjalan.

### C. Menyiapkan Database

1. Buka browser.
2. Akses phpMyAdmin melalui:

   ```text
   http://localhost/phpmyadmin
   ```

3. Buat database dengan nama:

   ```text
   ranaya_outdoor
   ```

4. Import file SQL database Ranaya Outdoor yang telah disiapkan.
5. Pastikan tabel berhasil dibuat.

### D. Konfigurasi Database

Buka file:

```text
config/database.php
```

Sesuaikan konfigurasi koneksi database dengan pengaturan MySQL pada perangkat:

```php
$host = '127.0.0.1';
$port = '3306';
$dbname = 'ranaya_outdoor';
$username = 'root';
$password = '';
```

Jika username, password, atau port MySQL berbeda, sesuaikan nilainya.

### E. Menjalankan Website

Buka browser dan akses:

```text
http://localhost/ranaya-outdoor/
```

Untuk membuka halaman login:

```text
http://localhost/ranaya-outdoor/login.php
```

Untuk membuka halaman registrasi:

```text
http://localhost/ranaya-outdoor/register.php
```

## 7. Hak Akses Pengguna

Sistem menggunakan tiga jenis peran pengguna:

| Peran | Hak Akses |
|---|---|
| Penyewa | Mengakses fitur penyewaan perlengkapan outdoor |
| Admin | Mengelola operasional penyewaan |
| Superadmin | Memiliki peran pengelolaan dengan hak akses lebih tinggi |

Pembagian hak akses dilakukan berdasarkan nilai `peran` pada tabel `pengguna`.

## 8. Gambaran Database

Database yang digunakan bernama `ranaya_outdoor`.

Database terdiri dari 12 tabel utama:

1. `pengguna` – Menyimpan data pengguna.
2. `kategori` – Menyimpan kategori perlengkapan.
3. `barang` – Menyimpan informasi barang.
4. `unit_barang` – Menyimpan data setiap unit barang.
5. `pesanan` – Menyimpan transaksi penyewaan.
6. `detail_pesanan` – Menyimpan rincian barang dalam pesanan.
7. `alokasi_unit` – Mengelola alokasi unit barang.
8. `pembayaran` – Menyimpan informasi pembayaran.
9. `pembatalan` – Menyimpan pengajuan pembatalan pesanan.
10. `refund` – Menyimpan informasi pengembalian dana.
11. `pengambilan` – Mencatat proses pengambilan barang.
12. `pengembalian` – Mencatat proses pengembalian barang.

## 9. Ketentuan Sistem

Beberapa ketentuan bisnis yang diterapkan dalam perancangan sistem:

- Metode pembayaran menggunakan QRIS dan transfer bank.
- Pembayaran diverifikasi secara manual oleh admin.
- Bukti pembayaran diunggah oleh penyewa.
- Batas waktu pembayaran adalah 15 menit.
- Satu pesanan dapat berisi beberapa jenis barang.
- Durasi penyewaan dihitung berdasarkan selisih tanggal mulai dan tanggal selesai.
- Pemeriksaan identitas dilakukan oleh admin ketika pengambilan barang.
- Denda keterlambatan dirancang sebesar Rp10.000 per unit per jam, dengan pembulatan ke atas untuk keterlambatan sebagian jam.


## 10. Pengembang

**Proyek:** Ranaya Outdoor  
**Jenis Aplikasi:** Sistem Informasi Penyewaan Perlengkapan Outdoor  
**Platform:** Website  
**Backend:** PHP Native  
**Database:** MySQL

---

*Ranaya Outdoor dikembangkan sebagai sistem informasi untuk mendukung pengelolaan