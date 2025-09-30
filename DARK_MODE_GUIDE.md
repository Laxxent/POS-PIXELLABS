# Dark Mode Guide - POS Application

## Overview
Aplikasi POS ini mendukung dark mode, tetapi tombol toggle telah dihilangkan sesuai permintaan. Dark mode dapat diaktifkan melalui beberapa cara.

## Cara Mengaktifkan Dark Mode

### 1. Melalui Browser Console
Buka Developer Tools (F12) dan jalankan perintah berikut:

```javascript
// Aktifkan dark mode
setDarkMode(true);

// Nonaktifkan dark mode
setDarkMode(false);

// Toggle dark mode
toggleDarkMode();

// Cek theme saat ini
getCurrentTheme();
```

### 2. Melalui Browser Developer Tools
1. Buka Developer Tools (F12)
2. Pilih tab "Console"
3. Ketik: `setDarkMode(true)` untuk dark mode
4. Ketik: `setDarkMode(false)` untuk light mode

### 3. Melalui Local Storage
1. Buka Developer Tools (F12)
2. Pilih tab "Application" > "Local Storage"
3. Set key `theme` dengan value:
   - `"dark"` untuk dark mode
   - `"light"` untuk light mode
4. Refresh halaman

## Fitur Dark Mode

### Yang Didukung:
- ✅ Background gelap untuk semua halaman
- ✅ Text warna terang untuk readability
- ✅ Card dengan background gelap
- ✅ Table dengan styling gelap
- ✅ Form controls dengan background gelap
- ✅ Dropdown menu dengan styling gelap
- ✅ Alert messages dengan warna yang sesuai
- ✅ Navbar dengan background gelap
- ✅ Sidebar tetap dengan gradient (tidak berubah)

### Yang Tidak Berubah:
- ❌ Sidebar gradient (tetap biru-ungu)
- ❌ Tombol toggle dark mode (tidak ada)

## Styling Details

### Light Mode (Default):
- Background: #f8f9fa
- Text: #2c3e50
- Cards: White dengan shadow
- Tables: Light background

### Dark Mode:
- Background: #1a1a1a
- Text: #e9ecef
- Cards: #2d3748
- Tables: Dark background dengan border gelap

## Persistence
Theme yang dipilih akan tersimpan di localStorage browser dan akan tetap aktif sampai diubah manual.

## Browser Support
Dark mode mendukung semua browser modern yang mendukung CSS custom properties dan localStorage.






