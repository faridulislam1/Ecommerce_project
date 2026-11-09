# Multi-Shop E-Commerce Management System with Shared Catalog

A modern, full-stack Multi-Shop E-Commerce platform built with **Laravel 9 (PHP)**, **Vue.js 3 (SPA with Vite)**, and **MySQL**.

This system allows administrators to manage shops and shared catalog products, while shop owners can curate their own storefront inventory from a shared product catalog or create new products with customized pricing, details, and thumbnails. Customers explore strictly shop-scoped product storefronts.

---

## 🌟 Key Features

### 1. 🌙 Admin Portal (Modern Dark Theme)
- **Admin Authentication:** Secure role-based login and session control.
- **Platform Analytics Dashboard:** Real-time metrics for total shops, catalog items, registered merchants, and active customer listings.
- **Shop Management (CRUD):** Create, update, delete, search shops, and link shop owner accounts.
- **Shared Product Catalog (CRUD):** Manage the central master catalog (products created by admins and shop owners), define default prices, SKUs, categories, and master thumbnails.
- **Shop Owner Accounts (CRUD):** Create merchant logins, update credentials, and assign managed stores.

### 2. 🏬 Shop Owner Panel (Merchant Portal)
- **My Listed Products:** Manage active products in the shop with **custom price overrides**, custom titles, custom descriptions, custom thumbnails, stock quantities, and availability toggles.
- **Shared Product Catalog Browser:** Explore platform-wide master products created by admins and other merchants, with 1-click **Add to My Shop** modal.
- **Create New Product:** Merchants can create their own custom products, which **automatically list in their store and become available in the Shared Catalog** for other merchants to sell.
- **Storefront Branding Settings:** Configure shop name, slug, logo, banner, phone, and address.

### 3. 🛍️ Customer Storefront (Public View)
- **Shop-Centric Browsing:** Customers select and explore specific independent shops.
- **Strict Shop Scoping:** Customers only see products assigned to a shop. Master catalog items not assigned to any shop remain hidden.
- **Shop-Specific Pricing & Media:** Displays shop-overridden prices, exclusive discount badges, custom descriptions, and shop-specific thumbnails.

---

## 🛠️ Technology Stack

- **Backend:** Laravel 9 (PHP 8.0+)
- **Frontend:** Vue.js 3 (Composition API), Vue Router 4, Tailwind CSS, Vite
- **Database:** MySQL / MariaDB (Relational Database)
- **Authentication:** Laravel Sanctum (Token-based SPA auth with role middleware)

---

## 🚀 Setup & Installation Guide (Step-by-Step)

Follow these exact steps to clone, configure, and run the project from a clean state:

### Prerequisites
Make sure your system has the following installed:
- **PHP** >= 8.0 (PHP 8.1 / 8.2 / 8.3 recommended with `pdo_mysql`, `mbstring`, `openssl`, `curl` extensions)
- **Composer** (PHP Package Manager)
- **Node.js** >= 18.x and **npm**
- **MySQL** / MariaDB Server (e.g. Laragon, XAMPP, or standalone MySQL)

---

### Step 1: Clone the Repository
```bash
git clone <YOUR_PUBLIC_GITHUB_REPO_URL>
cd Ecommerce_project
```

### Step 2: Install Dependencies
Install PHP and Node.js dependencies:

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### Step 3: Environment Configuration
1. Copy the environment configuration file:
```bash
cp .env.example .env
```
*(On Windows PowerShell: `copy .env.example .env`)*

2. Open `.env` and verify your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eco
DB_USERNAME=root
DB_PASSWORD=
```
> **Note:** Make sure the database (e.g. `eco` or your chosen database name) is created in MySQL.

3. Generate Laravel Application Key:
```bash
php artisan key:generate
```

### Step 4: Storage Link
Connect the public storage symlink for uploaded product thumbnails and media:
```bash
php artisan storage:link
```

### Step 5: Database Migration & Seeding
Run the fresh database migrations and seed default demo data (Admins, Shop Owners, Shops, Shared Catalog Products, and Shop-specific listings):

```bash
php artisan migrate:fresh --seed
```

### Step 6: Build Frontend Assets
Build production frontend assets using Vite:
```bash
npm run build
```
*(Optional: For hot-reloading during development, you can instead run `npm run dev` in a separate terminal)*

### Step 7: Launch the Application
Start the Laravel development server:
```bash
php artisan serve
```

The application is now running at: **`http://127.0.0.1:8000`**

