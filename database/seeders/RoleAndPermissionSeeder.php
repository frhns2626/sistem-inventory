<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permissions
        $permissions = [
            'manage users', 'manage departments',
            'view items', 'manage items', 'manage vendors',
            'view purchase-requests', 'create purchase-requests', 'approve purchase-requests',
            'view purchase-orders', 'manage purchase-orders',
            'view material-requisitions', 'create material-requisitions', 'approve material-requisitions',
            'view goods-issues', 'create goods-issues',
            'view goods-receipts', 'create goods-receipts', 'verify goods-receipts',
            'view stock', 'manage stock-opnames', 'approve stock-opnames',
            'view invoices', 'verify invoices', 'manage payments',
            'view audit-logs', 'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 2. Buat 8 Role & Sinkronisasi Hak Akses
        $roles = [
            'superadmin' => $permissions,
            'employee' => ['view items', 'view material-requisitions', 'create material-requisitions', 'view purchase-requests', 'create purchase-requests'],
            'dept_head' => ['view items', 'view material-requisitions', 'create material-requisitions', 'approve material-requisitions', 'view purchase-requests', 'create purchase-requests', 'approve purchase-requests'],
            'purchasing' => ['view items', 'manage vendors', 'view purchase-requests', 'view purchase-orders', 'manage purchase-orders', 'view goods-receipts'],
            'warehouse_staff' => ['view items', 'manage items', 'view stock', 'view purchase-orders', 'view goods-receipts', 'create goods-receipts', 'view material-requisitions', 'view goods-issues', 'create goods-issues', 'manage stock-opnames'],
            'warehouse_manager' => ['view items', 'manage items', 'view stock', 'verify goods-receipts', 'view goods-issues', 'approve stock-opnames', 'view reports'],
            'finance' => ['view purchase-orders', 'view goods-receipts', 'view invoices', 'verify invoices', 'manage payments', 'view reports'],
            'auditor' => ['view items', 'view stock', 'view purchase-requests', 'view purchase-orders', 'view goods-receipts', 'view material-requisitions', 'view goods-issues', 'view invoices', 'view audit-logs', 'view reports'],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }
    }
}
