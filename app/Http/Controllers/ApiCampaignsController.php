<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class ApiCampaignsController extends Controller
{
    public function index()
    {
         $campaigns = Campaign::with('user', 'category', 'donations')->orderBy('updated_at', 'desc')->get();
//foreach ($campaigns as $key => $campaign) {
//            $diff = $campaign->end - now();
////\Carbon\Carbon::parse($post->updated_at)->format('M d Y');
//            $campaigns[$key]->timeLeft = $diff;

//        $campaigns[$key]->raised = App\Donation::where('campaign_id', $campaign->id)->count();

//        $campaigns[$key]->percent = $campaign->raised / $campaign->goal * 100;
//        }

         return $campaigns;
    }
}
