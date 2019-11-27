<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array([
            [
                "name" => "User 1",
                "email" => "user1@sky.com",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "User 2",
                "email" => "user2@sky.com",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "User 3",
                "email" => 'user3@sky.com',
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],
        ]);

        foreach ($users as $user)
            DB::table('users')->insert($user);


        // assigning roles to respective users
        for ($i=1; $i <= 3; $i++) {
            DB::table('model_has_roles')->insert([
                'role_id' => 2,
                'model_type' => 'App\User',
                'model_id' => $i
            ]);
        }
    }
}
