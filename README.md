# Furniture Site Setup Guide

This is a Laravel ecommerce website for a furniture store. It has a public storefront, products, cart, checkout, wishlist, blog, contact form, newsletter, customer login, OTP email support, and an admin dashboard.

This README is written for beginners who have little or no experience with PHP or Laravel.

## What You Need To Install

Before running this project, install these tools on your computer.

### 1. XAMPP

XAMPP gives you PHP, Apache, and MySQL in one package.

Download and install XAMPP from:

```text
https://www.apachefriends.org/
```

During installation, make sure these components are selected:

- Apache
- MySQL
- PHP
- phpMyAdmin

After installing XAMPP:

1. Open XAMPP Control Panel.
2. Start `Apache`.
3. Start `MySQL`.

Important: this project requires PHP 8.3 or higher. If your XAMPP PHP version is lower than 8.3, install a newer XAMPP version or install PHP 8.3 separately.

Check PHP version:

```bash
php -v
```

### 2. Composer

Composer installs PHP/Laravel dependencies.

Download and install Composer from:

```text
https://getcomposer.org/download/
```

During Composer installation on Windows, select the PHP file from your XAMPP folder, usually:

```text
C:\xampp\php\php.exe
```

After installation, close and reopen your terminal, then check:

```bash
composer -V
```

### 3. Node.js And npm

Node.js and npm are needed for frontend assets such as Vite and Tailwind CSS.

Download and install Node.js LTS from:

```text
https://nodejs.org/
```

After installation, close and reopen your terminal, then check:

```bash
node -v
npm -v
```

### 4. Git

Git is used to download or clone the project.

Download Git from:

```text
https://git-scm.com/downloads
```

Check Git:

```bash
git --version
```

## Project Features

- Public furniture storefront
- Product listing and product details
- Cart and coupon support
- Checkout and order success page
- Customer login, registration, OTP verification, account page, and wishlist
- Blog pages
- Contact form and newsletter subscription
- Admin dashboard
- Product, category, order, user, coupon, review, banner, blog, page, message, subscriber, and setting management
- Multilingual language files
- Laravel, Vite, and Tailwind CSS

## Step 1: Download The Project

Open a terminal or PowerShell.

Go to the folder where you want to keep the project:

```bash
cd Desktop
```

Clone the project:

```bash
git clone <repository-url>
```

Open the project folder:

```bash
cd furnitureSite
```

If you already have the project folder, just open it:

```bash
cd path/to/furnitureSite
```

Example on Windows:

```powershell
cd D:\furnitureSite
```

## Step 2: Install PHP Dependencies

Run:

```bash
composer install
```

This command creates the `vendor/` folder and installs Laravel packages.

If this command fails, check:

- PHP is installed
- Composer is installed
- Your PHP version is 8.3 or higher
- Required PHP extensions are enabled in `php.ini`

Common PHP extensions needed by Laravel:

- `openssl`
- `pdo`
- `pdo_mysql`
- `mbstring`
- `tokenizer`
- `xml`
- `ctype`
- `json`
- `fileinfo`
- `curl`
- `zip`

For XAMPP, the PHP config file is usually:

```text
C:\xampp\php\php.ini
```

To enable an extension, remove the semicolon `;` before it.

Example:

```ini
extension=zip
```

Then restart Apache and reopen the terminal.

## Step 3: Create The Environment File

Laravel uses a `.env` file for database, app, mail, and other settings.

Copy `.env.example` to `.env`.

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Git Bash, macOS, or Linux:

```bash
cp .env.example .env
```

## Step 4: Generate Laravel App Key

Run:

```bash
php artisan key:generate
```

This sets `APP_KEY` inside `.env`.

## Step 5: Setup Database

You can use either SQLite or MySQL.

SQLite is simpler for beginners. MySQL is better if you want to use XAMPP/phpMyAdmin.

## Option A: SQLite Setup

Open `.env` and make sure it has:

```env
DB_CONNECTION=sqlite
```

Create the SQLite database file.

Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File -Force
```

Git Bash, macOS, or Linux:

```bash
touch database/database.sqlite
```

Then run:

```bash
php artisan migrate --seed
```

## Option B: MySQL Setup With XAMPP

Start XAMPP:

1. Open XAMPP Control Panel.
2. Start `Apache`.
3. Start `MySQL`.

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a new database named:

```text
furniture_site
```

Open `.env` and update the database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=furniture_site
DB_USERNAME=root
DB_PASSWORD=
```

