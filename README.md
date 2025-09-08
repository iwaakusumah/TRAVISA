# 🎓 Decision Support Information System for Scholarship Recipient Selection

<p style="text-align: justify;">
This system is a web-based application designed to assist the scholarship recipient selection process objectively using a <strong>Hybrid PROMETHEE and Genetic Algorithm (GA)</strong> approach.
</p>

<p style="text-align: justify;">
Built with <strong>PHP Laravel 12</strong>, the system features an interface based on <strong>Blade Template + Bootstrap 4</strong> and includes authentication using <strong>Laravel Breeze</strong>.
</p>

---

## 🧰 Tech Stack

|     Component    |            Technology            |
|------------------|----------------------------------|
| Backend          | Laravel 12 (PHP 8.2+)            |
| Frontend         | Blade, Bootstrap 4               |
| Authentication   | Laravel Breeze                   |
| Database         | MySQL                            |
| Algorithm        | Genetic Algorithm (GA)           |
| Decision Method  | PROMETHEE                        |

---

## 🧠 Methodology

### 🔷 PROMETHEE
<p style="text-align: justify;">
A Multi-Criteria Decision Making (MCDM) method that compares alternatives pairwise based on preference values, producing <em>leaving flow</em>, <em>entering flow</em>, and <em>net flow</em> scores for final ranking.
</p>

### 🔶 Genetic Algorithm
<p style="text-align: justify;">
Used to automatically optimize the weight of each criterion based on a <em>fitness function</em> tailored to the system's objectives, enabling the PROMETHEE ranking to be more adaptive and accurate.
</p>

---

## ✨ Key Features

- ✅ User authentication (Login & Register via Laravel Breeze)
- ✅ Scholarship recipient data management
- ✅ Criteria management
- ✅ PROMETHEE calculation (Leaving, Entering, Net Flow)
- ✅ Automatic weight optimization using Genetic Algorithm
- ✅ Final ranking of scholarship candidates
- ✅ Selection history and logs
- ✅ Export selection results as PDF

---

## 🛠️ Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/iwaakusumah/TRAVISA.git
cd TRAVISA
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Edit the .env file to match your database configuration:
```bash
DB_DATABASE=beasiswa_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Database Migrations
```bash
php artisan migrate
```

### 5. Setup Laravel Breeze Authentication
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

## 📄 License
<p style="text-align: justify;">
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
</p>