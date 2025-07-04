# Laravel Ecommerce Modular API

> A comprehensive, modular e-commerce API built with Laravel 10, featuring advanced functionalities for modern online shopping platforms.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![API Version](https://img.shields.io/badge/API-v1.0-orange.svg)](#)

## 📋 Table of Contents

- [✨ Features](#-features)
- [🛠️ Tech Stack](#️-tech-stack)
- [📁 Project Structure](#-project-structure)
- [⚙️ Installation](#️-installation)
- [🔧 Configuration](#-configuration)
- [🚀 Usage](#-usage)
- [📖 API Documentation](#-api-documentation)


## ✨ Features

### Core Functionality
- 🛒 **Complete Shopping Cart System** - Add, update, remove items with session management
- 👤 **User Management** - Registration, authentication, profile management
- 🏷️ **Product Catalog** - Categories, brands, items with advanced filtering
- 📦 **Order Management** - Complete order lifecycle from cart to delivery
- 💳 **Payment Integration** - Multiple payment gateway support
- ⭐ **Review System** - Product ratings and reviews
- 🌍 **Multi-language Support** - Internationalization ready
- 👨‍💼 **Admin Panel** - Comprehensive administrative interface

### Technical Features
- 🔐 **JWT Authentication** - Secure API authentication
- 🏗️ **Modular Architecture** - Clean, maintainable codebase
- 📱 **RESTful API** - Well-structured API endpoints
- 🔍 **Advanced Filtering** - Eloquent-based filtering system
- 📂 **File Management** - AWS S3 integration for media storage
- 🌐 **Localization** - Multi-language content support
- 📊 **Repository Pattern** - Clean data access layer
- 🔧 **SEO Friendly** - Automatic slug generation

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Authentication**: JWT Auth, Laravel Sanctum
- **Database**: MySQL/PostgreSQL
- **File Storage**: AWS S3 (League Flysystem)

### Key Packages
- **nwidart/laravel-modules** - Modular application structure
- **tymon/jwt-auth** - JWT authentication for APIs
- **intervention/image** - Image processing and manipulation
- **mcamara/laravel-localization** - Localization support
- **tucker-eric/eloquentfilter** - Advanced Eloquent filtering
- **prettus/l5-repository** - Repository pattern implementation
- **cviebrock/eloquent-sluggable** - Automatic slug generation

### Development Tools
- **PHPUnit** - Testing framework
- **Laravel Pint** - Code style fixer
- **Laravel Sail** - Docker development environment
- **Faker** - Test data generation

## 📁 Project Structure

```
laravel-ecommerce-api/
├── Modules/                    # Modular components
│   ├── Admin/                 # Administrative functionality
│   ├── Area/                  # Geographic areas management
│   ├── Brand/                 # Brand management
│   ├── Cart/                  # Shopping cart functionality
│   ├── Category/              # Product categories
│   ├── Item/                  # Product items
│   ├── Order/                 # Order management
│   ├── Payment/               # Payment processing
│   ├── Review/                # Review and rating system
│   └── User/                  # User management
├── app/                       # Core application
├── config/                    # Configuration files
├── database/                  # Migrations and seeders
├── routes/                    # API routes
└── storage/                   # File storage
```

## ⚙️ Installation

### Prerequisites
- PHP 8.1 or higher
- Composer 2.x
- MySQL 5.7+ or PostgreSQL 9.6+
- Node.js 16+ (for asset compilation)

### Step-by-Step Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/laravel-ecommerce-api.git
   cd laravel-ecommerce-api
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   ```bash
   # Edit .env file with your database credentials
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_ecommerce
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan module:migrate --seed
   ```

7. **Generate JWT secret**
   ```bash
   php artisan jwt:secret
   ```

8. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

Your API will be available at `http://localhost:8000`

## 🔧 Configuration

### Environment Variables

Create a `.env` file based on `.env.example` and configure the following:

```env
# Application
APP_NAME="Laravel Online Shopping System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password

# JWT Configuration
JWT_SECRET=your_jwt_secret_key
JWT_TTL=60

# AWS S3 (for file storage)
AWS_ACCESS_KEY_ID=your_aws_access_key
AWS_SECRET_ACCESS_KEY=your_aws_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-s3-bucket

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password

# Localization
DEFAULT_LOCALE=en
AVAILABLE_LOCALES=en,ar
```

### Module Configuration

Each module has its own configuration files located in `Modules/{ModuleName}/config/`. You can customize:

- Access Control Lists (ACL)
- Module-specific settings
- API rate limiting
- Validation rules



### API Endpoints

#### Public Endpoints
- `GET /api/categories` - List all categories
- `GET /api/brands` - List all brands
- `GET /api/items` - List products with filtering
- `GET /api/items/{id}` - Get product details

#### Protected Endpoints
- `GET /api/user/profile` - Get user profile
- `POST /api/cart/add` - Add item to cart
- `GET /api/cart` - Get cart contents
- `POST /api/orders` - Create new order
- `GET /api/orders` - Get user orders

#### Admin Endpoints
- `GET /admin-api/users` - Manage users
- `POST /admin-api/categories` - Create categories
- `PUT /admin-api/items/{id}` - Update products

## 📖 API Documentation

### Response Format

All API responses follow a consistent format:

```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": {
    // Response data here
  },
  "meta": {
    "pagination": {
      "current_page": 1,
      "total_pages": 10,
      "per_page": 15,
      "total": 150
    }
  }
}
```

### Error Handling

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```



