# RedComm Book & Author Management System

Aplikasi full-stack yang simpel, kokoh, dan didesain secara unik untuk mengelola buku dan penulis. Proyek ini dibangun khusus untuk memenuhi persyaratan tes teknikal **Full Stack Developer (Intern)** di RedComm.

## 🚀 Tech Stack

- **Backend:** Laravel 11, SQLite (bisa diganti ke MySQL/PostgreSQL dengan sangat mudah), PHPUnit
- **Frontend:** Nuxt 4 (Vue 3), Tailwind CSS, Vitest
- **Design System:** Custom Neobrutalism UI

## 📦 Fitur Utama

- **Full CRUD Operations:** Fitur melihat, menambah, mengubah, dan menghapus untuk Author dan Book.
- **Server-Side Pagination:** Daftar data diload menggunakan paginasi agar tetap ringan meski datanya ribuan.
- **Optimized Queries (Bonus):** Menggunakan teknik *Eager Loading* di Laravel untuk mencegah masalah *N+1 query*.
- **Caching (Bonus):** Data yang sering diakses disimpan di *Cache* selama 60 menit untuk performa ekstra cepat, dan *cache* otomatis dihapus saat ada perubahan data.
- **Automated Testing:** Lulus 100% tes otomatis (PHPUnit untuk API dan Vitest untuk UI).
- **Stunning UI (Bonus):** Antarmuka pengguna bergaya *Neobrutalism* yang interaktif, rapi, dan dilengkapi *loading skeleton*.

## ⚙️ Cara Menjalankan di Lokal (Local Setup)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer Anda.

### Prasyarat
- Node.js (v18+)
- PHP (v8.2+)
- Composer

### 1. Setup Backend
1. Masuk ke folder backend:
   ```bash
   cd backend
   ```
2. Install dependencies PHP:
   ```bash
   composer install
   ```
3. Copy file environment:
   ```bash
   cp .env.example .env
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Jalankan migrasi dan isi database dengan data dummy (berbahasa Indonesia):
   ```bash
   php artisan migrate:fresh --seed
   ```
6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
   *API akan berjalan di `http://127.0.0.1:8000/api`*

### 2. Setup Frontend
1. Buka terminal baru dan masuk ke folder frontend:
   ```bash
   cd frontend
   ```
2. Install dependencies Node:
   ```bash
   npm install
   ```
3. Jalankan server development Nuxt:
   ```bash
   npm run dev
   ```
4. Buka browser dan kunjungi: `http://localhost:3000`

## 🧪 Menjalankan Unit Testing
Untuk memastikan seluruh sistem berjalan tanpa bug:
- **Backend (PHPUnit):** `cd backend && php artisan test`
- **Frontend (Vitest):** `cd frontend && npm run test`
