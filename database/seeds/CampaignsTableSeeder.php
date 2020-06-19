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
//           izgenerisi array od 5 random brojeva izmedju 2 i 12 i ubaci u attach
            $campaign->follows()->attach();
        });
    }
}
