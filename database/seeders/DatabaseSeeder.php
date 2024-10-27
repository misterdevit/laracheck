<?php

namespace Database\Seeders;

use App\Models\Bug;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Outage;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        if (config('app.env') === 'local') {
            Site::factory(25)->create();
            Bug::factory(100)->create();
            Outage::factory(50)->create();
        }
    }
}
