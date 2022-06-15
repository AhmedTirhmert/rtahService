<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            'name' => 'Admin',
            'description' => 'Admin',
            
        ]);
        Role::insert([
            'name' => 'Fournisseur',
            'description' => 'Fournisseur',
        ]);
        Role::insert([
            'name' => 'Client',
            'description' => 'Client',
        ]);
    }
}
