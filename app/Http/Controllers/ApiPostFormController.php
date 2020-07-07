<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Organization;
use Illuminate\Http\Request;

class ApiPostFormController extends Controller
{
    public function orgCampaigns()
    {
        $organization = Organization::where('user_id', \Auth::user()->id)->with(['campaigns' => function ($query) {
            $query->with(['category']);
        }])->orderBy('updated_at', 'desc')->first();
//    dd(\Auth::user()->id);
        foreach ($organization->campaigns as $key => $campaign) {
            $campaign->time_left = $campaign->end->diffForHumans();
            $campaign->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            $campaign->percent = floor($campaign->raised / $campaign->euro_goal * 100);
        }

        return $organization;
    }
}
