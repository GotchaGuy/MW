<?php

use App\Role;
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
        Role::create(['type'=> 'reg', 'title' => 'Donator']);
        Role::create(['type'=> 'org', 'title' => 'Organization']);
        Role::create(['type'=> 'adm', 'title' => 'Admin']);
    }
}
