# Sistem Sinkronisasi Dashboard Otomatis

## Deskripsi
Sistem ini secara otomatis menyinkronkan data dashboard setiap satu jam untuk meningkatkan performa dan memastikan data selalu terbaru.

## Fitur
- ✅ Sinkronisasi otomatis setiap satu jam
- ✅ **Tombol sinkronisasi manual di dashboard** (NEW!)
- ✅ **Dark Mode Support** (NEW!)
- ✅ Cache data untuk performa yang lebih baik
- ✅ Fallback ke data fresh jika cache tidak tersedia
- ✅ Command manual untuk sinkronisasi langsung
- ✅ Support Windows Service
- ✅ Notifikasi real-time saat sinkronisasi
- ✅ Loading state dan feedback visual

## Cara Penggunaan

### 1. Sinkronisasi Manual via Tombol Dashboard
- Klik tombol **"Sinkronisasi"** di samping tombol "Tambah Penjualan" pada bagian "Penjualan Terbaru"
- Tombol akan menampilkan loading state saat proses
- Notifikasi sukses/error akan muncul
- Halaman akan otomatis reload untuk menampilkan data terbaru

### 2. Sinkronisasi Manual via Command Line
```bash
php artisan dashboard:sync
```

### 3. Menjalankan Scheduler (Development)
```bash
php artisan schedule:work
```

### 4. Menjalankan Scheduler (Windows)
```bash
# Double-click file start-scheduler.bat
# atau jalankan di command prompt:
start-scheduler.bat
```

### 5. Install sebagai Windows Service
```bash
# Jalankan file install-scheduler.bat untuk instruksi lengkap
install-scheduler.bat
```

## Data yang Disinkronkan
- 📊 Total Penjualan
- 📦 Total Produk
- 👥 Total Pelanggan
- 💰 Total Pendapatan
- 📈 Penjualan Terbaru (10 transaksi)
- ⚠️ Produk Stok Rendah
- 🏆 Produk Terlaris

## Cache Duration
- Data di-cache selama **1 jam (3600 detik)**
- Cache otomatis di-refresh setiap jam
- Jika cache tidak tersedia, sistem akan mengambil data fresh

## File yang Dibuat
- `app/Console/Commands/SyncDashboardData.php` - Command sinkronisasi
- `app/Console/Kernel.php` - Task scheduler (updated)
- `app/Http/Controllers/DashboardController.php` - Controller dengan cache support
- `start-scheduler.bat` - Script untuk menjalankan scheduler
- `install-scheduler.bat` - Script untuk install Windows service

## Monitoring
Untuk memantau status sinkronisasi, jalankan:
```bash
php artisan tinker --execute="var_dump(Cache::get('dashboard_stats'));"
```

## Troubleshooting
1. **Cache tidak ter-update**: Jalankan `php artisan cache:clear`
2. **Scheduler tidak berjalan**: Pastikan `php artisan schedule:work` berjalan
3. **Data tidak muncul**: Jalankan sinkronisasi manual `php artisan dashboard:sync`

## Catatan
- Scheduler harus berjalan terus-menerus untuk sinkronisasi otomatis
- Data chart (7 hari terakhir) selalu fresh, tidak di-cache
- Sistem fallback memastikan dashboard tetap berfungsi meski cache bermasalah
