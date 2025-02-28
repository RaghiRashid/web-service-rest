<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Cliente', 'Admin', 'Gestor'];

        foreach ($roles as $role) {
            if (!DB::table('roles')->where('name', $role)->exists()) {
                DB::table('roles')->insert([
                    'name' => $role,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
