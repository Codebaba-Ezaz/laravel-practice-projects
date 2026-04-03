# Practice Auth

Laravel 12 authentication practice project using PostgreSQL.

## Stack

- PHP 8.4
- Laravel 12
- PostgreSQL
- Vite

## Project Purpose

This project is for practicing:

- Register and login flow
- Session-based authentication
- Laravel migrations with PostgreSQL
- Basic auth controller and routes

## Environment Setup

Update your [.env](.env) database configuration:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=practice_auth
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Session configuration options:

Use file sessions (simple local setup):

```env
SESSION_DRIVER=file
```

Use database sessions (requires `sessions` table):

```env
SESSION_DRIVER=database
```

## Install and Run

```bash
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

## Migrations

Core migrations are in [database/migrations](database/migrations).

If you use `SESSION_DRIVER=database`, ensure the sessions migration uses this schema:

```php
Schema::create('sessions', function (Blueprint $table) {
	$table->string('id')->primary();
	$table->foreignId('user_id')->nullable()->index();
	$table->string('ip_address', 45)->nullable();
	$table->text('user_agent')->nullable();
	$table->longText('payload');
	$table->integer('last_activity')->index();
});
```

Current sessions migration file:
[database/migrations/2026_04_03_005727_create_sessions_table_for_pgsql.php](database/migrations/2026_04_03_005727_create_sessions_table_for_pgsql.php)

## Verify in pgAdmin

Open:

`Databases > practice_auth > Schemas > public > Tables`

Expected tables include:

- users
- sessions
- cache
- cache_locks
- jobs

## Useful Commands

Clear config/cache after env changes:

```bash
php artisan optimize:clear
```

Reset and re-run migrations:

```bash
php artisan migrate:fresh
```