---

## 🔑 Demo Access Credentials

The database seeder populates verified demo accounts for immediate testing. You can use the **1-Click Quick Login** buttons on the `/login` page or use the credentials below:

| Role | Email | Password | Access URL | Description |
| :--- | :--- | :--- | :--- | :--- |
| **Platform Administrator** | `admin@ecommerce.com` | `password` | `/admin` | Dark Theme Admin Portal (CRUD Shops, Catalog, Owners) |
| **Shop Owner 1 (ElectroTech)** | `john@shop.com` | `password` | `/vendor` | Manages "ElectroTech Hub" store & custom tech prices |
| **Shop Owner 2 (Urban Fashion)** | `sarah@shop.com` | `password` | `/vendor` | Manages "Urban Fashion Lounge" & apparel listings |
| **Shop Owner 3 (Home Essentials)** | `david@shop.com` | `password` | `/vendor` | Manages "Home Essentials & Co" store |
| **Customer Storefront** | *Public* | *None* | `/` | Browse shops and shop-scoped catalogs |

---

## 🧪 Verification & Requirement Checklist

| Requirement | Implementation Verification |
| :--- | :--- |
| **Admin Panel (CRUD)** | Accessible at `/admin` (Dark Mode). Full CRUD for Shops, Shared Catalog, and Shop Owners. |
| **Shared Product Catalog** | Catalog items created by admin or shop owners are available for all merchants at `/vendor/catalog`. |
| **Shop Owner Product Creation** | Creating a product at `/vendor/create-product` inserts into master catalog AND auto-assigns to merchant's shop. |
| **Custom Pricing & Thumbnails** | Shop owners can edit pricing, descriptions, and thumbnails at `/vendor/my-products`. |
| **Customer View Scoping** | Customer view at `/shop/{slug}` strictly queries `shop_products`. Unassigned catalog items are hidden. |

---

## 📁 Project Architecture Overview

```text
Ecommerce_project/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── AuthController.php      # Login, Logout, Me endpoints
│   │   │   ├── AdminController.php     # Admin CRUD (Shops, Catalog, Owners)
│   │   │   ├── VendorController.php    # Merchant inventory & shared catalog actions
│   │   │   └── CustomerController.php  # Public shop-scoped storefront API
│   │   └── Middleware/
│   │       └── CheckRole.php           # Role-based route authorization
│   └── Models/
│       ├── User.php                    # User model with role ('admin', 'shop_owner')
│       ├── Shop.php                    # Shop entity
│       ├── Product.php                 # Master Shared Product Catalog
│       └── ShopProduct.php             # Pivot with custom price, title, thumb overrides
├── database/
│   ├── migrations/                     # Clean schema migrations
│   └── seeders/DatabaseSeeder.php      # Seeders for instant testing
├── resources/
│   ├── js/
│   │   ├── layouts/
│   │   │   ├── AdminLayout.vue         # Modern Dark Theme Admin Layout
│   │   │   ├── VendorLayout.vue        # Merchant Portal Layout
│   │   │   └── CustomerLayout.vue      # Public Storefront Layout
│   │   ├── views/
│   │   │   ├── admin/                  # Admin CRUD views
│   │   │   ├── vendor/                 # Merchant views & catalog picker
│   │   │   ├── customer/               # Storefront & shop-scoped views
│   │   │   └── auth/Login.vue          # Modern login with validation & demo buttons
│   │   ├── router.js                   # Vue Router client-side routes
│   │   └── api.js                      # Axios instance with Sanctum interceptors
│   └── views/
│       └── app.blade.php               # Single Page Application HTML shell
└── routes/
    ├── api.php                         # REST API endpoints
    └── web.php                         # SPA entry route
```

---

## 📄 License
This project is open-sourced under the MIT license.
