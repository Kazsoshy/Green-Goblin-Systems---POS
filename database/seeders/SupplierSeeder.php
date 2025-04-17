<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create([
            'name' => 'Tech Corp',
            'contact_person' => 'John Doe',
            'email' => 'john@techcorp.com',
            'phone' => '09123456789',
            'address' => '123 Tech Street'
        ]);

        Supplier::create([
            'name' => 'CompuWorld',
            'contact_person' => 'Jane Smith',
            'email' => 'jane@compuworld.com',
            'phone' => '09987654321',
            'address' => '456 Gadget Avenue'
        ]);
    }
}
