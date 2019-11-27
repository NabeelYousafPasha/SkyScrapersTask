<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = array([
            [
                "name" => "Super Admin",
                "email" => "superadmin@sky.com",
                "type" => "super_admin",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "Admin 1",
                "email" => "admin1@sky.com",
                "type" => "admin",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "Admin 2",
                "email" => 'admin2@sky.com',
                "type" => "admin",
                "password" => bcrypt('qwerty123'),
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],
        ]);

        foreach ($admins as $admin)
            DB::table('admins')->insert($admin);


        // assigning roles to respective users
        for ($i=1; $i <= 3; $i++) {
            DB::table('model_has_roles')->insert([
                'role_id' => 1,
                'model_type' => 'App\Admin',
                'model_id' => $i
            ]);
        }
    }
}
