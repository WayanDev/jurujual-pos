<picture>
    <source srcset="public/images/logo-putih.png"  
            media="(prefers-color-scheme: dark)">
    <img src="public/images/logo-putih.png"  alt="App Logo" width="100" height="100">
</picture>

> **Catatan Penting:** Proyek ini siap untuk Produksi. Namun gunakan kode dari branch utama saja. Jika Anda menemukan bug atau memiliki saran, silakan buat sebuah Issue.

# Instalasi Lokal

- jalankan `` git clone https://github.com/FahimAnzamDip/triangle-pos.git ``
- jalankan ``composer install `` 
- jalankan `` npm install ``
- jalankan ``npm run dev``
- salin .env.example ke .env
- jalankan `` php artisan key:generate ``
- atur database Anda di dalam .env
- jalankan `` php artisan migrate --seed ``
- jalankan `` php artisan storage:link ``
- jalankan `` php artisan serve ``
- kemudian kunjungi `` http://localhost:8000 atau http://127.0.0.1:8000 ``.

> **Catatan Penting:** "Jurujual POS" menggunakan Laravel Snappy Package untuk PDFs. Jika Anda menggunakan Linux maka tidak diperlukan konfigurasi. Tetapi di sistem operasi lain, silakan merujuk ke [Dokumentasi Laravel Snappy](https://github.com/barryvdh/laravel-snappy).

# Kredensial Admin
> Email: super.admin@test.com || Password: 12345678

## Demo
![image](https://github.com/WayanDev/jurujual-pos/assets/113874200/41abbda5-9d8a-449a-9548-c4e31c1f021a)
![Screenshot 2024-06-06 134507](https://github.com/WayanDev/jurujual-pos/assets/113874200/425d676b-e0ca-4c54-a527-182244e87bd0)

**Demo Langsung:** akan segera diperbarui

## Fitur JuruJual POS

- **Manajemen Produk & Pencetakan Barcode**
- **Prediksi**
- **Manajemen Stok**
- **Membuat Penawaran & Kirim Melalui Email**
- **Manajemen Pembelian**
- **Manajemen Penjualan**
- **Manajemen Retur Pembelian & Penjualan**
- **Manajemen Pengeluaran**
- **Manajemen Pelanggan & Pemasok**
- **Manajemen Pengguna (Peran & Izin)**
- **Gambar Produk Ganda**
- **Pengaturan Mata Uang Ganda**
- **Pengaturan Unit**
- **Pengaturan Sistem**
- **Laporan**

# Lisensi
**[Creative Commons Attribution 4.0	cc-by-4.0](https://creativecommons.org/licenses/by/4.0/)**