For default XAMPP MySQL, username is usually `root` and password is empty.

Now run:

```bash
php artisan migrate --seed
```

This creates all database tables and inserts demo data.

## Step 6: Install Frontend Dependencies

Run:

```bash
npm install
```

This creates the `node_modules/` folder and installs Vite, Tailwind CSS, Axios, and other frontend tools.

## Step 7: Build Frontend Assets

For normal use, run:

```bash
npm run build
```

For development, run:

```bash
npm run dev
```

Keep `npm run dev` running while developing the frontend.

## Step 8: Create Storage Link

Run:

```bash
php artisan storage:link
```

This allows public access to uploaded files stored by Laravel.

## Step 9: Start The Project

Open one terminal in the project folder and run:

```bash
php artisan serve
```

You should see a URL like:

```text
http://127.0.0.1:8000
```

Open that URL in your browser.

If you are developing frontend files, open a second terminal and run:

```bash
npm run dev
```

## One-Command Development Mode

This project also has a Composer script that can run the server, queue, logs, and Vite together:

```bash
composer run dev
```

Use this after setup is complete.

## Login Accounts After Seeding

After running:

```bash
php artisan migrate --seed
```

you can login with these accounts.

| Role | Login URL | Email | Password |
| --- | --- | --- | --- |
| Super Admin | `/admin/login` | `admin@dmin.com` | `admin123` |
| Admin | `/admin/login` | `admin@attafurniture.com` | `password` |
| Customer | `/login` | `customer@example.com` | `password` |

Example admin URL:

```text
http://127.0.0.1:8000/admin/login
```

Example customer URL:

```text
http://127.0.0.1:8000/login
```

## Common Commands

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Run migrations:

```bash
php artisan migrate
```

Run migrations with seed data:

```bash
php artisan migrate --seed
```

Reset database and seed again:

```bash
php artisan migrate:fresh --seed
```

Start Laravel server:

```bash
php artisan serve
```

Start Vite development server:

```bash
npm run dev
```

Build production assets:

```bash
npm run build
```

Clear Laravel cache:

```bash
php artisan optimize:clear
```

Run tests:

```bash
php artisan test
```

## Important `.env` Settings

Basic local settings:

```env
APP_NAME="Furniture Site"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

SQLite database:

```env
DB_CONNECTION=sqlite
```

MySQL database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=furniture_site
DB_USERNAME=root
DB_PASSWORD=
```

Mail settings for local development:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

With `MAIL_MAILER=log`, emails are saved in Laravel logs instead of being sent.

Laravel log file:

```text
storage/logs/laravel.log
```

## Folder Structure

```text
app/                    Main PHP application code
app/Http/Controllers/   Public, customer, auth, and admin controllers
app/Models/             Database models
database/migrations/    Database table files
database/seeders/       Demo data and default users
resources/views/        Blade HTML templates
resources/css/          CSS entry file
resources/js/           JavaScript entry file
routes/web.php          Website routes
public/uploads/         Public uploaded/demo images
storage/                Logs, cache, sessions, and generated files
```

## Troubleshooting

### `php` is not recognized

PHP is not added to your system PATH.

For XAMPP on Windows, add this folder to PATH:

```text
C:\xampp\php
```

Then close and reopen PowerShell.

Check again:

```bash
php -v
```

### `composer` is not recognized

Composer is not installed or terminal was opened before installation.

Fix:

1. Install Composer.
2. Close PowerShell.
3. Open PowerShell again.
4. Run:

```bash
composer -V
```

### Database connection error

Check your `.env` database settings.

For MySQL:

- XAMPP MySQL must be running.
- Database name must exist in phpMyAdmin.
- `DB_USERNAME` and `DB_PASSWORD` must be correct.

After changing `.env`, run:

```bash
php artisan optimize:clear
```

### Vite manifest not found

Run:

```bash
npm install
npm run build
```

For development, also run:

```bash
npm run dev
```

### Permission or storage image problem

Run:

```bash
php artisan storage:link
php artisan optimize:clear
```

### Class not found or package error

Run:

```bash
composer install
composer dump-autoload
php artisan optimize:clear
```

## Deployment Checklist

On a live server, use production settings.

Run:

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

Also configure:

- Production database
- Real mail provider
- Queue worker
- Correct permissions for `storage/` and `bootstrap/cache/`

## Security Note

The route `/deploy-fix` exists in `routes/web.php` for temporary hosting fixes. If you use this route during deployment, delete or disable it immediately after it finishes.
