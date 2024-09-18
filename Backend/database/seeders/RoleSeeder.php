<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $role = Role::create(['name' => 'superAdmin']);
        $role = Role::create(['name' => 'kreator']);
        $role = Role::create(['name' => 'user']);
        $role = Role::create(['name' => 'guest']);
    }
}
