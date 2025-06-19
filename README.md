# Products API

A Laravel-based RESTful API for managing products and their prices in various currencies.

## Overview

This API provides comprehensive endpoints for managing products in an e-commerce system. It allows storing product information along with pricing in multiple currencies.

## Features

- Product management (CRUD operations)
- Multiple currency support for product prices
- Authentication using Laravel Sanctum
- API resource versioning
- Comprehensive validation
- Detailed error handling

## Technical Stack

- PHP 8.2+
- Laravel 12.x
- MySQL/SQLite for database
- Laravel Sanctum for API authentication

## API Endpoints

### Products

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | List all products (paginated) |
| POST | `/api/products` | Create a new product |
| GET | `/api/products/{id}` | Get a specific product |
| PUT/PATCH | `/api/products/{id}` | Update a product |
| DELETE | `/api/products/{id}` | Delete a product |

### Product Prices

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products/{id}/prices` | Get all prices for a product |
| POST | `/api/products/{id}/prices` | Add a new price for a product |

## Data Models

### Product
- name: string
- description: string (optional)
- price: decimal (base price)
- currency_id: int (reference to currency)
- tax_cost: decimal
- manufacturing_cost: decimal

### Price
- product_id: int (reference to product)
- price: decimal
- currency_id: int (reference to currency)

### Currency
- name: string
- symbol: string (e.g., $)
- exchange_rate: decimal

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/products-api.git
cd products-api
```

2. Install dependencies:
```bash
composer install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`

5. Run migrations and seeders:
```bash
php artisan migrate --seed
```

6. Start the server:
```bash
php artisan serve
```

## Development

This project uses several quality tools to maintain code standards:

- **PHPStan/Larastan**: For static analysis
- **Laravel Pint**: For code style enforcement
- **Pest PHP**: For testing

Run tests with:
```bash
  composer run test
```

## Author

Franklin Gonzalez
