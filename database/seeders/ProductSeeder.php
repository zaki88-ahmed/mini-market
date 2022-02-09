<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use modules\Products\Models\Product;
use modules\Vendors\Models\Customer;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::create([
            'title' => 'T-Shirt',
            'price' => 200,
        ]);

        Product::create([
            'title' => 'Shoes',
            'price' => 150,
        ]);
    }
}
