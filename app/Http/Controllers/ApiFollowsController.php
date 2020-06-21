<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiFollowsController extends Controller
{
    public function index()
    {
       $user = \Auth::user();
       $follows = $user->follows;
foreach ($follows as $key => $follow) {
            $follows[$key]->time_left = $follow->end->diffForHumans();
            $follows[$key]->raised = Donation::where('campaign_id', $follow->id)->sum('euro_amount');
            $follows[$key]->percent = floor($follow->raised / $follow->euro_goal * 100);
        }
        return $follows;

    }
}
