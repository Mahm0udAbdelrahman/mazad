<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users-index','users-show','users-create','users-update','users-delete',
            'roles-index','roles-show','roles-create','roles-update','roles-delete',
            'vendors-index','vendors-show','vendors-create','vendors-update','vendors-delete',
            'merchant-index','merchant-show','merchant-create','merchant-update','merchant-delete',
            'notifications-index','notifications-show','notifications-create','notifications-update','notifications-delete',
            'privacy_policy-update',
            'send_notifications-index','send_notifications-show','send_notifications-create','send_notifications-update','send_notifications-delete',
            'car-index','car-show','car-create','car-update','car-delete',
            'categories-index','categories-show','categories-create','categories-update','categories-delete',
            'maintenance_centers-index','maintenance_centers-show','maintenance_centers-create','maintenance_centers-update','maintenance_centers-delete',
            'countries-index','countries-show','countries-create','countries-update','countries-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
