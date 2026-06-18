# PHP MVC CRUD Mahasiswa
Website Create, Read, Update, Delete (CRUD) Mahasiswa dengan PHP MVC menggunakan template AdminLTE

## Informasi singkat
- Website ini dibuat dengan PHP menggunakan arsitektur MVC.<br>
- Dalam website ini bisa CRUD Mahasiswa, CRUD Jurusan, CRUD Mata kuliah, dan CRUD User (login, logout, register, edit profil, delete akun).<br>
- Saat menambah (Create) mahasiswa, hanya perlu memilih 1 jurusan. Setiap jurusan sudah berisi mata kuliah.<br>
- Saya menggunakan 1 tabel tambahan untuk menghubungkan 2 tabel didalam database.<br>

## Analisis Kebutuhan Sistem
**1. Deskripsi Singkat Sistem**
Sistem Informasi Akademik Kampus (KrisnaLTE) adalah aplikasi berbasis web yang dirancang untuk mengelola data master akademik secara efisien. Sistem ini mencakup pengelolaan data mahasiswa, jurusan, mata kuliah, serta pencatatan transaksi administrasi dan keuangan mahasiswa.

**2. Masalah yang Ingin Diselesaikan**
- Sulitnya melacak dan mengorganisasi data mahasiswa beserta detail jurusannya secara terpusat.
- Pemetaan relasi antara jurusan dan mata kuliah yang sulit dikelola secara manual.
- Rentannya kesalahan dalam pembuatan NIM mahasiswa dan kesulitan dalam mencatat riwayat transaksi pembayaran/administrasi mahasiswa.

**3. Pengguna Sistem**
- **Admin**: Memiliki hak akses penuh untuk mengelola semua entitas data (Mahasiswa, Jurusan, Mata Kuliah, Transaksi, dan User).
- **Petugas Pendaftaran**: Memiliki hak akses khusus untuk menambahkan dan memonitor data mahasiswa di sistem.

**4. Kebutuhan Fungsional Sistem**
- Sistem dapat melakukan *Create, Read, Update, Delete* (CRUD) pada entitas Mahasiswa, Jurusan, Mata Kuliah, Transaksi, dan User.
- Sistem mampu menghasilkan Nomor Induk Mahasiswa (NIM) secara berurutan dan otomatis sesuai kode tahun dan jurusan.
- Sistem mampu menangani relasi *many-to-many* antara Jurusan dan Mata Kuliah.
- Sistem memungkinkan pencatatan transaksi masuk dengan berbagai kategori spesifik (Biaya UKT, PKKMB, Wisuda, dll).
- Sistem menyediakan fitur pencarian data (*searching*) dan ekspor dokumen/laporan (Print/PDF) melalui *DataTables*.

**5. Kebutuhan Non-Fungsional Sistem**
- **Keamanan**: Kata sandi di-*hash* dengan `bcrypt` dan sesi masuk menggunakan arsitektur *JSON Web Token (JWT)*.
- **Usability (Kegunaan)**: Memiliki antarmuka grafis yang ramah pengguna, responsif di berbagai perangkat menggunakan *AdminLTE* dan *Bootstrap 4*.
- **Performa**: Waktu pemrosesan data (seperti *filtering* tabel) sangat cepat dan responsif dibantu oleh *client-side processing* dari jQuery DataTables.


## Teknologi yang digunakan
- AdminLTE
- Bootstrap 4
- JQuery
- SweetAlert2
- Select2
- JSON Web Token

## Instalasi atau Cara menggunakan
- Proses download
1. Pastikan Anda sudah menginstall [XAMPP](https://www.apachefriends.org/download.html) dan [Composer](https://getcomposer.org/) di komputer Anda
2. Download semua file di repository ini
3. Ekstrak file jika hasil download berupa file `.zip`
4. Download [AdminLTE](https://adminlte.io/) dan isinya dipindahkan ke direktori `php-mvc-crud-mahasiswa-main/public/AdminLTE/`
5. Di direktori `php-mvc-crud-mahasiswa-main` ketik `composer install` pada terminal untuk mengunduh keperluan website
- Proses pengaturan
6. Start *Apache* dan *MySQL* di XAMPP Control Panel
7. Buka `localhost/phpmyadmin` di browser
8. Buat database baru dengan nama `db_siskampus`
9. Klik tulisan *Import* di bagian atas
10. Di bagian *File to import:* pilih file `db_siskampus.sql` yang ada di folder `php-mvc-crud-mahasiswa-main/`
11. Kalau sudah, klik tombol *Import* di bagian paling bawah
- Proses menjalankan website
12. Buka folder `php-mvc-crud-mahasiswa-main/` di *Command Prompt*
13. Ketik `composer update` untuk men-download hal yang dibutuhkan website
14. Pindah ke folder public dengan mengetik `cd public` di *Command Prompt*
15. Jalankan server PHP dengan mengetik `php -S localhost:8080`
16. Akses website dari Web Browser ke alamat localhost:8080

## Informasi tambahan
- Saat membuka website pertama kali, akan diarahkan ke halaman login (akan otomatis ke alamat localhost:8080/login)
- Di halaman registrasi dapat membuat akun untuk login
- Setelah login diarahkan ke halaman dashboard yang berisi daftar mahasiswa
- Selebihnya bisa eksplorasi untuk mengetahui lebih lanjut
- Buatlah user dengan role admin di database, supaya dapat mengakses seluruh fitur
