# Project Setup Guide

A step-by-step guide to set up and run the project locally.

---

## Steps

1. **Install Composer & PHP 8 or higher**

Ensure you have PHP 8^ and Composer installed on your system.

2. **Clone the repository**

```bash
git clone <repository-url>
cd <repository-folder>
```

3. **Copy environment file**

```bash
cp .env.example .env
```

4. **Update environment variables**

Edit the `.env` file:

```dotenv
DB_HOST=db          # Based on docker-compose.yml
DB_USERNAME=<anything>
DB_PASSWORD=<anything>
```

5. **Install PHP dependencies**

```bash
composer install
```

6. **Build and start Docker containers**

```bash
docker compose up -d --build
```

7. **Access the app container**

```bash
docker compose exec app bash
```

8. **Generate application key**

```bash
php artisan key:generate
```

9. **Run database migrations and seeders**

```bash
php artisan migrate --seed
```

10. **Access the application**

Open your browser and go to: [http://localhost:8003/](http://localhost:8003/)

