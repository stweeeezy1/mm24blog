# mm24blog

A simple blog built with Laravel, Tailwind CSS and Vite, using SQLite as the database.

This guide takes you from a computer with nothing installed to a running project. The commands are written for **Windows (PowerShell)**. Notes for macOS and Linux are included where they differ.

## Table of contents

1. [Install the required programs](#1-install-the-required-programs)
2. [Enable the required PHP extensions](#2-enable-the-required-php-extensions)
3. [Clone the project](#3-clone-the-project)
4. [Install dependencies](#4-install-dependencies)
5. [Create the `.env` file](#5-create-the-env-file)
6. [Create the database](#6-create-the-database)
7. [Run the project](#7-run-the-project)
8. [Troubleshooting](#8-troubleshooting)

---

## 1. Install the required programs

You need five programs: **VS Code**, **Git**, **PHP**, **Composer** and **Bun**.

Open PowerShell and install them with `winget` (built into Windows 10/11):

```powershell
winget install Microsoft.VisualStudioCode
winget install Git.Git
winget install PHP.PHP.8.4
winget install Composer.Composer
winget install Oven-sh.Bun
```

If `winget` asks you to accept agreements, type `Y` and press Enter.

**Important:** after the installation, **close all PowerShell and VS Code windows and open them again**. Otherwise the new programs will not be found ("command not recognized").

Check that everything is installed. Each command should print a version number:

```powershell
git --version
php -v
composer --version
bun --version
```

> **macOS / Linux:** install the same tools with your package manager, for example `brew install git php composer oven-sh/bun/bun` on macOS. On Linux use `apt`, `dnf` or similar, and make sure the PHP extensions from step 2 are installed too (for example `php-sqlite3`, `php-mbstring`, `php-curl`, `php-zip`, `php-xml`). Skip step 2 if you installed them this way.

## 2. Enable the required PHP extensions

PHP installed with winget has most extensions turned off. Laravel needs several of them, otherwise `composer install` fails.

**2.1** Find the PHP installation folder and create `php.ini`:

```powershell
php --ini
```

Look at the line `Loaded Configuration File`. If it says `(none)`, create the file from the template. Go to the PHP folder (the folder that contains `php.exe`) and copy the template:

```powershell
$dir = "$env:LOCALAPPDATA\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe"
cd $dir
copy php.ini-development php.ini
notepad php.ini
```

**2.2** In Notepad press `Ctrl+F` and, for each line below, find it and **remove the `;` at the beginning of the line**:

```ini
extension_dir = "ext"
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_sqlite
extension=sqlite3
extension=zip
```

Save the file (`Ctrl+S`).

**2.3** Check that the extensions are active:

```powershell
php -m | findstr /i "curl fileinfo mbstring openssl pdo_sqlite sqlite3 zip"
```

All seven names should appear in the output.

## 3. Clone the project

Choose a folder where you keep projects (for example the Desktop) and clone the repository:

```powershell
cd $HOME\Desktop
git clone https://github.com/stweeeezy1/mm24blog.git
cd mm24blog
code .
```

The last command opens the project in VS Code. You can open the built-in terminal with `` Ctrl+` ``. All following commands are run **in the project root folder** (the folder that contains `artisan`).

## 4. Install dependencies

Install the PHP packages (Laravel and others):

```powershell
composer install
```

Install the JavaScript packages (Vite, Tailwind CSS and others):

```powershell
bun install
```

When finished, the folders `vendor` and `node_modules` should exist in the project.

## 5. Create the `.env` file

The `.env` file holds the settings of your local copy of the project. It is not stored in Git, so you create it from the example file:

```powershell
copy .env.example .env
```

On macOS / Linux use `cp .env.example .env`.

Then generate the application key:

```powershell
php artisan key:generate
```

The project uses SQLite, so no database server and no extra settings are needed. Check that `.env` contains this line:

```ini
DB_CONNECTION=sqlite
```

## 6. Create the database

Create the empty SQLite database file:

```powershell
New-Item -ItemType File -Path database\database.sqlite
```

On macOS / Linux use `touch database/database.sqlite`.

Then create the tables:

```powershell
php artisan migrate
```

If the project has seed data (demo posts), you can add it with:

```powershell
php artisan migrate --seed
```

## 7. Run the project

Start everything with one command:

```powershell
composer run dev
```

This starts the Laravel server and the Vite dev server together. Keep this terminal open while you work.

Open the site in your browser:

**http://127.0.0.1:8000**

To stop the project, press `Ctrl+C` in the terminal.

> Do not open `http://localhost:5173`. That is only the Vite asset server and always shows a placeholder page.

If `composer run dev` does not work on your machine, run the two servers manually in **two separate terminals**:

```powershell
php artisan serve
```

```powershell
bun run dev
```

## 8. Troubleshooting

| Problem | Solution |
|---|---|
| `php` / `composer` / `bun` is not recognized | Close and reopen PowerShell and VS Code. The PATH is updated only in new windows. |
| `composer install` says `ext-fileinfo` (or another extension) is missing | Enable the extension in `php.ini` (step 2) and run `composer install` again. |
| `Database file at path ... does not exist` | Create the file with the command from step 6, then run `php artisan migrate`. |
| `could not find driver` | Enable `pdo_sqlite` and `sqlite3` in `php.ini` (step 2). |
| `Vite manifest not found` | The Vite server is not running. Start it with `composer run dev` or `bun run dev`. For a one-time build use `bun run build`. |
| `No application encryption key has been specified` | Run `php artisan key:generate`. |
| `ERR_CONNECTION_REFUSED` on port 8000 | The Laravel server is not running. Start it with `composer run dev` or `php artisan serve`. |
| Port 8000 is already in use | Run `php artisan serve --port=8001` and open `http://127.0.0.1:8001`. |

## Quick start (for people who already have all programs)

```powershell
git clone https://github.com/stweeeezy1/mm24blog.git
cd mm24blog
composer install
bun install
copy .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database\database.sqlite
php artisan migrate
composer run dev
```

Then open http://127.0.0.1:8000.
