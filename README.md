# Mini Application OOP & Laravel MVC: Sistem Peminjaman Ruang Kampus

- **Nama:** Pranaja Gathan Aqila
- **NIM:** 20251020012
- **Kelas:** TI 1/3
- **Mata kuliah:** Pemrograman Berorientasi Objek (Pertemuan 7 — Routing, Controller & Blade)
- **Dosen Pengampu:** Hilman Lesmana, S.T., M.S.F.

## 1. Masalah dan Domain
Kampus memiliki beberapa jenis ruang yang dapat dipinjam, seperti ruang kelas, laboratorium, dan auditorium. Setiap jenis ruang memiliki informasi dan aturan kapasitas khusus. Program pada Pertemuan 7 ini melanjutkan kode Pertemuan 5 dengan memindahkan seluruh class OOP ke dalam kerangka kerja Laravel 13 menggunakan pola Route, Controller, dan Blade View tanpa mengubah aturan validasi maupun perilaku class yang sudah dibuat sebelumnya. Sesuai instruksi pada Slide 26 Pertemuan 7, aplikasi belum menggunakan database dan menyiapkan data contoh langsung di dalam Controller.

## 2. Kandidat Class dan Komponen MVC

### A. Bagian Model / Class OOP (`app/Models/`)
- **`RuangKelas.php`**: Parent class yang menyimpan informasi dan perilaku umum ruang (`kodeRuang`, `gedung`, `kapasitas`, `status`) dengan properti `private` dan validasi input.
- **`Laboratorium.php`**: Child class yang mewarisi `RuangKelas`, memiliki properti `jumlahKomputer`, serta menyesuaikan `getInfo()`, `bisaMenampung()`, dan `siapPraktikum()`.
- **`Auditorium.php`**: Child class yang mewarisi `RuangKelas`, memiliki properti `punyaPanggung`, serta menyesuaikan `getInfo()`.
- **`BisaDipesan.php`**: Interface yang menetapkan kontrak method `prosesPeminjaman()` yang wajib dimiliki oleh class peminjaman.
- **`PeminjamanRuang.php`**: Class transaksi yang menerapkan composition (memiliki objek `RuangKelas`), menyimpan identitas peminjam dan jadwal, serta mengimplementasikan `BisaDipesan`.

### B. Bagian Pengatur Alur & Rute (`Controller` & `Route`)
- **`app/Http/Controllers/RuangController.php`**: Menerima request dari route, menyiapkan objek ruang dan peminjaman, memfilter data sesuai parameter URL, lalu mengirimkannya ke Blade View.
- **`routes/web.php`**: Memetakan alamat URL dan parameter ke method yang sesuai di `RuangController` serta memberi nama route (*named route*).

### C. Bagian Tampilan (`resources/views/` & `resources/css/`)
- **`resources/views/layouts/app.blade.php`**: Menyediakan kerangka halaman utama (header, navigasi, pemanggilan CSS `@vite`, footer, dan area `@yield('content')`).
- **`resources/views/ruang/index.blade.php`**: Menampilkan halaman daftar seluruh ruang kampus menggunakan `@if` dan `@foreach`.
- **`resources/views/ruang/show.blade.php`**: Menampilkan halaman detail satu ruang berdasarkan parameter `{kode}` beserta uji kapasitas dan riwayat peminjamannya.
- **`resources/views/ruang/peminjaman.blade.php`**: Menampilkan halaman tambahan daftar transaksi peminjaman ruang beserta tombol filter parameter `{status?}`.

## 3. Catatan Alur Route -> Controller -> Blade dan Pemenuhan Tugas Slide 26

1. **Alur Route -> Controller -> Blade**
   - **Penerapan:** `routes/web.php` -> `RuangController` -> `resources/views/ruang/*.blade.php`
   - **Cara Kerja:** Browser meminta URL, Route mencocokkan alamat dan menangkap parameter, Controller menyiapkan objek dari `app/Models/`, lalu Blade menyusun tampilan HTML.
