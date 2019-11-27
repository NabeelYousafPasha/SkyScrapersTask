<?php

use Illuminate\Database\Seeder;

class BloggersTableSeeder extends Seeder
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
                "name" => "Blogger 1",
                "email" => "blogger1@sky.com",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "Blogger 2",
                "email" => "blogger2@sky.com",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "Blogger 3",
                "email" => 'blogger3@sky.com',
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],
        ]);

        foreach ($users as $user)
            DB::table('bloggers')->insert($user);


        // assigning roles to respective users
        for ($i=1; $i <= 3; $i++) {
            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\Blogger',
                'model_id' => $i
            ]);
        }
    }
}
