<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Organization;
use Illuminate\Http\Request;

class PostFormController extends Controller
{
    public function index()
    {
        $organization = Organization::where('user_id', \Auth::user()->id)->with(['campaigns' => function ($query) {
            $query->with(['category']);
        }])->orderBy('updated_at', 'desc')->first();

        foreach ($organization->campaigns as $key => $campaign) {
            $organization->campaigns[$key]->time_left = $campaign->end->diffForHumans();
            $organization->campaigns[$key]->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            $organization->campaigns[$key]->percent = floor($campaign->raised / $campaign->euro_goal * 100);
        }

        return view('post-form', 'organization');
    }
}
