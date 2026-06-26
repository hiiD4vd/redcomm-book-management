# RedComm Book & Author Management System

A simple, robust, and beautifully designed full-stack application for managing books and authors, built specifically for the RedComm Full Stack Developer (Intern) technical assessment.

## 🚀 Tech Stack

- **Backend:** Laravel 11, SQLite (easily swappable to MySQL/PostgreSQL), PHPUnit
- **Frontend:** Nuxt 4 (Vue 3), Tailwind CSS, Vitest
- **Design System:** Neobrutalism

## 📦 Features

- **Full CRUD Operations:** View, create, update, and delete for both Authors and Books.
- **Server-Side Pagination:** Smooth data lists that scale well with large datasets.
- **Optimized Queries:** Eager Loading implemented to prevent N+1 query problems.
- **Caching:** Frequently accessed paginated data is cached for 60 minutes for blazing-fast load times.
- **Automated Testing:** 100% passing API Feature Tests (PHPUnit) and Frontend Component Tests (Vitest).
- **Stunning UI:** Custom-built Neobrutalism design system with interactive micro-animations and skeletons.

## ⚙️ Local Setup Instructions

Follow these steps to get the application running on your local machine.

### Prerequisites
- Node.js (v18+)
- PHP (v8.2+)
- Composer

### 1. Backend Setup
1. Navigate to the backend directory:
   ```bash
   cd backend
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seed the database with Indonesian mock data:
   ```bash
   php artisan migrate:fresh --seed
   ```
6. Start the local server:
   ```bash
   php artisan serve
   ```
   *The API will be available at `http://127.0.0.1:8000/api`*

### 2. Frontend Setup
1. Open a new terminal and navigate to the frontend directory:
   ```bash
   cd frontend
   ```
2. Install Node dependencies:
   ```bash
   npm install
   ```
3. Start the Nuxt development server:
   ```bash
   npm run dev
   ```
4. Open your browser and visit: `http://localhost:3000`

## 🧪 Running Tests
- **Backend (PHPUnit):** `cd backend && php artisan test`
- **Frontend (Vitest):** `cd frontend && npm run test`
