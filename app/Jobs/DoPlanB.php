<?php

namespace App\Jobs;

use App\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DoPlanB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $specificDonations;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($specificDonations)
    {
        $this->specificDonations;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($specificDonations)
    {
        foreach ($specificDonations as $key => $specificDonation) {
            if ($specificDonation->plan_b === 2) {
                Donation::create([
                    'euro_amount' => $specificDonation->euro_amount,
                    'plan_b' => 1,
                    'user_id' => $specificDonation->user_id,
                    'campaign_id' => $specificDonation->backup_campaign_id,
                ]);
            }
            if ($specificDonation->plan_b === 3) {
                Donation::destroy($specificDonation->id);
            }
        }
    }
}