2. **Tambahkan Satu Halaman Baru**
   - **Penerapan:** Halaman `/peminjaman` (`resources/views/ruang/peminjaman.blade.php`)
   - **Cara Kerja:** Selain halaman daftar (`/ruang`) dan detail (`/ruang/{kode}`), ditambahkan halaman khusus untuk melihat daftar pengajuan `PeminjamanRuang`.
3. **Buat Minimal Satu Route dengan Parameter**
   - **Penerapan:** `/ruang/{kode}` (parameter wajib) dan `/peminjaman/{status?}` (parameter opsional)
   - **Cara Kerja:** Parameter `{kode}` dipakai untuk membuka detail satu ruang (misal `A01` atau `LAB01`), sedangkan `{status?}` dipakai untuk menyaring status peminjaman (`disetujui`, `diajukan`, `ditolak`).
4. **Gunakan Controller untuk Menyiapkan Data**
   - **Penerapan:** `RuangController` (method `index`, `show`, dan `peminjaman`)
   - **Cara Kerja:** Objek `RuangKelas`, `Laboratorium`, `Auditorium`, dan `PeminjamanRuang` dibuat di Controller agar route tetap ringkas dan view fokus pada tampilan.
5. **Gunakan Blade `@if` dan `@foreach`**
   - **Penerapan:** Digunakan pada `index.blade.php`, `show.blade.php`, dan `peminjaman.blade.php`
   - **Cara Kerja:** `@foreach` dipakai untuk mengulang baris tabel ruang dan peminjaman, sedangkan `@if` dipakai untuk memeriksa ketersediaan ruang, tipe class (`instanceof`), dan status pengajuan.

## 4. Peta Route yang Terdaftar (`php artisan route:list`)

- **`GET /ruang`**
  - **Named Route:** `ruang.index`
  - **Controller Action:** `RuangController@index`
  - **Tujuan Halaman:** Menampilkan daftar seluruh ruang kampus (`RuangKelas`, `Laboratorium`, `Auditorium`).
- **`GET /ruang/{kode}`**
  - **Named Route:** `ruang.show`
  - **Controller Action:** `RuangController@show`
  - **Tujuan Halaman:** Menampilkan detail satu ruang berdasarkan parameter `{kode}` (contoh: `/ruang/A01` atau `/ruang/LAB01`).
- **`GET /peminjaman/{status?}`**
  - **Named Route:** `ruang.peminjaman`
  - **Controller Action:** `RuangController@peminjaman`
  - **Tujuan Halaman:** Menampilkan daftar transaksi peminjaman ruang dengan parameter filter status opsional.

## 5. Cara Menjalankan dan Pengujian
Jalankan perintah berikut dari terminal pada folder project (`C:\laragon\www\ruang-peminjam-kelas-pbo`):

```bash
php artisan route:list
npm install
npm run build
php artisan serve
```

Setelah server berjalan, buka alamat berikut pada browser untuk menguji setiap skenario:
1. **Halaman Daftar Ruang:** `http://127.0.0.1:8000/ruang`
2. **Halaman Detail Ruang (Parameter `{kode}`):** `http://127.0.0.1:8000/ruang/A01` dan `http://127.0.0.1:8000/ruang/LAB01`
3. **Halaman Tambahan Peminjaman:** `http://127.0.0.1:8000/peminjaman`
4. **Filter Parameter Status Peminjaman:** `http://127.0.0.1:8000/peminjaman/disetujui`

## 6. Refleksi
Dengan memisahkan class OOP ke dalam `app/Models/`, pengatur alur ke `RuangController`, dan tampilan ke Blade View, kode program menjadi jauh lebih terstruktur dibandingkan saat seluruh class dan pengujian masih digabung di dalam satu file PHP pada Pertemuan 5. Saat ini data ruang dan peminjaman masih ditulis sementara di dalam Controller sesuai batasan materi Pertemuan 7 sebelum masuk ke integrasi CRUD pada UTS dan penyimpanan database (Migration & Eloquent) setelah UTS.
