# HLI Green Power Website

A modern web application built with **Laravel**, **Vue**, **Tailwind CSS**, and **PostgreSQL** — designed for HLI Green Power's website and management system.

---

## ⚙️ Requirements

- PHP ^8.2
- Composer
- Node.js ^18
- PostgreSQL
- Nginx (recommended)
- Git

---

## 🚀 Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/hli-green-power.git
cd hli-green-power
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Setup Environment

Copy example environment file:

```bash
cp .env.example .env
```

Edit `.env` with server credentials:

```dotenv
APP_NAME="HLI Green Power"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://example.com

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hligreen_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Generate application key:

```bash
php artisan key:generate
```

---

## 🧩 Database Setup

Run migrations (and seeders if available):

```bash
php artisan migrate --force
# Optional:
# php artisan db:seed --force
```

---

## 🧱 Build Frontend Assets

For production build:

```bash
npm run build
```

---

## ⚡ Deployment Steps (for Server Admin)

1. **Pull latest code**
   ```bash
   git pull origin main
   ```

2. **Install PHP dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Install and build frontend**
   ```bash
   npm ci && npm run build
   ```

4. **Run migrations**
   ```bash
   php artisan migrate --force
   ```

5. **Set permissions**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

6. **Optimize application**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🌐 Nginx Configuration Example

Add this to your Nginx site config (adjust paths as needed):

```nginx
server {
    listen 80;
    server_name example.com;
    root /var/www/hli-green-power/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Reload Nginx:
```bash
sudo systemctl reload nginx
```

---

## 🧰 Useful Artisan Commands

| Command | Description |
|----------|--------------|
| `php artisan serve` | Run local server |
| `php artisan migrate` | Run database migrations |
| `php artisan tinker` | Open interactive shell |
| `php artisan optimize:clear` | Clear cache |
| `php artisan config:cache` | Cache configuration |

---

## 🧾 Deployment Script (Optional)

You can also run automated deployment using the provided `deploy.sh` script.

```bash
bash deploy.sh
```

---

## 👤 Maintainer

**HLI Green Power Development Team**  
Contact: [andrealifridho@innocean.co.id]
