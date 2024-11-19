<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Akmal Fadli',
            'email' => 'fadli@perwirateknologi.com',
            'password' => Hash::make('12345678'),
        ]);

        //category factory 2
        Category::factory(2)->create();

    }
}
