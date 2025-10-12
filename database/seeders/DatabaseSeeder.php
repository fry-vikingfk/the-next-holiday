<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update default admin user from environment variables
        $adminPassword = config('app.admin_password');

        if (empty($adminPassword)) {
            $this->command->warn('ADMIN_PASSWORD not set in .env file. Skipping admin user creation.');
            $this->command->warn('Please set ADMIN_PASSWORD in your .env file and re-run: php artisan db:seed');
        } else {
            $adminEmail = config('app.admin_email', 'admin@example.com');

            $admin = User::updateOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => config('app.admin_name', 'Admin User'),
                    'password' => bcrypt($adminPassword),
                    'is_admin' => true,
                ]
            );

            $this->command->info("Admin user ready: {$admin->email}");
        }

        $this->call([
            HolidaySeeder::class,
        ]);
    }
}
