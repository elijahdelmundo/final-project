# Xander/Elijah POS

A CodeIgniter 4 point-of-sale system for product inventory, customers, staff accounts, checkout, and sales history.

## Website

[Open Xander/Elijah POS](http://127.0.0.1:8009)

This preview link works when the application is running locally on port 8009.

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
- Navy-and-blue responsive management interface

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

## Public hosting (cPanel)

Use PHP 8.2+ hosting with Composer (or upload the `vendor` directory), MySQL/MariaDB, and the `intl`, `mbstring`, and `mysqli` PHP extensions.

1. In cPanel, create a MySQL database and user, then grant the user access to the database.
2. Upload the project outside the public web root when possible and set the site's document root to this project's `public` directory.
3. Install production dependencies with `composer install --no-dev --optimize-autoloader` if Composer is available on the host.
4. Copy `env` to `.env`. Set `CI_ENVIRONMENT = production`, the site's HTTPS `app.baseURL`, and the MySQL connection settings from `env`.
5. Add a unique production `pos.adminUsername`, `pos.adminFullName`, and `pos.adminPassword` to the server's private `.env`. The production seeder requires a custom password of at least 12 characters; it does not use the local demo credentials.
6. Set a private production `encryption.key`, enable HTTPS, and ensure the `writable` directory is writable by PHP and not publicly accessible.
7. Run `php spark migrate` and `php spark db:seed PosSeeder` from the project directory. Verify login, image uploads, checkout, and stock updates on the hosted domain.

Never put `.env` in the public web directory or commit it to GitHub. The README's `127.0.0.1` link is a local preview; replace it with the real HTTPS URL after deployment.
