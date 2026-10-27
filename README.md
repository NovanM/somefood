# somefood

## SomeFood – Laravel Restaurant Management Platform — Aplikasi Berbasis Laravel untuk Manajemen Menu & Kategori Makanan

**SomeFood** is a web-based digital restaurant platform that simplifies management of menus, food categories, and orders. Built with Laravel for stability and fast development.

---

### Key Features / Fitur Utama

* **Menu & category management (CRUD) with images, descriptions, and prices** — Manajemen menu & kategori (CRUD) dengan gambar, deskripsi, dan harga
* **Menu search and filter by category or keyword** — Pencarian & filter menu berdasarkan kategori atau kata kunci
* **External integration: payment API (Midtrans/Xendit) and WhatsApp/Email notifications** — Integrasi eksternal: API pembayaran (Midtrans/Xendit) dan notifikasi WhatsApp/Email
* **Admin dashboard with sales statistics and ingredient stock management** — Dashboard admin: statistik penjualan dan manajemen stok bahan makanan
* **Multi-role authentication (Admin, Kitchen Staff, Customer) with Google/JWT login** — Autentikasi multi-role (Admin, Kitchen Staff, Pelanggan) dengan login Google/JWT

---

### Tech Stack

* **Backend:** Laravel 10 · Laravel Sanctum
* **Database:** MySQL · Redis (cache)
* **Frontend:** Blade Templating · Tailwind CSS
* **Deployment:** Laravel Forge · Vercel/Netlify

---

### Quick Start / Cara Menjalankan

```bash
# 1. Install dependencies
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Run migrations & seed sample menus, categories, ingredients, and multi-role accounts
php artisan migrate --seed

# 4. Start development server
php artisan serve
```

### Default Demo Accounts

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@somefood.com` | `password` |
| **Kitchen Staff** | `kitchen@somefood.com` | `password` |
| **Customer** | `customer@somefood.com` | `password` |
