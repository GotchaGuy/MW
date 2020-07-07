<?php

namespace App\Jobs;

use App\Campaign;
use App\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckCampaigns implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $specificDonations = [];
        $campaigns = Campaign::with('donations')->orderBy('updated_at', 'desc')->get();
        foreach ($campaigns as $key => $campaign) {
//            if (Carbon::now() >= $campaigns[$key]->end) {
                if (Carbon::now() >= $campaigns[$key]->end && Carbon::now()->subHours(24) < $campaigns[$key]->end) {
                $campaigns[$key]->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
                if ($campaigns[$key]->raised < $campaigns[$key]->euro_goal) {
                    foreach ($campaign->donations as $key => $donation) {
                        if ($donation->plan_b != 1) {
                            array_push($specificDonations, $donation->id);
                        }
                    }
                }
            }
        }
        DoPlanB::dispatch($specificDonations);
    }
}
