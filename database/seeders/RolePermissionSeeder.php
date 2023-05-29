<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $employeeRole = Role::create(['name' => 'employee']);
        $customerRole = Role::create(['name' => 'customer']);

        // Permissions
        $createTicketPermission = Permission::create(['name' => 'create ticket']);
        $viewOwnTicketPermission = Permission::create(['name' => 'view own ticket']);
        $viewAssignedTicketPermission = Permission::create(['name' => 'view assigned ticket']);
        $viewAllTicketPermission = Permission::create(['name' => 'view all ticket']);
        $updateOwnTicketPermission = Permission::create(['name' => 'update own ticket']);
        $updateAssignedTicketPermission = Permission::create(['name' => 'update assigned ticket']);
        $deleteOwnTicketPermission = Permission::create(['name' => 'delete own ticket']);
        $deleteAssignedTicketPermission = Permission::create(['name' => 'delete assigned ticket']);
        $manageUsersPermission = Permission::create(['name' => 'manage users']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            $createTicketPermission,
            $viewAllTicketPermission,
            $updateAssignedTicketPermission,
            $deleteAssignedTicketPermission,
            $manageUsersPermission,
        ]);

        $employeeRole->givePermissionTo([
            $createTicketPermission,
            $viewOwnTicketPermission,
            $viewAssignedTicketPermission,
            $updateOwnTicketPermission,
            $updateAssignedTicketPermission,
            $deleteOwnTicketPermission,
            $deleteAssignedTicketPermission,
        ]);

        $customerRole->givePermissionTo([
            $createTicketPermission,
            $viewOwnTicketPermission,
            $updateOwnTicketPermission,
            $deleteOwnTicketPermission,
        ]);
    }
}
