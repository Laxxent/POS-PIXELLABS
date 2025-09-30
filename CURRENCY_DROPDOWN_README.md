# Fitur Currency Dropdown

## Deskripsi
Fitur Currency Dropdown memungkinkan pengguna untuk memilih mata uang dari berbagai negara melalui dropdown yang user-friendly di halaman Store Settings.

## Fitur
- ✅ Dropdown dengan 40+ mata uang dari berbagai negara
- ✅ Format yang jelas: "CODE - Currency Name"
- ✅ Default selection berdasarkan setting yang tersimpan
- ✅ Dark mode support
- ✅ Validation dan error handling
- ✅ Responsive design

## Mata Uang yang Tersedia

### 🌏 **Asia Pacific**
- **IDR** - Indonesian Rupiah (Default)
- **USD** - US Dollar
- **JPY** - Japanese Yen
- **SGD** - Singapore Dollar
- **MYR** - Malaysian Ringgit
- **THB** - Thai Baht
- **PHP** - Philippine Peso
- **VND** - Vietnamese Dong
- **CNY** - Chinese Yuan
- **HKD** - Hong Kong Dollar
- **KRW** - South Korean Won
- **AUD** - Australian Dollar
- **NZD** - New Zealand Dollar

### 🌍 **Europe**
- **EUR** - Euro
- **GBP** - British Pound
- **CHF** - Swiss Franc
- **SEK** - Swedish Krona
- **NOK** - Norwegian Krone
- **DKK** - Danish Krone
- **PLN** - Polish Zloty
- **CZK** - Czech Koruna
- **HUF** - Hungarian Forint
- **RUB** - Russian Ruble
- **TRY** - Turkish Lira

### 🌎 **Americas**
- **CAD** - Canadian Dollar
- **BRL** - Brazilian Real
- **MXN** - Mexican Peso

### 🌍 **Middle East & Africa**
- **ZAR** - South African Rand
- **AED** - UAE Dirham
- **SAR** - Saudi Riyal
- **QAR** - Qatari Riyal
- **KWD** - Kuwaiti Dinar
- **BHD** - Bahraini Dinar
- **OMR** - Omani Rial
- **JOD** - Jordanian Dinar
- **LBP** - Lebanese Pound
- **EGP** - Egyptian Pound
- **ILS** - Israeli Shekel

### 🌏 **South Asia**
- **INR** - Indian Rupee

## Implementasi Teknis

### 1. **View Update**
```blade
<select id="currency" class="form-control @error('currency') is-invalid @enderror" name="currency" required>
    <option value="">-- Pilih Currency --</option>
    <option value="IDR" {{ ($settings->currency ?? old('currency')) == 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
    <!-- ... more options ... -->
</select>
```

### 2. **Dark Mode Styling**
```css
[data-theme="dark"] select.form-control,
[data-theme="dark"] .form-select {
    background-color: #374151 !important;
    border-color: #495057 !important;
    color: #ffffff !important;
}

[data-theme="dark"] select option {
    background-color: #374151 !important;
    color: #ffffff !important;
}
```

### 3. **Controller Validation**
```php
$request->validate([
    'currency' => 'required|string|max:3',
    // ... other validations
]);
```

## Cara Penggunaan

### 1. **Akses Store Settings**
- Login ke aplikasi
- Klik menu "Store Settings" di sidebar
- Scroll ke bagian "Currency"

### 2. **Pilih Currency**
- Klik dropdown "Currency"
- Pilih mata uang yang diinginkan
- Klik "Save Settings"

### 3. **Default Currency**
- Default: IDR (Indonesian Rupiah)
- Dapat diubah sesuai kebutuhan bisnis

## Keunggulan

### 🎯 **User Experience**
- **Easy Selection**: Dropdown yang mudah digunakan
- **Clear Format**: Format "CODE - Name" yang jelas
- **Default Value**: IDR sebagai default untuk Indonesia
- **Validation**: Error handling yang baik

### 🎨 **Visual Design**
- **Dark Mode Support**: Styling yang konsisten
- **Responsive**: Bekerja di semua ukuran layar
- **Bootstrap Integration**: Menggunakan Bootstrap classes
- **Consistent Styling**: Mengikuti tema aplikasi

### 🔧 **Technical Benefits**
- **Form Validation**: Server-side validation
- **Error Handling**: User-friendly error messages
- **Data Persistence**: Setting tersimpan di database
- **Cross-browser**: Kompatibel dengan semua browser

## Database Schema

### Store Settings Table
```sql
CREATE TABLE store_settings (
    id BIGINT PRIMARY KEY,
    currency VARCHAR(3) NOT NULL DEFAULT 'IDR',
    -- other fields...
);
```

## File yang Dimodifikasi

1. **`resources/views/store-settings/index.blade.php`**
   - Mengubah input text menjadi select dropdown
   - Menambahkan 40+ currency options

2. **`resources/views/layouts/app.blade.php`**
   - Menambahkan CSS untuk select dropdown dark mode
   - Styling untuk options dan hover states

## Browser Support
- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 12+
- ✅ Edge 79+

## Future Enhancements
- [ ] Currency symbol display
- [ ] Exchange rate integration
- [ ] Multi-currency support
- [ ] Currency formatting options
- [ ] Regional currency grouping

