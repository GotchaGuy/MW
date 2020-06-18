<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Category;
use App\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function show($id, Request $request)
    {
        $campaign = Campaign::find($id)->with('user', 'category', 'donations')->orderBy('updated_at', 'desc')->get();
//        dd($campaign);
         $end = Carbon::parse($request->input($campaign->end));
            $now = Carbon::now();
            $diff = $end->diffInDays($now);
            $campaign->time_left = $diff;
            $campaign->raised = Donation::where('campaign_id', $id)->sum('euro_amount');
            dd($campaign->raised);
            $campaign->percent = floor($campaign->raised / $campaign->euro_goal * 100);
//        $categories = Category::all();
//        $donations = Donation::where('campaign_id', "==", $id);
        return view("campaign", compact("campaign"));
//        , 'categories', 'donations'
    }

}
