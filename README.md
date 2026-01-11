# Data Center Resource Reservation (Laravel + MySQL) — Skeleton (No Bootstrap/Tailwind/jQuery)

This archive contains the **custom application code** (controllers, models, migrations, views, css/js) for the project.
It is designed to be **copied into a fresh Laravel project**.

## Requirements
- PHP 8.2+ (recommended)
- Composer
- MySQL / MariaDB
- Laravel 10/11 compatible

## Setup (recommended)
1) Create a fresh Laravel app:
   ```bash
   composer create-project laravel/laravel dc-reservations
   cd dc-reservations
   ```

2) Copy the folders from this archive into your Laravel project root (merge/overwrite):
   - app/
   - database/
   - public/
   - resources/
   - routes/

3) Configure `.env` (DB_* variables), then:
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   php artisan serve
   ```

4) Default seeded accounts (password: `password`)
- Admin: admin@datacenter.local
- Manager: manager@datacenter.local
- User: user@datacenter.local

## Notes
- UI uses **Blade + custom CSS + vanilla JS** (no Bootstrap/Tailwind/jQuery).
- Roles are stored as a single column on `users.role` with values:
  `guest`, `user`, `manager`, `admin`
- Access control uses middleware + policies.
- Reservations support conflict detection (overlap) and maintenance blocking.
- Notifications are stored in an internal inbox table (`notifications`).

## What you still may want to add
- Email notifications (optional)
- Better charts (still vanilla JS, no frameworks)
- PHPUnit feature tests
- Pagination & advanced filtering

