<div align="center">

# Tender Management System

**Procurement workflow platform for tenders, suppliers, customers, and orders.**

<img src="https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white"/>
<img src="https://img.shields.io/badge/Vue.js-4FC08D?style=flat-square&logo=vuedotjs&logoColor=white"/>
<img src="https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white"/>
<img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white"/>
<img src="https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white"/>

</div>

---

## Overview

Procurement is a paperwork problem before it's a software problem. A single tender moves through supplier invitations, bids, evaluation, award, purchase orders, delivery, and invoicing — and in most organisations that journey lives across spreadsheets, email threads, and a filing cabinet. When a supplier asks "where is our payment," someone spends twenty minutes finding out.

This system consolidates the full procurement lifecycle into one dashboard, with the document generation that procurement actually runs on — delivery challans and invoices produced as downloadable PDFs rather than retyped into Word.

## Features

**Tender management**
Create and track tenders through their lifecycle, with associated suppliers, documents, and status.

**Supplier directory**
Central supplier records linked to tenders and orders, so procurement history for any vendor is one click away.

**Customer management**
Customer records tied to orders and invoicing.

**Order processing**
Orders connected to their originating tender and supplier, tracked through fulfilment.

**Document generation**
Delivery challans and invoices generated as downloadable PDFs, formatted for actual use rather than screen-only display.

**Unified dashboard**
A responsive Vue.js interface with consistent UI patterns across every module — the same table behaviour, filters, and form conventions everywhere, so learning one screen teaches you the rest.

## Tech stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP) |
| Frontend | Vue.js, Blade templates |
| Database | MySQL |
| Styling | Bootstrap |
| PDF generation | Server-side rendering to PDF |
| Deployment | Git pipeline on Linux / cPanel |

## Architecture notes

**Relational model.** Tenders, suppliers, customers, and orders are interlinked rather than siloed — an order traces back to its tender and supplier, which is what makes procurement history queryable instead of merely stored.

**Consistent module UI.** Every module shares the same interface conventions. This was a deliberate constraint: procurement staff use the system occasionally rather than daily, so predictability matters more than density.

**Deployment pipeline.** Configured Git-based deployment onto Linux/cPanel hosting, replacing manual FTP uploads with a repeatable process.

---

## Getting started

### Prerequisites

| Requirement | Version |
|---|---|
| PHP | 8.1+ |
| Composer | 2.x |
| Node.js | 16+ |
| MySQL | 5.7+ or 8.0 |

### Installation

**1. Clone and install dependencies**

```bash
git clone https://github.com/Ahmed-Hasnain/tender-management-system.git
cd tender-management-system

composer install
npm install
```

**2. Configure environment**

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tender_management
DB_USERNAME=root
DB_PASSWORD=
```

**3. Create the database**

```bash
mysql -u root -p -e "CREATE DATABASE tender_management;"
```

**4. Run migrations**

```bash
php artisan migrate --seed
```

The seeder creates a default admin account and sample reference data.

**5. Build frontend assets**

```bash
npm run dev      # development, with hot reload
# npm run build  # production
```

**6. Start the server**

```bash
php artisan serve
```

Open **http://localhost:8000**.

### Troubleshooting

<details>
<summary><strong>500 error on first load</strong></summary>

Usually a missing app key or unwritable storage:

```bash
php artisan key:generate
chmod -R 775 storage bootstrap/cache
```
</details>

<details>
<summary><strong>PDFs generate blank or fail</strong></summary>

PDF rendering needs a writable temp directory and the GD or Imagick PHP extension:

```bash
php -m | grep -E 'gd|imagick'
```

If neither appears, install one via your package manager and restart PHP.
</details>

<details>
<summary><strong>Vue components don't render</strong></summary>

Assets haven't been compiled. Run `npm run dev` and leave it running, or `npm run build` for a one-off production build.
</details>

---

## Project structure

```
tender-management-system/
├── app/
│   ├── Http/Controllers/    Request handling per module
│   ├── Models/              Eloquent models
│   └── Services/            Business logic
├── database/
│   ├── migrations/          Schema definitions
│   └── seeders/             Sample and reference data
├── resources/
│   ├── js/components/       Vue components
│   └── views/               Blade templates and PDF layouts
├── routes/
│   └── web.php
└── public/
```

---

## License

MIT — see [LICENSE](LICENSE).

---

<div align="center">

Built by **[Ahmed Hasnain](https://github.com/Ahmed-Hasnain)** · [ahmedhasnain.com](https://ahmedhasnain.com) · [LinkedIn](https://www.linkedin.com/in/ahmedhasnain/)

</div>