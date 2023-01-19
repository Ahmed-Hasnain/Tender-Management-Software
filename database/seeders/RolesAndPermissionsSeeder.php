<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    protected $toTruncate = [
        'role_has_permissions',
        'permissions'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        foreach($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        Schema::enableForeignKeyConstraints();

        $permissions = [
            // administrators 
            ['group' => 'administrators', 'name' => 'view_administrators', 'title' => 'View administrators', 'guard_name' => 'web'],
            ['group' => 'administrators', 'name' => 'add_administrators', 'title' => 'Add administrators', 'guard_name' => 'web'],
            ['group' => 'administrators', 'name' => 'edit_administrators', 'title' => 'Edit administrators', 'guard_name' => 'web'],
            ['group' => 'administrators', 'name' => 'delete_administrators', 'title' => 'Delete administrators', 'guard_name' => 'web'],

            // manager 
            ['group' => 'manager', 'name' => 'view_manager', 'title' => 'View Manager', 'guard_name' => 'web'],
            ['group' => 'manager', 'name' => 'add_manager', 'title' => 'Add Manager', 'guard_name' => 'web'],
            ['group' => 'manager', 'name' => 'edit_manager', 'title' => 'Edit Manager', 'guard_name' => 'web'],
            ['group' => 'manager', 'name' => 'delete_manager', 'title' => 'Delete Manager', 'guard_name' => 'web'],

            // user 
            ['group' => 'user', 'name' => 'view_user', 'title' => 'View User', 'guard_name' => 'web'],
            ['group' => 'user', 'name' => 'add_user', 'title' => 'Add User', 'guard_name' => 'web'],
            ['group' => 'user', 'name' => 'edit_user', 'title' => 'Edit User', 'guard_name' => 'web'],
            ['group' => 'user', 'name' => 'delete_user', 'title' => 'Delete User', 'guard_name' => 'web'],

            // category 
            ['group' => 'category', 'name' => 'view_category', 'title' => 'View category', 'guard_name' => 'web'],
            ['group' => 'category', 'name' => 'add_category', 'title' => 'Add category', 'guard_name' => 'web'],
            ['group' => 'category', 'name' => 'edit_category', 'title' => 'Edit category', 'guard_name' => 'web'],
            ['group' => 'category', 'name' => 'delete_category', 'title' => 'Delete category', 'guard_name' => 'web'],

            // item 
            ['group' => 'item', 'name' => 'view_item', 'title' => 'View item', 'guard_name' => 'web'],
            ['group' => 'item', 'name' => 'add_item', 'title' => 'Add item', 'guard_name' => 'web'],
            ['group' => 'item', 'name' => 'edit_item', 'title' => 'Edit item', 'guard_name' => 'web'],
            ['group' => 'item', 'name' => 'delete_item', 'title' => 'Delete item', 'guard_name' => 'web'],
        ];
        Permission::insert($permissions);

        //Admin
        $admin = Role::updateOrCreate(['name' => 'admin'], ['title' => 'Admin']);
        $adminPermissions = Permission::all();
        $admin->permissions()->sync($adminPermissions);

        //Manager
        $manager = Role::updateOrCreate(['name' => 'manager'], ['title' => 'manager']);
        $managerPermissions = Permission::whereIn('name', ['view_user', 'view_category', 'view_item'])->get();
        $manager->permissions()->sync($managerPermissions);
    }
}
