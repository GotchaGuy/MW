<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Post;
use Illuminate\Http\Request;

class ApiPostsController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $follows = $user->follows;
        $ids = [];
        foreach ($follows as $follow) {

            array_push($ids, $follow->id);
        }

//        $user = \Auth::user();
//        $follows = $user->follows;
//        $ids = [];
//        foreach ($follows as $follow) {
//            for ($i = 0; $i <= sizeof($ids); $i++) {
//                if ($follow->id !== $ids[$i]) {
//                    array_push($ids, $follow->id);
//                }
//            }
//        }

//        dd($ids);

        $posts = Post::whereIn('campaign_id', $ids)->with('campaign')->orderBy('updated_at', 'desc')->get();
        foreach ($posts as $key => $post) {
//            $posts[$key]->body = \Str::limit($post->body, 160);

            $posts[$key]->timestamp = $post->updated_at->diffForHumans();
            $posts[$key]->campaign->time_left = $post->campaign->end->diffForHumans();
            $posts[$key]->campaign->raised = Donation::where('campaign_id', $posts[$key]->campaign->id)->sum('euro_amount');
            $posts[$key]->campaign->percent = floor($post->campaign->raised / $post->campaign->euro_goal * 100);
        }
        return $posts;
    }

     public function store(Request $request)
    {
        return $campaign = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image' => $request->input('image'),
//            'user_id' => \Auth::user()->id,
            'campaign_id' => $request->input('campaign_id'),
        ]);


    }
}
