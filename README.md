# Student Portfolio & Project Management System

College-ready PHP 8 portfolio with a responsive Bootstrap public site and protected admin CMS. Its repository factory means the same views, services and validation work against MongoDB or MySQL.

## Features

- Home, About, database-driven Skills, Projects, Project Details, Contact and Login pages.
- Contact form has server/client validation, CSRF protection and a real database INSERT.
- Session-protected dashboard; Project CRUD, Skill CRUD, and contact read/delete.
- Secure image uploads: verified JPG/PNG/WEBP MIME types, 2 MB maximum, random filename.
- `password_hash()`/`password_verify()`, output escaping, typed MongoDB IDs and PDO prepared statements.

## Installation

Requires PHP 8+. The default local setup uses a file-backed JSON database, so Composer, MySQL, and MongoDB are optional until you switch database drivers.

```bash
cd student-portfolio
copy .env.example .env
php -S localhost:8000 router.php
```

On this Windows/XAMPP machine, PHP is available at:

```powershell
C:\xampp\php\php.exe -S 127.0.0.1:8000 router.php
```

Open `http://localhost:8000`. The file driver creates sample projects, skills, and a test admin automatically. Test admin credentials are **admin** / **Admin@12345**. Change these after deployment.

## MongoDB setup

Set `DB_DRIVER=mongodb`, `MONGODB_URI`, and `MONGODB_DATABASE` in `.env`. Optionally run `mongosh student_portfolio database/mongodb/seed.js` to create indexes/sample skills, then run `php database/seed.php` to create the password-hashed admin and cross-database sample data.

Run `composer install` before using MongoDB because that driver depends on `mongodb/mongodb` and `vlucas/phpdotenv`.

## MySQL setup

Import with `mysql -u root -p < database/mysql/schema.sql`. Set `DB_DRIVER=mysql` plus all `MYSQL_*` variables in `.env`, then run `php database/seed.php`.

Run `composer install` if you want the Composer autoloader and Dotenv package available. The MySQL driver itself uses PDO.

## Switching databases

**MongoDB to MySQL:** import `database/mysql/schema.sql`; set `DB_DRIVER=mysql` and valid `MYSQL_*` values; seed if empty.

**MySQL to MongoDB:** set `DB_DRIVER=mongodb`, `MONGODB_URI`, `MONGODB_DATABASE`; run Mongo seed (optional) and `php database/seed.php`.

Nothing in controllers, services or views needs changing: `RepositoryFactory` selects the matching repository implementation.

## Structure

`app/Config` contains environment loading; `app/Database` connections; `app/Repositories` interfaces plus MongoDB/MySQL implementations; `app/Services` validation/uploads; `public` pages/assets/uploads; `admin` CMS; and `database` schemas/seeds.

## Customisation

Replace the student name, college, email/phone, GitHub, LinkedIn, profile image and resume details in `public/index.php`, `public/about.php`, and the shared public layout. Add/edit skills and projects through the admin panel.

## Deployment

Upload project files excluding `.env`; run `composer install --no-dev --optimize-autoloader` (or upload `vendor`); create server `.env` with `APP_ENV=production` and database credentials; and make `public/uploads/projects/` writable. Point the document root to `public` and configure an `/admin` alias if required by the hosting panel. MySQL works on most shared PHP hosts; MongoDB additionally requires the PHP extension and MongoDB/Atlas connectivity. Never expose `.env`.

## Security and testing

State-changing forms use CSRF tokens. Inputs are validated/sanitised; output is escaped; Mongo queries use safe typed filters and MySQL uses bound statements. Test public reads/contact INSERT; login/logout; Project/Skill CRUD; contacts; bad form values, invalid CSRF tokens, unsafe uploads; and repeat basic CRUD after switching `DB_DRIVER`.

## How This Project Satisfies Assignment No. 2

1. **HTML/CSS/JS/Bootstrap:** Bootstrap 5, Bootstrap Icons, custom responsive CSS, and vanilla validation JavaScript.
2. **Customised portfolio:** student education, career goals and editable portfolio content.
3. **Database connectivity/CRUD:** Contact INSERT, Project CREATE/READ/UPDATE/DELETE, Skills CRUD, and MongoDB/MySQL database switching.
4. **Remote deployment:** Composer, `.env`, hosting and database instructions support a public PHP deployment.
5. **Public link submission:** deploy following this README and submit that URL to the course portal.

## Troubleshooting

Run `composer install` if `vendor/autoload.php` is missing. Confirm the PHP MongoDB/PDO extension, credentials and schema if connections fail. Ensure the uploads directory is writable if image saving fails.
