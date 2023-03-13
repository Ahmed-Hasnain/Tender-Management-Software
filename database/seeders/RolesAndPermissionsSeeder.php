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

            // mode of payment
            ['group' => 'mode_of_payment', 'name' => 'view_mode_of_payment', 'title' => 'View mode of payment', 'guard_name' => 'web'],
            ['group' => 'mode_of_payment', 'name' => 'add_mode_of_payment', 'title' => 'Add mode of payment', 'guard_name' => 'web'],
            ['group' => 'mode_of_payment', 'name' => 'edit_mode_of_payment', 'title' => 'Edit mode of payment', 'guard_name' => 'web'],
            ['group' => 'mode_of_payment', 'name' => 'delete_mode_of_payment', 'title' => 'Delete mode of payment', 'guard_name' => 'web'],

            // demand
            ['group' => 'demand', 'name' => 'view_demand', 'title' => 'View demand', 'guard_name' => 'web'],
            ['group' => 'demand', 'name' => 'add_demand', 'title' => 'Add demand', 'guard_name' => 'web'],
            ['group' => 'demand', 'name' => 'edit_demand', 'title' => 'Edit demand', 'guard_name' => 'web'],
            ['group' => 'demand', 'name' => 'delete_demand', 'title' => 'Delete demand', 'guard_name' => 'web'],

            // unit
            ['group' => 'unit', 'name' => 'view_unit', 'title' => 'View unit', 'guard_name' => 'web'],
            ['group' => 'unit', 'name' => 'add_unit', 'title' => 'Add unit', 'guard_name' => 'web'],
            ['group' => 'unit', 'name' => 'edit_unit', 'title' => 'Edit unit', 'guard_name' => 'web'],
            ['group' => 'unit', 'name' => 'delete_unit', 'title' => 'Delete unit', 'guard_name' => 'web'],

            // supplier
            ['group' => 'supplier', 'name' => 'view_supplier', 'title' => 'View supplier', 'guard_name' => 'web'],
            ['group' => 'supplier', 'name' => 'add_supplier', 'title' => 'Add supplier', 'guard_name' => 'web'],
            ['group' => 'supplier', 'name' => 'edit_supplier', 'title' => 'Edit supplier', 'guard_name' => 'web'],
            ['group' => 'supplier', 'name' => 'delete_supplier', 'title' => 'Delete supplier', 'guard_name' => 'web'],

            // client
            ['group' => 'client', 'name' => 'view_client', 'title' => 'View client', 'guard_name' => 'web'],
            ['group' => 'client', 'name' => 'add_client', 'title' => 'Add client', 'guard_name' => 'web'],
            ['group' => 'client', 'name' => 'edit_client', 'title' => 'Edit client', 'guard_name' => 'web'],
            ['group' => 'client', 'name' => 'delete_client', 'title' => 'Delete client', 'guard_name' => 'web'],

            // person
            ['group' => 'person', 'name' => 'view_person', 'title' => 'View person', 'guard_name' => 'web'],
            ['group' => 'person', 'name' => 'add_person', 'title' => 'Add person', 'guard_name' => 'web'],
            ['group' => 'person', 'name' => 'edit_person', 'title' => 'Edit person', 'guard_name' => 'web'],
            ['group' => 'person', 'name' => 'delete_person', 'title' => 'Delete person', 'guard_name' => 'web'],

            // tender
            ['group' => 'tender', 'name' => 'view_tender', 'title' => 'View tender', 'guard_name' => 'web'],
            ['group' => 'tender', 'name' => 'add_tender', 'title' => 'Add tender', 'guard_name' => 'web'],
            ['group' => 'tender', 'name' => 'edit_tender', 'title' => 'Edit tender', 'guard_name' => 'web'],
            ['group' => 'tender', 'name' => 'delete_tender', 'title' => 'Delete tender', 'guard_name' => 'web'],

            // quotation
            ['group' => 'quotation', 'name' => 'view_quotation', 'title' => 'View quotation', 'guard_name' => 'web'],
            ['group' => 'quotation', 'name' => 'add_quotation', 'title' => 'Add quotation', 'guard_name' => 'web'],
            ['group' => 'quotation', 'name' => 'edit_quotation', 'title' => 'Edit quotation', 'guard_name' => 'web'],
            ['group' => 'quotation', 'name' => 'delete_quotation', 'title' => 'Delete quotation', 'guard_name' => 'web'],

            // company
            ['group' => 'company', 'name' => 'view_company', 'title' => 'View company', 'guard_name' => 'web'],
            ['group' => 'company', 'name' => 'add_company', 'title' => 'Add company', 'guard_name' => 'web'],
            ['group' => 'company', 'name' => 'edit_company', 'title' => 'Edit company', 'guard_name' => 'web'],
            ['group' => 'company', 'name' => 'delete_company', 'title' => 'Delete company', 'guard_name' => 'web'],

            // currency
            ['group' => 'currency', 'name' => 'view_currency', 'title' => 'View currency', 'guard_name' => 'web'],
            ['group' => 'currency', 'name' => 'add_currency', 'title' => 'Add currency', 'guard_name' => 'web'],
            ['group' => 'currency', 'name' => 'edit_currency', 'title' => 'Edit currency', 'guard_name' => 'web'],
            ['group' => 'currency', 'name' => 'delete_currency', 'title' => 'Delete currency', 'guard_name' => 'web'],

            // supply order
            ['group' => 'supply order', 'name' => 'view_supply_order', 'title' => 'View supply order', 'guard_name' => 'web'],
            ['group' => 'supply order', 'name' => 'add_supply_order', 'title' => 'Add supply order', 'guard_name' => 'web'],
            ['group' => 'supply order', 'name' => 'edit_supply_order', 'title' => 'Edit supply order', 'guard_name' => 'web'],
            ['group' => 'supply order', 'name' => 'delete_supply_order', 'title' => 'Delete supply order', 'guard_name' => 'web'],

            // delivery challan
            ['group' => 'delivery challan', 'name' => 'view_delivery_challan', 'title' => 'View delivery challan', 'guard_name' => 'web'],
            ['group' => 'delivery challan', 'name' => 'add_delivery_challan', 'title' => 'Add delivery challan', 'guard_name' => 'web'],
            ['group' => 'delivery challan', 'name' => 'edit_delivery_challan', 'title' => 'Edit delivery challan', 'guard_name' => 'web'],
            ['group' => 'delivery challan', 'name' => 'delete_delivery_challan', 'title' => 'Delete delivery challan', 'guard_name' => 'web'],
        ];
        Permission::insert($permissions);

        //Admin
        $admin = Role::updateOrCreate(['name' => 'admin'], ['title' => 'Admin']);
        $adminPermissions = Permission::all();
        $admin->permissions()->sync($adminPermissions);

        //Manager
        $manager = Role::updateOrCreate(['name' => 'manager'], ['title' => 'manager']);
        $managerPermissions = Permission::whereIn('name', [
            'view_user', 
            'view_category', 
            'view_item', 
            'view_mode_of_payment', 
            'view_demand', 
            'view_unit', 
            'view_supplier', 
            'view_client',
            'view_person',
            'view_tender',
            'view_quotation',
            'view_company',
            'view_currency',
            'view_supply_order',
            'view_delivery_challan'
            ])->get();
        $manager->permissions()->sync($managerPermissions);
    }
}
