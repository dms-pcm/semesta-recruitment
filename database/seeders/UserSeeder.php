<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt(config('myconfig.default_password'));

        $data = [
            [
                'full_name' => 'Admin Semesta', 
                'email' => 'admin@gmail.com', 
                'email_verified_at' => '2023-01-16 10:28:10',
                'username' => 'admin', 
                'password' => $password, 
                'role_id' => 1
            ],
            [
                'full_name' => 'John Doe', 
                'email' => 'nisbrow67@gmail.com', 
                'email_verified_at' => '2023-01-16 10:28:10',
                'username' => 'john', 
                'password' => $password, 
                'role_id' => 2]
        ];

        foreach($data as $d){
            User::create($d);
        }
    }
}
