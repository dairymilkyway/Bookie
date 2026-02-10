<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(['id' => 1], ['role_name' => 'Student']);
        Role::updateOrCreate(['id' => 2], ['role_name' => 'Teacher']);
    }
}
