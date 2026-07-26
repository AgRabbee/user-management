# User Management

A Laravel web application for managing member (person) records within an organisation. It provides authenticated CRUD management of member profiles, bulk import from Excel, PDF profile reports, and configurable ad-hoc reporting with Excel export.

## Key Features

- **Authentication**: registration, login, logout, email verification, password reset and password confirmation, built on Laravel Breeze.
- **User profile management**: update profile information, change password, delete account.
- **Member (person) records management**:
  - List members in a searchable, sortable, paginated table (server-side processing via Yajra DataTables).
  - Create and edit member records, including personal details, contact numbers, blood group, marital status, present/permanent address, academic information and professional information.
  - Track family relationships: spouse and head-of-family links between member records.
  - Look up a member by user ID (used for spouse/family-head selection).
- **Bulk import**: upload an Excel file (`.xlsx`/`.xls`) to import or update member records in bulk.
- **PDF report**: generate a single-member profile report as a PDF (via mPDF), viewable in the browser.
- **Custom reports**:
  - Maintain a list of predefined SQL-backed reports.
  - Generate a report with a user-selected subset of columns and view the results as an HTML table.
  - Export a generated report to an Excel file and download it.
  - Edit report metadata (title, type, active/inactive status).
- **API**: a single Sanctum-authenticated endpoint that returns the current user.

## Tech Stack

**Backend**
- PHP 8.1
- Laravel Framework 10
- Laravel Sanctum (API authentication)
- Laravel Breeze (authentication scaffolding)
- Laravel Tinker
- Guzzle HTTP client
- Yajra Laravel DataTables (Oracle package) for server-side table processing
- Maatwebsite Excel (import/export of `.xlsx`/`.xls` files)
- mPDF (PDF generation)

**Frontend build tooling**
- Vite
- Tailwind CSS (with `@tailwindcss/forms`)
- Alpine.js
- Axios
- PostCSS / Autoprefixer

The member and reporting pages use a separate Bootstrap-based admin template whose assets (CSS/JS, DataTables, Select2, SweetAlert2, Toastr, Dropzone) are served as static files from `public/assets` and `public/plugins` rather than through the npm build.

**Database**
- MySQL (as configured in `.env.example`)

**Development and testing**
- PHPUnit
- Laravel Pint
- Laravel Sail
- Mockery, FakerPHP, Spatie Laravel Ignition, Collision

## Screenshots

<!-- Add screenshots of the application here, for example: login page, member list, member form, and generated PDF/Excel reports. -->

## Installation and Setup

### Requirements

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL

### Steps

1. Clone the repository and move into the project directory.

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node dependencies:
   ```bash
   npm install
   ```

4. Copy the example environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure the database connection in `.env` (MySQL by default):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. Run the database migrations. A seeder is also available to populate initial users and reports:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. Build front-end assets:
   ```bash
   npm run dev
   ```
   or, for a production build:
   ```bash
   npm run build
   ```

8. Start the local development server:
   ```bash
   php artisan serve
   ```

The application will be available at the URL printed by `artisan serve` (by default `http://localhost:8000`).

## About This Project

This project demonstrates a member/community record-keeping system built with Laravel. It illustrates authenticated CRUD workflows, server-side data tables, bulk data import from spreadsheets, PDF document generation, and a configurable ad-hoc reporting module with Excel export.
