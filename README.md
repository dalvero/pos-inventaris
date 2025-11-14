# 🍹 POS & Inventory Management System (Laravel 12)

Sistem ini merupakan aplikasi **Point of Sales (POS)** dan **Manajemen Inventaris Bahan Baku** berbasis web yang dikembangkan menggunakan **Laravel 12**.  
Aplikasi ini ditujukan untuk membantu pemilik usaha minuman maupun makanan dalam mencatat penjualan, mengelola stok bahan baku, dan mengawasi aktivitas kasir secara real-time.

---

## ⚙️ Teknologi Utama
- **Framework:** Laravel 12  
- **Database:** MySQL  
- **Frontend:** Blade Template & Bootstrap  
- **Authentication:** Laravel Breeze  
- **Migration & Seeder:** Digunakan untuk struktur database otomatis  

---

## 🧩 Fitur Utama

## 👩‍💼 Role Management
Terdapat beberapa role dalam sistem
- **Super Admin (Pemilik Web)**
    - Mengelola seluruh data pengguna dan toko.
    - Melihat daftar semua toko yang terdaftar.
    - Menghapus atau menonaktifkan toko.
    - Mengawasi aktivitas secara global.

- **Admin / Owner**
    - Mendaftarkan toko terlebih dahlu sebelum digunakan.
    - Mengelola produk, bahan baku, dan resep pada tokonya.
    - Mengundang atau membuat akun kasir.
    - Melihat laporan transaksi, shift, dan stok khusus untuk tokonya.    

- **Kasir / User**
    - Melakukan transaksi penjualan.
    - Sistem otomatis mengurangi stok bahan baku berdasarkan resep produk.
    - Melihat total penjualan per shift (Opening - Closing).
    - Melakukan pencatatan waktu **Opening**, **Break**, dan **Closing** sebagai tanda shift kasir.

---

## 🔁 Alur Sistem (System Flow)
- **👷‍♂️ Super Admin**
    - Mengelola seluruh toko dan admin toko.
    - Tidak melakukan transaksi - fokus pada monitoring.

- **👨‍⚖️ Admin Toko**
    - Register sebagai admin toko
    - Login kemudian **mendaftarkan tokonya.**
    - Menambahkan produk, bahan baku, dan resep.
    - Mendaftarkan kasir atau kasir bisa register sendiri dengan memilih toko.
    - Melihat laporan transaksi dan shift.

- **👩‍💼 Kasir**
    - Register dengan memilih **toko** tempat bekerja.
    - Setelah akun aktif, kasir login dan melakukan :
        - **Opening Shift**
        - **Break**
        - **Closing Shift**
    - Melakukan transaksi penjualan.
    - Stok otomatis berkurang berdasarkan resep produk.


## 🕒 Shift Management
Sebelum kasir memulai transaksi, sistem akan meminta salah satu aksi berikut:

- **Opening:** Menandai awal shift kerja kasir.  
- **Break:** Digunakan saat kasir istirahat, transaksi sementara dinonaktifkan.  
- **Closing:** Menandai akhir shift, sistem akan menghitung total transaksi dan waktu kerja.  

Semua aktivitas ini dicatat dalam tabel `shifts` untuk pelaporan dan kontrol operasional.

---

## 💰 Laporan & Keuangan
- Rekap penjualan otomatis berdasarkan shift dan tanggal.  
- Riwayat transaksi lengkap dapat dilihat oleh admin.  
- Sistem mendukung pencatatan biaya tambahan seperti bahan tambahan, diskon, atau pembatalan transaksi.  

---

## 📦 Manajemen Inventaris
- Setiap produk memiliki daftar bahan baku.  
- Setiap transaksi otomatis mengurangi stok bahan baku sesuai resep.  
- Sistem memberikan peringatan jika stok bahan tidak mencukupi.  

---

## 🧱 Struktur Database Utama
| Tabel | Deskripsi |
|-------|------------|
| `users` | Menyimpan data user dan role (admin, kasir) |
| `toko` | Menyimpan daftar toko yang didaftarkan admin toko |
| `bahan_baku` | Menyimpan data bahan baku |
| `produk` | Menyimpan data produk jual |
| `resep_produk` | Relasi antara produk dan bahan baku |
| `transaksi` | Menyimpan data transaksi penjualan |
| `detail_transaksi` | Menyimpan rincian item yang dijual |
| `shifts` | Menyimpan data opening, break, dan closing kasir |

---

## 🚀 Instalasi
1. Clone repositori ini  
   ```bash
   git clone https://github.com/dalvero/pos-inventaris.git
   cd pos-inventaris
   ```

2. Install dependencies  
   ```bash
   composer install
   npm install && npm run dev
   ```

3. Konfigurasi file `.env`  
   - Sesuaikan database, username, dan password.

4. Jalankan migration dan seeder  
   ```bash
   php artisan migrate --seed
   ```

5. Jalankan server  
   ```bash
   php artisan serve
   ```

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

© 2025 — Developed by Daniel Alvero
***Project ini dibuat untuk UAS***
