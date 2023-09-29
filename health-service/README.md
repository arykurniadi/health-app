# Health Service

## Requirements

This project is developed with:

- PHP 7.2
- MySQL
- Phalcon

## Installation

Clone the project

Go to the project directory

This service contains a `.env.example` file that defines environment variables you need to set. Copy and set the variables to a new `.env` file.

```bash
cp .env.example .env
```

Install the app

```bash
composer install
```

## Database

Please import database.

## Testing

Test the service

```bash
cd tests && ../vendor/bin/phpunit
```