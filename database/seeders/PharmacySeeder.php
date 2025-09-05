<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create two sample pharmacies
        $pharmacies = [
            [
                'name' => 'Pharmacy One',
                'db_name' => 'pharmacy_one',
                'db_user' => 'pharmacy_one_user',
                'db_password' => 'pharmacy1_pass',
                'admin_email' => 'admin@pharmacyone.com',
                'admin_password' => 'password123',
            ],
            [
                'name' => 'Pharmacy Two',
                'db_name' => 'pharmacy_two',
                'db_user' => 'pharmacy_two_user',
                'db_password' => 'pharmacy2_pass',
                'admin_email' => 'admin@pharmacytwo.com',
                'admin_password' => 'password123',
            ]
        ];

        foreach ($pharmacies as $data) {
            $pharmacy = Pharmacy::firstOrCreate(
                ['name' => $data['name']],
                [
                    'db_name' => $data['db_name'],
                    'db_user' => $data['db_user'],
                    'db_password' => Hash::make($data['db_password']),
                    'admin_email' => $data['admin_email'],
                    'admin_password' => Hash::make($data['admin_password']),
                ]
            );

            // 4. Create physical database (if not exists)
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$pharmacy->db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            // 5. Configure tenant DB connection on the fly
            config([
                'database.connections.tenant' => [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => $pharmacy->db_name,
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                ],
            ]);

            // 6. Run tenant migrations
            // Artisan::call('migrate', [
            //     '--database' => 'tenant',
            //     '--path' => '/database/migrations/tenant',
            //     '--force' => true,
            // ]);
        }
    }
}
