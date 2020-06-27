<?php

use App\Organization;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //model state Vlada showed me for specific users to have organizations
            factory(Organization::class, 7)->create();
    }
}
