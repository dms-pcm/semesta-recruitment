<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['role' => 'Admin'],
            ['role' => 'User']
        ];

        foreach($data as $d){
            Role::create([
                'role' => $d['role'],
            ]);
        }
    }
}
