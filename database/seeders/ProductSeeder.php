<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Ensure categories exist
        $categories = Category::factory()->count(5)->create();
        
        // Ensure suppliers exist
        $suppliers = Supplier::factory()->count(3)->create();
        
        // Create sample products
        Product::factory()->count(50)->create([
            'category_id' => fn() => $categories->random()->id,
            'supplier_id' => fn() => $suppliers->random()->id,
        ]);
    }
}