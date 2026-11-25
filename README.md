# Delmundo Point of Sale

A CodeIgniter 4 POS system for product inventory, customers, staff accounts, sales checkout, and sales history.

## Features

- Staff sign-in with password hashing and session regeneration
- Authentication filter protects all POS management routes
- Product create/list/edit/delete with image uploads
- Customer create/list/edit/delete
- Staff create/list/edit/delete with hashed passwords and avatar uploads
- Image uploads restricted to JPG, PNG, or WebP up to 2 MB; upload files are stored outside the public web root
- Record a sale with an optional customer
- Stock is decremented within a database transaction; an atomic stock check rejects insufficient inventory
- Sales history includes product, customer, staff member, quantity, total, and date
- SQLite database, migrations, and sample seeder for easy local setup
- Delmundo navy-and-blue responsive management interface

## Requirements

- PHP 8.2+
- Composer
- PHP extensions `intl`, `mbstring`, and `sqlite3`

## Setup

From this directory:

```powershell
composer install
Copy-Item env .env
php spark migrate
php spark db:seed PosSeeder
php spark serve --host 127.0.0.1 --port 8009
```

Open `http://127.0.0.1:8009`.

The SQLite database is created at `writable/pos.db`. For a clean database, remove that file, then rerun the migration and seeder commands.

## Sample staff sign-in

- Username: `admin`
- Password: `password`

Change the sample password and remove or change demo records before deploying publicly.

## Production notes

Configure the web server document root to this project's `public` directory. Set `CI_ENVIRONMENT = production`, configure HTTPS, use a production-strength secret/session setup, and change seeded credentials before deployment. Keep `.env`, the SQLite database, and `writable/uploads` out of source control.
