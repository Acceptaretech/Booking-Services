# HandyMan — Multivendor Service Booking Platform

A full-stack Laravel platform similar to Urban Company, built with **PHP Laravel 11**, **Blade + Tailwind CSS**, **MySQL**, and **REST APIs** for React Native.

---

## 🚀 Quick Setup

```bash
# 1. Clone / extract the project
cd handyman

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure your database in .env
#    DB_DATABASE=handyman_db
#    DB_USERNAME=root
#    DB_PASSWORD=yourpassword

# 6. Run migrations + seed demo data
php artisan migrate --seed

# 7. Create storage symlink
php artisan storage:link

# 8. Start development server
php artisan serve
```

---

## 👤 Demo Login Credentials

| Role     | Email                  | Password   |
|----------|------------------------|------------|
| Admin    | admin@demo.com         | password   |
| Provider | provider@demo.com      | password   |
| Handyman | handyman@demo.com      | password   |
| Customer | customer@demo.com      | password   |

---

## 📁 Project Structure

```
handyman/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── CategoryController.php (+ UserController, SettingsController)
│   │   │   ├── Provider/       # Provider/Handyman controllers
│   │   │   │   ├── DashboardController.php (+ BookingController, ServiceController)
│   │   │   ├── Customer/       # Customer panel controllers
│   │   │   ├── Api/            # REST API controllers (React Native)
│   │   │   │   ├── AuthApiController.php
│   │   │   │   ├── ServiceApiController.php
│   │   │   │   ├── BookingApiController.php
│   │   │   └── Auth/
│   │   │       └── AuthController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/                 # 22 Eloquent models
│   └── Services/
│       └── BookingService.php  # Core booking business logic
├── database/
│   ├── migrations/             # Complete schema (24+ tables)
│   └── seeders/
│       └── DatabaseSeeder.php  # Demo data seeder
├── resources/views/
│   ├── layouts/
│   │   ├── public/app.blade.php   # Public website layout
│   │   └── admin/app.blade.php    # Admin/Provider dashboard layout
│   ├── public/home/index.blade.php
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   └── bookings/index.blade.php
│   ├── provider/dashboard.blade.php
│   ├── customer/bookings/create.blade.php
│   └── components/service-card.blade.php
├── routes/
│   ├── web.php     # All web routes (public, customer, provider, admin)
│   └── api.php     # REST API v1 routes
└── bootstrap/app.php
```

---

## 🗄️ Database Schema (24 Tables)

| Table                  | Purpose                              |
|------------------------|--------------------------------------|
| `users`                | All roles (admin, provider, handyman, customer) |
| `user_documents`       | Provider KYC documents               |
| `zones`                | Admin-created service zones          |
| `categories`           | Service categories                   |
| `sub_categories`       | Sub-categories                       |
| `shops`                | Provider shops/branches              |
| `services`             | Services with pricing & metadata     |
| `service_faqs`         | Per-service FAQ entries              |
| `packages`             | Service packages                     |
| `addons`               | Booking add-ons                      |
| `handyman_commissions` | Provider-defined handyman rates      |
| `bookings`             | Core booking records                 |
| `booking_status_logs`  | Full status audit trail              |
| `payments`             | Commission-split payment records     |
| `commission_settings`  | Per-provider or global commission    |
| `coupons`              | Discount coupons                     |
| `reviews`              | Customer reviews with ratings        |
| `wallet_transactions`  | Credit/debit wallet ledger           |
| `withdrawal_requests`  | Provider payout requests             |
| `job_requests`         | Custom job postings by customers     |
| `job_bids`             | Provider bids on job requests        |
| `promotional_banners`  | Provider-uploaded promo banners      |
| `help_desks`           | Support tickets                      |
| `system_configs`       | Admin-controlled site settings       |
| `taxes`                | Tax configurations                   |
| `notifications_log`    | In-app notifications                 |

---

## 🌐 Web Routes

