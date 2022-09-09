<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class add_admin_role_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(
            array(0=>['name' => 'Rinku','email' => 'rinku@test.com','password' => '12344321','role_id' => '1']
            )
        );
    }
}
