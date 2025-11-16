# Project Name

![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![Composer](https://img.shields.io/badge/Composer-Installed-brightgreen)
![Docker](https://img.shields.io/badge/Docker-Required-blueviolet)

A brief description of your project goes here.

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Environment Setup](#environment-setup)
- [Running the Application](#running-the-application)
- [Accessing the App](#accessing-the-app)

---

## Prerequisites

Before starting, ensure you have the following installed:

- PHP 8 or higher
- Composer
- Docker & Docker Compose
- Git

---

## Installation

1. **Clone the repository**

```bash
git clone <repository-url>
cd <repository-folder>
```

2. **Install PHP dependencies**

```bash
composer install
```

---

## Environment Setup

1. **Create the environment file**

```bash
cp .env.example .env
```

2. **Update the environment variables in `.env`**

```dotenv
DB_HOST=db            # Match your docker-compose.yml service name
DB_USERNAME=<your-db-username>
DB_PASSWORD=<your-db-password>
```

---

## Running the Application

1. **Build and start Docker containers**

```bash
docker compose up -d --build
```

2. **Enter the app container**

```bash
docker compose exec app bash
```

3. **Generate application key**

```bash
php artisan key:generate
```

4. **Run database migrations and seeders**

```bash
php artisan migrate --seed
```

---

## Accessing the App

Open your browser and visit:

[http://localhost:8003/](http://localhost:8003/)

---

## Notes

- Ensure the `DB_HOST` in `.env` matches the database service name in your `docker-compose.yml`.
- You can customize `DB_USERNAME` and `DB_PASSWORD` as needed.

