<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Organization;
use Illuminate\Http\Request;

class OrganizationsController extends Controller
{
    public function show($id)
    {
//        $organization = Organization::where('id', $id)->with(['user' => function($query){
//            $query->with(['campaigns']);
//        }])->orderBy('updated_at', 'desc')->first();
        $organization = Organization::where('id', $id)->with(['user', 'campaigns' => function ($query) {
            $query->with(['category']);
        }])->orderBy('updated_at', 'desc')->first();
        foreach ($organization->campaigns as $key => $campaign) {
            $organization->campaigns[$key]->time_left = $campaign->end->diffForHumans();
            $organization->campaigns[$key]->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            $organization->campaigns[$key]->percent = floor($campaign->raised / $campaign->euro_goal * 100);
            if ($organization->campaigns[$key]->image !== 'https://source.unsplash.com/random/600x1000/?charity') {
                $organization->campaigns[$key]->image = substr_replace($campaign->image, 'small/', 9, 0);
            }
        }

        return view("organization", compact("organization"));
    }


}
