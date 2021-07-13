<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'student']);

//        $p1 = Permission::create(['name'=>'view student list']);
//        $p2 = Permission::create(['name'=>'edit student list']);
//
//        $p1->assignRole('admin');
//        $p1->assignRole('student');
//        $p2->assignRole('admin');
    }
}
