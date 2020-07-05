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

        Organization::create(
            ['title' => 'Nardar',
                'location' => 'Dobrocinska 88, Beograd',
                'user_id' => '1',
                'field_of_work' => 'We work to better understand and leverage domestic philantropy for the social transformation of the countries of the Western Balkans',
//                'description' => 'Lorem Enim non ex id dolorum. A aliquid sit assumenda fugit eveniet sunt qui. Dolor ut aliquid consequuntur magni ipsa at voluptas. Dignissimos ipsum debitis incidunt asperiores architecto aut. Officiis harum et consequatur enim eaque qui. Quaerat at provident eum quod quo sint nihil. Consequatur non ipsum doloremque in officia consequuntur ut optio. Asperiores quos illo impedit aut magni deserunt aut. Voluptatem laborum quia enim sit veritatis nemo laboriosam odit. In natus neque culpa aut. Aliquam odio quas enim quia atque aut. Voluptatibus dolor natus laboriosam provident sapiente maxime. Quidem ratione illo rem. Quam sed excepturi aut magnam consequatur fuga. Neque ducimus cum nemo at. Ad officiis vel quos iste unde. Id iste et similique dolorem odit. ',
                'org_logo' => '/images/logo.png'
            ]);
        //model state Vlada showed me for specific users to have organizations
            factory(Organization::class, 10)->create();

//            factory(Organization::class, 1)->where('user_id', 1)->create();
            // organization rucno dodeli sebi svom id-u
        //ima i masquerade
    }
}
