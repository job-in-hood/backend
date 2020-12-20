<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultRolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Company Roles
        $role = Role::firstOrCreate([
            'name' => 'Company Administrator'
        ]);

        $companyPermissions = [
            'company-update', 'company-delete',
            'job-create', 'job-edit', 'job-delete', 'job-publish'
        ];

        foreach ($companyPermissions as $companyPermission) {
            $permission = Permission::firstOrCreate([
                'name' => $companyPermission
            ]);

            $role->givePermissionTo($permission);
        }
    }
}
