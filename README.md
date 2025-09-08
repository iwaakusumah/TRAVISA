# 🎓 Sistem Informasi Pendukung Keputusan Seleksi Penerima Beasiswa

<p style="text-align: justify;">
Sistem ini merupakan aplikasi berbasis web yang digunakan untuk membantu proses seleksi penerima beasiswa secara objektif menggunakan pendekatan **Hybrid PROMETHEE dan Genetic Algorithm (GA)**.
</p>

<p style="text-align: justify;">
Dibangun menggunakan **PHP Laravel 12**, sistem ini dilengkapi dengan antarmuka berbasis **Blade Template + Bootstrap 4**, serta dilengkapi autentikasi menggunakan **Laravel Breeze**.
</p>

---

## 🧰 Tech Stack

|    Komponen    |             Teknologi             |
|----------------|-----------------------------------|
| Backend        | Laravel 12 (PHP 8.2+)             |
| Frontend       | Blade, Bootstrap 4                |
| Autentikasi    | Laravel Breeze                    |
| Database       | MySQL                             |
| Algorithm      | Genetic Algorithm (GA)            |
| Method         | PROMETHEE                         |

---

## 🧠 Metodologi

### 🔷 PROMETHEE
<p style="text-align: justify;">
Merupakan metode pendukung keputusan multi-kriteria yang membandingkan setiap alternatif secara pairwise berdasarkan nilai preferensi, menghasilkan nilai *leaving flow*, *entering flow*, dan *net flow*.
</p>

### 🔶 Genetic Algorithm
<p style="text-align: justify;">
Digunakan untuk mengoptimalkan bobot dari setiap kriteria secara otomatis berdasarkan *fitness function* yang dirancang sesuai kebutuhan sistem, agar hasil pemeringkatan PROMETHEE menjadi lebih optimal dan adaptif.
</p>

---

## ✨ Fitur Utama

- ✅ Autentikasi pengguna (Login & Register via Laravel Breeze)
- ✅ Manajemen data siswa penerima beasiswa
- ✅ Manajemen kriteria
- ✅ Penghitungan PROMETHEE (Leaving, Entering, Net Flow)
- ✅ Generate bobot kriteria dengan Genetic Algorithm
- ✅ Pemeringkatan otomatis penerima beasiswa
- ✅ Riwayat dan pencatatan hasil seleksi
- ✅ Export hasil seleksi dalam bentuk pdf

---

## 🛠️ Instalasi & Setup

### 1. Clone Repository
```bash
git clone https://github.com/username/nama-proyek.git
cd nama-proyek
```

### 2. Install Dependency
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Edit file .env untuk menyesuaikan konfigurasi database:
```bash
DB_DATABASE=beasiswa_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migrasi
```bash
php artisan migrate
```

### 5. Setup Autentikasi Laravel Breeze
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
```

### 6. Run the Application
```bash
php artisan serve
```

## 📄 Lisensi
<p style="text-align: justify;">
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
</p>