### Public
- `GET /` — Homepage
- `GET /categories` — All categories
- `GET /services` — Services listing with filters
- `GET /services/{service}` — Service detail
- `GET /providers` — Provider listing
- `GET /blogs` — Blog listing
- `GET /login`, `POST /login`
- `GET /register`, `POST /register`
- `GET /register/provider`, `POST /register/provider`

### Customer Panel (`/customer/...`)
- Dashboard, bookings, book service, coupon apply, review, profile

### Provider Panel (`/provider/...`)
- Dashboard, bookings, services, shops, packages, addons, handymen, payments, withdrawals, banners, help desk, profile

### Admin Panel (`/admin/...`)
- Dashboard, bookings, categories, sub-categories, services, providers, customers, handymen, payments, withdrawals, coupons, blogs, zones, taxes, jobs, banners, reports, settings, help desk, ratings

---

## 🔌 REST API v1 (`/api/v1/...`)

### Public Endpoints
```
POST /api/v1/auth/register
POST /api/v1/auth/login
POST /api/v1/auth/send-otp
POST /api/v1/auth/verify-otp
GET  /api/v1/categories
GET  /api/v1/services
GET  /api/v1/services/top-rated
GET  /api/v1/services/featured
GET  /api/v1/services/{id}
GET  /api/v1/providers
GET  /api/v1/blogs
```

### Authenticated Endpoints (Bearer Token)
```
POST   /api/v1/auth/logout
GET    /api/v1/auth/profile
POST   /api/v1/auth/profile

GET    /api/v1/bookings
POST   /api/v1/bookings
GET    /api/v1/bookings/{id}
PATCH  /api/v1/bookings/{id}/status
POST   /api/v1/bookings/{id}/review
POST   /api/v1/calculate-price

POST   /api/v1/coupons/validate
GET    /api/v1/wallet
GET    /api/v1/notifications
GET    /api/v1/job-requests
POST   /api/v1/job-requests
GET    /api/v1/provider/dashboard
GET    /api/v1/provider/earnings
```

### Example Request — Create Booking
```json
POST /api/v1/bookings
Authorization: Bearer {token}
{
  "service_id": 1,
  "booking_date": "2026-05-10T10:00:00",
  "quantity": 1,
  "address": "72 Elite Street, San Francisco, CA",
  "coupon_code": "SAVE20",
  "payment_type": "cash",
  "addons": [1, 2]
}
```

### Example Response
```json
{
  "success": true,
  "message": "Booking created.",
  "data": {
    "id": 1,
    "booking_number": "BK-63F2A1",
    "status": "pending",
    "total_amount": "47.25",
    "payment_type": "cash"
  }
}
```

---

## 💡 Key Features

- ✅ Multi-role auth (Admin, Provider, Handyman, Customer)
- ✅ Provider KYC with document uploads
- ✅ Complete booking flow with status tracking
- ✅ Commission split (Admin → Provider → Handyman)
- ✅ Wallet system with credit/debit ledger
- ✅ Coupon & discount system
- ✅ Service packages & add-ons
- ✅ Promotional banners (provider-purchased)
- ✅ Job request & bidding system
- ✅ Export bookings (XLSX/CSV/PDF)
- ✅ Dark/light theme toggle
- ✅ Multi-language ready
- ✅ REST API with Laravel Sanctum
- ✅ Geolocation support
- ✅ SEO fields on categories

---

## 🛠️ Tech Stack

| Layer      | Technology                    |
|------------|-------------------------------|
| Backend    | PHP 8.2 / Laravel 11          |
| Frontend   | Blade + Tailwind CSS v3       |
| Database   | MySQL 8.0                     |
| Auth       | Laravel Sanctum               |
| Charts     | Chart.js                      |
| Storage    | Laravel Storage (S3-ready)    |
| API Client | Axios / Fetch (React Native)  |

---

## 📧 Support

For any questions, customize the `.env` and reach out at info@handyman.com
