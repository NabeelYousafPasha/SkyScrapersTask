<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array([
            [
                "name" => "admin",
                "guard_name" => "admin",
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "user",
                "guard_name" => "user",
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],[
                "name" => "blogger",
                "guard_name" => "blogger",
                "created_at" => date('Y-m-d'),
                "updated_at" => date('Y-m-d'),
            ],
        ]);

        foreach ($roles as $role)
            DB::table('roles')->insert($role);
    }
}
