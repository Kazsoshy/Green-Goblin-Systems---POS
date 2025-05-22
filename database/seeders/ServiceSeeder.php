<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'service_type' => 'PC Repair',
                'description' => 'Basic computer repair and troubleshooting service',
                'price' => 500.00,
            ],
            [
                'service_type' => 'Virus Removal',
                'description' => 'Complete virus and malware removal service',
                'price' => 800.00,
            ],
            [
                'service_type' => 'Data Recovery',
                'description' => 'Recovery of lost or deleted data from storage devices',
                'price' => 1500.00,
            ],
            [
                'service_type' => 'OS Installation',
                'description' => 'Operating system installation and configuration',
                'price' => 1000.00,
            ],
            [
                'service_type' => 'Hardware Upgrade',
                'description' => 'Installation of new hardware components',
                'price' => 300.00,
            ],
            [
                'service_type' => 'Network Setup',
                'description' => 'Home or office network installation and configuration',
                'price' => 1200.00,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
} 