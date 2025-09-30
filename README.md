# POS Application (Point of Sale)

Aplikasi Point of Sale (POS) yang dibangun menggunakan Laravel 10, Bootstrap 5, dan MySQL. Aplikasi ini menyediakan fitur lengkap untuk manajemen toko, penjualan, pembelian, dan laporan.

## Fitur Utama

### 🏪 Manajemen Toko
- Dashboard dengan statistik lengkap
- Pengaturan informasi toko
- Manajemen pengguna dengan role-based access (Admin, Manager, Cashier)

### 📦 Manajemen Produk
- CRUD produk dengan kategori dan satuan
- Manajemen stok dengan peringatan stok rendah
- Support barcode dan nomor seri
- Upload gambar produk

### 👥 Manajemen Data
- Manajemen kategori produk
- Manajemen satuan produk
- Manajemen supplier
- Manajemen pelanggan (retail & wholesale)

### 💰 Transaksi
- Transaksi penjualan dengan multiple payment method
- Transaksi pembelian dari supplier
- Support diskon dan pajak
- Pencetakan struk

### 📊 Laporan
- Laporan penjualan harian/bulanan
- Laporan produk terlaris
- Laporan stok rendah
- Grafik penjualan

## Teknologi yang Digunakan

- **Backend**: Laravel 10
- **Frontend**: Bootstrap 5, Font Awesome
- **Database**: MySQL
- **Charts**: Chart.js
- **Authentication**: Laravel Sanctum

## Instalasi

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx)

### Langkah-langkah Instalasi

1. **Clone atau download project**
   ```bash
   git clone [repository-url]
   cd pos-application
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database di file .env**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pos_application
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Jalankan migration dan seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symbolic link untuk storage**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

8. **Akses aplikasi**
   - URL: http://localhost:8000
   - Akan redirect ke halaman login

## Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin
- Email: admin@pos.com
- Password: password

### Manager
- Email: manager@pos.com
- Password: password

### Cashier
- Email: cashier@pos.com
- Password: password

## Struktur Database

Aplikasi menggunakan database MySQL dengan tabel-tabel berikut:

- `users` - Data pengguna sistem
- `categories` - Kategori produk
- `units` - Satuan produk
- `suppliers` - Data supplier
- `customers` - Data pelanggan
- `products` - Data produk
- `sales` - Data penjualan
- `sale_items` - Detail item penjualan
- `purchases` - Data pembelian
- `purchase_items` - Detail item pembelian
- `stock_movements` - Riwayat pergerakan stok
- `store_settings` - Pengaturan toko

## Role dan Permission

### Admin
- Akses penuh ke semua fitur
- Manajemen pengguna
- Pengaturan sistem

### Manager
- Akses ke laporan dan analisis
- Manajemen produk dan supplier
- Tidak bisa mengelola pengguna

### Cashier
- Transaksi penjualan
- Melihat produk dan pelanggan
- Tidak bisa akses laporan detail

## API Endpoints

Aplikasi juga menyediakan beberapa API endpoints untuk integrasi:

- `GET /api/products` - Daftar produk
- `GET /api/products/{barcode}` - Cari produk by barcode
- `POST /api/sales` - Buat transaksi penjualan

## Konfigurasi Tambahan

### Upload File
Pastikan folder `storage/app/public` dapat diakses dan memiliki permission yang tepat.

### Session
Konfigurasi session dapat diubah di file `config/session.php`.

### Cache
Untuk performa yang lebih baik, gunakan cache driver seperti Redis atau Memcached.

## Troubleshooting

### Error "Class not found"
Jalankan:
```bash
composer dump-autoload
```

### Error database connection
Pastikan:
- MySQL service berjalan
- Konfigurasi database di .env sudah benar
- Database sudah dibuat

### Error permission
Pastikan folder storage dan bootstrap/cache memiliki permission write:
```bash
chmod -R 775 storage bootstrap/cache
```

## Kontribusi

1. Fork repository
2. Buat feature branch
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

Aplikasi ini menggunakan lisensi MIT. Lihat file LICENSE untuk detail.

## Support

Jika mengalami masalah atau memiliki pertanyaan, silakan buat issue di repository atau hubungi developer.

---

**Happy Coding! 🚀**






