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

        // Use default password for local/testing environments if not set
        if (empty($adminPassword)) {
            if (app()->environment(['local', 'testing'])) {
                $adminPassword = 'password'; // Default for local development
                $this->command->warn('ADMIN_PASSWORD not set - using default "password" for local environment');
            } else {
                $this->command->warn('ADMIN_PASSWORD not set in .env file. Skipping admin user creation.');
                $this->command->warn('Please set ADMIN_PASSWORD in your .env file and re-run: php artisan db:seed');

                $this->call([
                    HolidaySeeder::class,
                ]);

                return;
            }
        }

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

        $this->call([
            HolidaySeeder::class,
        ]);
    }
}
