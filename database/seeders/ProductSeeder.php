<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Product::create([
        'name' => 'Ehms queue system',
        'description' => 'system to manage patient awainting for services ',
        'price' => 5000.00,
    ]);

    Product::create([
        'name' => 'Lis management system',
        'description' => 'System to manage lab integration',
        'price' => 3000.00,
    ]);
    }
}


