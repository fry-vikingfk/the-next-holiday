# Admin User Setup

This application includes a default admin user seeder that creates an admin account during database seeding.

## Configuration

The admin user credentials are configured via environment variables in your `.env` file:

```env
ADMIN_NAME="Admin User"
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=your-secure-password-here
```

## Setup Instructions

### 1. Set Environment Variables

Add the following to your `.env` file:

```bash
# Admin User Configuration
ADMIN_NAME="Your Name"
ADMIN_EMAIL=your-email@example.com
ADMIN_PASSWORD=your-secure-password
```

**Important:** Use a strong password in production!

### 2. Run Database Seeding

```bash
# Using make
make db-reset

# Or directly with Sail
./vendor/bin/sail artisan migrate:fresh --seed
```

The seeder will:
- Create a new admin user if one doesn't exist
- Update the existing admin user if the email already exists
- Display a confirmation message

### 3. Verify Admin User

The admin user will have:
- `is_admin` = `true`
- Full access to all API endpoints
- Ability to create, update, and delete resources

## Production Deployment

For production environments (GitHub Actions, Docker, etc.):

1. **Set as secrets/environment variables** in your deployment system:
   - `ADMIN_EMAIL`
   - `ADMIN_PASSWORD`

2. **GitHub Actions Example:**
   ```yaml
   - name: Seed Database
     env:
       ADMIN_EMAIL: ${{ secrets.ADMIN_EMAIL }}
       ADMIN_PASSWORD: ${{ secrets.ADMIN_PASSWORD }}
     run: php artisan db:seed
   ```

3. **Docker/Docker Compose:**
   ```yaml
   environment:
     - ADMIN_EMAIL=${ADMIN_EMAIL}
     - ADMIN_PASSWORD=${ADMIN_PASSWORD}
   ```

## Security Notes

- ⚠️ **Never commit** `.env` files with real passwords
- ⚠️ **Always use strong passwords** for production
- ⚠️ The seeder will **skip** admin creation if `ADMIN_PASSWORD` is not set
- ✅ The seeder uses `updateOrCreate`, so it's safe to run multiple times

## Manual Admin Creation

If you prefer to create an admin manually:

```bash
./vendor/bin/sail artisan tinker
```

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('your-password'),
    'is_admin' => true,
]);
```

## Troubleshooting

**Problem:** "ADMIN_PASSWORD not set in .env file"
- **Solution:** Add `ADMIN_PASSWORD=your-password` to your `.env` file

**Problem:** Admin user exists but password doesn't work
- **Solution:** Re-run seeder with updated password: `php artisan db:seed --class=DatabaseSeeder`
