<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('password'); // Password default semua akun

        $users = [
            ['name' => 'IT Admin (Superadmin)', 'email' => 'admin@simba.test', 'role' => 'superadmin'],
            ['name' => 'Staff IT (Employee)', 'email' => 'employee@simba.test', 'role' => 'employee'],
            ['name' => 'Head of IT (Approver)', 'email' => 'depthead@simba.test', 'role' => 'dept_head'],
            ['name' => 'Purchasing Officer', 'email' => 'purchasing@simba.test', 'role' => 'purchasing'],
            ['name' => 'Warehouse Staff (Gudang)', 'email' => 'gudang@simba.test', 'role' => 'warehouse_staff'],
            ['name' => 'Warehouse Manager', 'email' => 'supervisor.gudang@simba.test', 'role' => 'warehouse_manager'],
            ['name' => 'Finance Staff', 'email' => 'finance@simba.test', 'role' => 'finance'],
            ['name' => 'Internal Auditor', 'email' => 'auditor@simba.test', 'role' => 'auditor'],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $defaultPassword,
                    'is_active' => true,
                ]
            );

            // Pasangkan role ke user
            $user->syncRoles([$data['role']]);
        }
    }
}
