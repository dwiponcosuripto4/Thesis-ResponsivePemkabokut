# Pemkab Okut Laravel Project

Project aplikasi web untuk Pemerintah Kabupaten Ogan Komering Ulu Timur menggunakan Laravel dengan Breeze authentication.

## 📋 Deskripsi Project

Aplikasi ini dikembangkan untuk mendukung kebutuhan digital Pemkab OKU Timur dengan fitur-fitur:

-   Manajemen konten dan berita
-   Sistem autentikasi pengguna
-   Dashboard admin
-   Manajemen kategori dan dokumen
-   Upload dan manajemen file

## 🚀 Tech Stack

-   **Framework**: Laravel 10.x
-   **Authentication**: Laravel Breeze
-   **Frontend**: Blade Templates, Tailwind CSS
-   **Database**: MySQL
-   **Package Manager**: Composer, NPM

## 📦 Dependencies Utama

-   Laravel Framework
-   Laravel Breeze (Authentication)
-   Tailwind CSS
-   Vite (Build tool)

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## 🛠️ Instalasi

### Prerequisites

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   MySQL/MariaDB

### Langkah Instalasi

1. **Clone repository**

    ```bash
    git clone https://github.com/dwiponcosuripto4/pemkabokut-laravel.git
    cd pemkabokut-laravel
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pemkabokut_db
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Jalankan migrasi dan seeder**

    ```bash
    php artisan migrate --seed
    ```

6. **Build assets**

    ```bash
    npm run build
    # atau untuk development
    npm run dev
    ```

7. **Jalankan server**
    ```bash
    php artisan serve
    ```

## 📁 Struktur Project

```
app/
├── Http/Controllers/    # Controllers
├── Models/             # Eloquent Models
├── View/Components/    # Blade Components
├── Providers/          # Service Providers
├── Console/           # Artisan Commands
├── Exceptions/        # Exception Handling
└── Http/
    ├── Middleware/    # HTTP Middleware
    └── Requests/      # Form Requests

resources/
├── views/             # Blade Templates
├── css/              # Stylesheets
└── js/               # JavaScript

database/
├── migrations/        # Database Migrations
├── seeders/          # Database Seeders
└── factories/        # Model Factories

routes/
├── web.php           # Web Routes
├── api.php           # API Routes
└── auth.php          # Auth Routes
```

## 🔧 Fitur Utama

-   **Authentication**: Login/Register dengan Laravel Breeze
-   **Content Management**: CRUD untuk posts, categories, documents
-   **File Management**: Upload dan manajemen file
-   **User Management**: Manajemen pengguna dan role
-   **Dashboard**: Dashboard admin dengan statistik

## 🚀 Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
composer pint
```

### Database Refresh

```bash
php artisan migrate:fresh --seed
```

## 📚 Models & Relationships

### Post Model

-   Belongs to Category
-   Has many Files
-   Belongs to User (author)

### Category Model

-   Has many Posts

### User Model

-   Has many Posts
-   Laravel Breeze authentication

### Document Model

-   File management system

## 🔐 Authentication

Project menggunakan Laravel Breeze untuk authentication dengan fitur:

-   Login/Register
-   Password Reset
-   Email Verification
-   Profile Management

## 📝 API Documentation

Jika project memiliki API, dokumentasi dapat digenerate menggunakan:

```bash
php artisan scribe:generate
```

## 🤝 Contributing

1. Fork project
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

Project ini menggunakan MIT License.

## 👥 Tim Pengembang

-   **Developer**: Dwi Ponco Suripto
-   **Organization**: Pemkab OKU Timur

## 📞 Contact

Untuk pertanyaan atau dukungan, hubungi:

-   Email: [email@pemkabokut.go.id]
-   GitHub: [@dwiponcosuripto4](https://github.com/dwiponcosuripto4)
