<?php

use App\Campaign;
use Illuminate\Database\Seeder;

class CampaignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Campaign::class, 15)->create()->each(function($campaign) {
            $randArray = [];
            $numbers = range(1,11);
            shuffle($numbers);
            for($i = 0; $i <= 5; $i++) {
              array_push ( $randArray, $numbers[$i]);
            };
            $campaign->follows()->attach($randArray);
        });
    }
}
