# The Next Holiday

A Laravel application that displays upcoming public and school holidays using the [OpenHolidays API](https://openholidaysapi.org).

## Features

- View upcoming public holidays by country
- View school holidays by country and region
- Multi-language support (English, Spanish, German)
- Interactive web interface with country/region selection
- RESTful API for holiday data

## Requirements

- PHP ^8.2
- Composer
- Node.js & NPM
- Docker & Docker Compose (for Laravel Sail)

## Installation

### Using Laravel Sail (Docker)

1. Clone the repository

2. Install dependencies and initialize:
```bash
make install
```

This will:
- Install Composer dependencies (if not already installed)
- Start Docker containers
- Reset database with migrations and seeders
- Run tests
- Populate holidays data

### Manual Installation

1. Clone the repository

2. Install dependencies:
```bash
composer install
npm install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Start the application:
```bash
composer dev
```

This starts the Laravel server, queue worker, logs viewer, and Vite dev server concurrently.

## Make Commands

The project includes a Makefile for common tasks using Laravel Sail:

```bash
make up                    # Start Docker containers
make down                  # Stop Docker containers
make db-reset              # Reset database with fresh migrations and seeds
make clear-cache           # Clear all Laravel caches
make test                  # Run tests with coverage
make test-specific filter=test_name  # Run specific test
make install               # Full installation (composer + init)
make init                  # Initialize project (down, db-reset, test)
```

## Testing

Run all tests with coverage:
```bash
make test
```

Run specific test:
```bash
make test-specific filter=test_can_get_public_holidays
```

Without Make:
```bash
composer test
php artisan test tests/Feature/Http/Controllers/GetPublicHolidayControllerTest.php
```

## Code Style

Fix code style issues:
```bash
./vendor/bin/pint
```

Check style without fixing:
```bash
./vendor/bin/pint --test
```

## API Endpoints

- `GET /api/holidays/public` - Get public holidays
- `GET /api/holidays/school` - Get school holidays
- `GET /api/countries` - List available countries
- `GET /api/subdivisions` - List subdivisions/regions for a country

### Query Parameters

**Holidays endpoints:**
- `countryIsoCode` (required) - ISO country code (e.g., "DE", "US")
- `languageIsoCode` (required) - ISO language code (e.g., "EN", "ES", "DE")
- `subdivisionCode` (optional for public, often required for school) - Region code
- `validFrom` (required) - Start date (YYYY-MM-DD)
- `validTo` (required) - End date (YYYY-MM-DD)

**Countries endpoint:**
- `languageIsoCode` (optional) - Localize country names

**Subdivisions endpoint:**
- `countryIsoCode` (required) - Country to get subdivisions for
- `languageIsoCode` (optional) - Localize subdivision names

## Architecture

The application uses a Repository pattern to abstract data fetching from the OpenHolidays API:

- **Service Layer** (`OpenHolidaysApiService`) - Handles HTTP requests to external API
- **Repository Layer** - Business logic and data transformation
- **Controllers** - Single-action controllers for API endpoints
- **Form Requests** - Validation for all API requests

See [CLAUDE.md](CLAUDE.md) for detailed architecture documentation.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
