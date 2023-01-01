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
        ];
        Permission::insert($permissions);

        //Admin
        $admin = Role::updateOrCreate(['name' => 'admin'], ['title' => 'Admin']);
        $adminPermissions = Permission::all();
        $admin->permissions()->sync($adminPermissions);

        //Manager
        $manager = Role::updateOrCreate(['name' => 'manager'], ['title' => 'manager']);
        $managerPermissions = Permission::whereIn('group', ['manager'])->get();
        $manager->permissions()->sync($managerPermissions);
    }
}
