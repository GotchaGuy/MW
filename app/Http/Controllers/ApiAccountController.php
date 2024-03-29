<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Organization;
use Illuminate\Http\Request;

class ApiAccountController extends Controller
{
    public function myOrg()
    {
        $my_org = Organization::where('user_id',  \Auth::user()->id)->with(['user', 'campaigns' => function ($query) {
            $query->with(['category'])->orderBy('updated_at', 'desc');
        }])->orderBy('updated_at', 'desc')->first();
        foreach ($my_org->campaigns as $key => $campaign) {
            $my_org->campaigns[$key]->time_left = $campaign->end->diffForHumans();
            $my_org->campaigns[$key]->raised = Donation::where('campaign_id', $campaign->id)->sum('euro_amount');
            $my_org->campaigns[$key]->percent = floor($campaign->raised / $campaign->euro_goal * 100);
            if($my_org->campaigns[$key]->percent > 100) {
                $my_org->campaigns[$key]->percent = 100;
            }
             if ($my_org->campaigns[$key]->image !== 'https://source.unsplash.com/random/600x1000/?green') {
                $my_org->campaigns[$key]->image = substr_replace($campaign->image, 'small/', 9, 0);
            }
        }

        return $my_org;

    }
}
