<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

         $permissions = [
                    'role-list',
                    'role-create',
                    'role-edit',
                    'role-delete',
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'location-list',
                    'location-create',
                    'location-edit',
                    'location-delete',
                    'nace-list',
                    'audit-list',
                    'adit-edit',
                    'audit-delete',
                    'audit_create',
                    'audit_access',
                    'role-access',
                    'user-access',
                    'location-access',
                    'nace-access',
                    'firms-access',
                    'firms-create',
                    'firms-list',
                    'firms-delete',
                    'firms-edit'
                 ];

                 foreach ($permissions as $permission) {
                      Permission::create(['name' => $permission]);
                 }
    }
}
