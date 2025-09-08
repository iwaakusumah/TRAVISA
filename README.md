# 🎓 Sistem Informasi Pendukung Keputusan Seleksi Penerima Beasiswa

Sistem ini merupakan aplikasi berbasis web yang digunakan untuk membantu proses seleksi penerima beasiswa secara objektif menggunakan pendekatan **Hybrid PROMETHEE dan Genetic Algorithm (GA)**.

Dibangun menggunakan **PHP Laravel 12**, sistem ini dilengkapi dengan antarmuka berbasis **Blade Template + Bootstrap 4**, serta dilengkapi autentikasi menggunakan **Laravel Breeze**.

---

## 🧰 Tech Stack

|----------------------------------------------------|
|    Komponen    |             Teknologi             |
|----------------|-----------------------------------|
| Backend        | Laravel 12 (PHP 8.2+)             |
| Frontend       | Blade, Bootstrap 4                |
| Autentikasi    | Laravel Breeze                    |
| Database       | MySQL                             |
| Algorithm      | Genetic Algorithm (GA)            |
| Method         | PROMETHEE                         |
|_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ |

---

## 🧠 Metodologi

### 🔷 PROMETHEE
Merupakan metode pendukung keputusan multi-kriteria yang membandingkan setiap alternatif secara pairwise berdasarkan nilai preferensi, menghasilkan nilai *leaving flow*, *entering flow*, dan *net flow*.

### 🔶 Genetic Algorithm
Digunakan untuk mengoptimalkan bobot dari setiap kriteria secara otomatis berdasarkan *fitness function* yang dirancang sesuai kebutuhan sistem, agar hasil pemeringkatan PROMETHEE menjadi lebih optimal dan adaptif.

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

### 2. Install Dependency
```bash
composer install
npm install

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate

### 4. Jalankan Migrasi
```bash
php artisan migrate

### 5. Setup Autentikasi Laravel Breeze
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate

### 6. Run the Application
```bash
php artisan serve