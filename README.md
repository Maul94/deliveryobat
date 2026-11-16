# Delivery Obat

Aplikasi web Delivery Obat berbasis PHP (CodeIgniter 3).

## Konfigurasi Database

File `application/config/database.php` sudah menggunakan konfigurasi default agar dapat langsung dijalankan pada lingkungan lokal standar:

- `hostname`: `localhost`
- `username`: `root`
- `password`: `''` (kosong)
- `database`: `deliveryobat_db`
- `port`: `3306`

### Cara Menyesuaikan Konfigurasi Database

Setelah melakukan `git clone` atau `git pull`, Anda memiliki dua opsi untuk mengatur koneksi database:

1. **Edit langsung** `application/config/database.php` sesuai kredensial MySQL/MariaDB Anda (host, username, password, nama database, dan port).
2. **Gunakan file override lokal (disarankan agar kredensial tidak ikut ter-commit ke Git):**
   Buat file `application/config/database.local.php` (sudah terdaftar di `.gitignore`) dengan isi seperti berikut:

   ```php
   <?php
   defined('BASEPATH') OR exit('No direct script access allowed');

   $db['default']['hostname'] = 'localhost';
   $db['default']['username'] = 'user_db_anda';
   $db['default']['password'] = 'password_db_anda';
   $db['default']['database'] = 'deliveryobat_db';
   $db['default']['port']     = '3306';
   ```

   Jika file `application/config/database.local.php` tersedia, nilainya akan otomatis menimpa konfigurasi default di `application/config/database.php`.
