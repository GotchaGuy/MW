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
            $diff = $campaign->end->diffForHumans();
//            dd($end);
//            $now = Carbon::now();
//            $diff = $end->diffInDays($now);
            $campaigns[$key]->time_left = $diff;

//            \Carbon\Carbon::parse($post->updated_at)->format('M d Y');
            $campaigns[$key]->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            $campaigns[$key]->percent = floor($campaign->raised / $campaign->euro_goal * 100);
//dd($campaign->euro_goal);
        }

        return $campaigns;
    }

    public function store(Request $request)
    {
        return $campaign = Campaign::create([
            'title' => $request->input('title'),
            'euro_goal' => $request->input('euro_goal'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'overhead' => $request->input('overhead'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'user_id' => \Auth::user()->id,
            'category_id' => $request->input('category_id'),
        ]);


    }
}
