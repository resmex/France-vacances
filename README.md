# France Vacances

France Vacances is a travel and tour booking web application built with Laravel.

It allows users to explore destinations, book tours, and manage travel reservations through a simple and modern interface.

---

## Requirements

Before you begin, make sure you have installed:

- PHP 8.2 or later
- Composer
- Node.js and npm
- MySQL
- Git

---

## Installation

### 1. Clone the project

```bash
git clone https://github.com/resmex/France-vacances.git
```

### 2. Open the project

```bash
cd France-vacances
```

### 3. Install PHP packages

```bash
composer install
```

### 4. Install JavaScript packages

```bash
npm install
```

### 5. Create the environment file

Windows

```bash
copy .env.example .env
```

Linux/macOS

```bash
cp .env.example .env
```

### 6. Generate the application key

```bash
php artisan key:generate
```

### 7. Configure the database

Open the `.env` file and update these values.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=france_vacances
DB_USERNAME=root
DB_PASSWORD=
```

### 8. Run database migrations

```bash
php artisan migrate --seed
```

### 9. Create the storage link

```bash
php artisan storage:link
```

### 10. Start the Laravel server

```bash
php artisan serve
```

### 11. Start Vite

Open another terminal and run:

```bash
npm run dev
```

### 12. Open the application

```
http://127.0.0.1:8000
```

---

## Project Structure

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

## Built With

- Laravel
- PHP
- MySQL
- Blade
- Vite

---

## License

This project is for learning and educational purposes.
