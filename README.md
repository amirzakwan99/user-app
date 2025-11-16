# Project Setup Guide

![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![Composer](https://img.shields.io/badge/Composer-Installed-brightgreen)
![Git](https://img.shields.io/badge/Git-Installed-orange)
![Docker](https://img.shields.io/badge/Docker-Required-blueviolet)
![Docker Compose](https://img.shields.io/badge/Docker%20Compose-Required-lightgrey)

A step-by-step guide to set up and run the project locally.

---

## Table of Contents

* [Prerequisites](#prerequisites)
* [Installation](#installation)
* [Environment Setup](#environment-setup)
* [Running the Application](#running-the-application)
* [Accessing the App](#accessing-the-app)

---

## Prerequisites

Before starting, ensure you have the following installed:

* PHP 8 or higher
* Composer
* Git
* Docker & Docker Compose

---

## Steps

1. **Install PHP 8^, Composer, Git, Docker & Docker Compose**

Ensure you have all required tools installed on your system.

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

---

## API Endpoints

| Method    | Endpoint              | Description                                                  |
| --------- | --------------------- | ------------------------------------------------------------ |
| GET       | `/users`              | List all users (supports AJAX with optional `status` filter) |
| GET       | `/users/create`       | Show form to create a new user                               |
| POST      | `/users`              | Store a new user                                             |
| GET       | `/users/{id}`         | Display a specific user (not used)                           |
| GET       | `/users/{id}/edit`    | Show form to edit an existing user                           |
| PUT/PATCH | `/users/{id}`         | Update an existing user                                      |
| DELETE    | `/users/{id}`         | Soft delete a user                                           |
| POST      | `/users/destroy-bulk` | Soft delete multiple users by IDs                            |
| GET       | `/users/export`       | Export users to Excel file                                   |

---
