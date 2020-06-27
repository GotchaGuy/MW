<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Donation;
use App\Post;
use Illuminate\Http\Request;

class ApiFeedController extends Controller
{
    public function index()
    {
//        $user = \Auth::user();
//        $follows = $user->follows;
////        $follows = $user->follows::with('posts', 'category', 'donations')->orderBy('updated_at', 'desc')->get();
//        foreach ($follows as $key => $follow) {
//            $follows[$key]->time_left = $follow->end->diffForHumans();
//            $follows[$key]->raised = Donation::where('campaign_id', $follow->id)->sum('euro_amount');
//            $follows[$key]->percent = floor($follow->raised / $follow->euro_goal * 100);
//            $follows[$key]->posts = Post::where('campaign_id', $follow->id)->get();
//        }
//        return $follows;

//        whereIn *stavim array ideva od kampanje koje pratim

    }
}
