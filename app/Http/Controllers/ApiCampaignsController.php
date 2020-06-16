<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiCampaignsController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::with('user', 'category', 'donations')->orderBy('updated_at', 'desc')->get();
        foreach ($campaigns as $key => $campaign) {
            $end = Carbon::parse($request->input($campaign->end));
            $now = Carbon::now();
            $diff = $end->diffInDays($now);
//            dd($diff);
            $campaigns[$key]->time_left = $diff;

//            \Carbon\Carbon::parse($post->updated_at)->format('M d Y');
            $campaigns[$key]->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            $campaigns[$key]->percent = floor($campaign->raised / $campaign->euro_goal * 100);
//dd($campaign->euro_goal);
        }

        return $campaigns;
    }

    public
    function show($id, Request $request)
    {
        $campaign = Campaign::find($id);
//        $end = Carbon::parse($request->input($campaign->end));
//            $now = Carbon::now();
//            $diff = $end->diffInDays($now);
//            $campaign->time_left = $diff;
            $campaign->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            dd($campaign->raised);
            $campaign->percent = floor($campaign->raised / $campaign->euro_goal * 100);
        return $campaign;


    }
}
