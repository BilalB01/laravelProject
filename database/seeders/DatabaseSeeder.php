<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => bcrypt('Password!321'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create profile for admin
        $admin->profile()->create([
            'username' => 'admin',
            'about_me' => 'Default admin account for the recepten website.',
        ]);

        // Seed FAQ data
        $this->call(FaqSeeder::class);
    }
}
