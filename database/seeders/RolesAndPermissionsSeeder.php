<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Create roles
       $adminRole = Role::create(['name' => 'admin']);
       $userRole = Role::create(['name' => 'user']);

       // Create permissions
       $editProductsPermission = Permission::create(['name' => 'edit products']);
       $deleteProductsPermission = Permission::create(['name' => 'delete products']);

       // Assign permissions to roles
       $adminRole->givePermissionTo($editProductsPermission, $deleteProductsPermission);

    }
}
