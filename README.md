# Koperasi Management System

## Project Overview

Koperasi Management System is a web application for managing cooperative members, Front Office staff, profile information, authentication activity, notifications, and operational audit logs.

### Main features

- Role-based access for Super Admin, Front Office, and Member users.
- Member registration, search, filtering, profile management, and status tracking.
- Front Office account management for Super Admin users.
- Personal profile and password management for every authenticated user.
- Login and activity logs, plus in-app notifications.
- Indonesian province, city, district, and village reference data.

### Technology stack

- PHP 8.3+ and Laravel 13
- MySQL-compatible database
- Blade templates, Tailwind CSS 4, Alpine.js, and Vite
- PHPUnit for automated tests

## Prerequisites

Install the following before starting:

- PHP **8.3 or later** with `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `tokenizer`, `xml`, and `ctype` enabled.
- Composer **2.x**.
- Node.js **20.19+** or **22.12+** and npm.
- MySQL **8.0+** or a compatible MariaDB release.
- Git.

Laragon is a convenient local environment on Windows, but it is not required.

## Installation Guide

1. Clone the repository and enter its directory.

   ```bash
   git clone <repository-url> koperasi-test
   cd koperasi-test
   ```

2. Install PHP dependencies.

   ```bash
   composer install
   ```

3. Install Node.js dependencies.

   ```bash
   npm install
   ```

4. Create the environment file.

   ```bash
   cp .env.example .env
   ```

   On Windows PowerShell, use:

   ```powershell
   Copy-Item .env.example .env
   ```

5. Generate the application key.

   ```bash
   php artisan key:generate
   ```

6. Configure the database values in `.env`.

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=koperasi_test
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Create the `koperasi_test` database before continuing.

7. Run the database migrations.

   ```bash
   php artisan migrate
   ```

8. Seed the reference data and demo accounts.

   ```bash
   php artisan db:seed
   ```

   To recreate a local database from scratch, use:

   ```bash
   php artisan migrate:fresh --seed
   ```

9. Build frontend assets.

   ```bash
   npm run build
   ```

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application is available at [http://127.0.0.1:8000](http://127.0.0.1:8000) by default.

For hot-reloading frontend assets during development, run this in a second terminal:

```bash
npm run dev
```

The default configuration uses the database queue driver. Start a worker only when the application is dispatching queued jobs:

```bash
php artisan queue:work
```

No scheduled tasks are currently registered, so a scheduler process is not required. If scheduled tasks are added later, run:

```bash
php artisan schedule:work
```

Alternatively, `composer run dev` starts the application server, queue listener, and Vite development server together.

## Testing

Run the automated test suite with:

```bash
php artisan test
```

To run one test class or test by name:

```bash
php artisan test --filter=AuthorizationTest
```

## Default Accounts for Testing

All accounts below are created by `DatabaseSeeder` and use the password `password123`. Authentication uses the email address; there is no separate username field.

> Demo credentials are intended for local development only. Change or remove them before deploying any shared environment.

### Super Admin

| Full Name | Email | Username | Password |
| --- | --- | --- | --- |
| Ahmad Fauzan | `superadmin@koperasi.id` | Not applicable | `password123` |
| Dimas Saputra | `admin2@koperasi.id` | Not applicable | `password123` |

### Admin

This project does not define a standalone `Admin` role. The system's administrative role is `Super Admin`; use either Super Admin account above for administrative testing.

### Front Office

| Full Name | Email | Username | Password |
| --- | --- | --- | --- |
| Rini Wati | `fo1@koperasi.id` | Not applicable | `password123` |
| Bagus Pratama | `fo2@koperasi.id` | Not applicable | `password123` |

### Member

| Full Name | Email | Username | Password |
| --- | --- | --- | --- |
| Siti Aminah | `member1@koperasi.id` | Not applicable | `password123` |
| Budi Santoso | `member2@koperasi.id` | Not applicable | `password123` |

## Project Structure

```text
app/                    Application models, controllers, services, policies, and requests
bootstrap/              Framework bootstrap files
config/                 Application and service configuration
database/factories/     Model factories used by tests
database/migrations/    Database schema migrations
database/seeders/       Reference data and deterministic demo accounts
public/                 Public web entry point and built assets
resources/css/          Tailwind CSS source files
resources/js/           Frontend JavaScript source files
resources/views/        Blade templates and reusable view components
routes/                 Web and console route definitions
storage/                Logs, cached files, and uploaded local files
tests/                  PHPUnit feature tests
```

## Environment Configuration

Configure these values in `.env` for a local installation:

| Variable | Purpose |
| --- | --- |
| `APP_NAME` | Application name shown in the interface. |
| `APP_ENV` | Environment name, normally `local` during development. |
| `APP_KEY` | Laravel encryption key; generate it with `php artisan key:generate`. |
| `APP_URL` | Base application URL, such as `http://127.0.0.1:8000`. |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Database connection settings. |
| `SESSION_DRIVER` | Session storage driver. The default is `database`, which requires migrations to run. |
| `CACHE_STORE` | Cache storage driver. The default is `database`. |
| `QUEUE_CONNECTION` | Queue driver. The default is `database`; use `sync` if no worker is needed locally. |
| `FILESYSTEM_DISK` | Default file storage disk. |
| `MAIL_MAILER` | Mail transport. The default `log` driver writes messages to application logs. |

After editing environment values, clear cached configuration:

```bash
php artisan optimize:clear
```

## Troubleshooting

### `Class ... not found` or missing PHP packages

Run Composer again and ensure PHP 8.3+ is being used:

```bash
composer install
php -v
```

### Database connection or `Unknown database` error

Create the database, verify the `DB_*` values in `.env`, then clear cached configuration:

```bash
php artisan optimize:clear
php artisan migrate --seed
```

### `Vite manifest not found` or styles are missing

Install dependencies and build the assets:

```bash
npm install
npm run build
```

For development, leave `npm run dev` running in a second terminal.

### Node.js version warning from Vite

Upgrade Node.js to 20.19+ or 22.12+, then reinstall packages if necessary:

```bash
node --version
npm install
```

### Queue jobs remain pending

With `QUEUE_CONNECTION=database`, start a worker:

```bash
php artisan queue:work
```

### Seed credentials do not work

Reset the local database and regenerate the documented accounts:

```bash
php artisan migrate:fresh --seed
```

## License

No license has been specified for this repository. Add a `LICENSE` file before distributing the project outside your organization.
