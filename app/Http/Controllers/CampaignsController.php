<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function show()
    {
//dodaj $id u show f-ju

//        $campaign = Campaign::find($id);
//        $post->timestamp = \Carbon\Carbon::parse($post->updated_at)->format('M d Y');
//        $categories = Category::all();
//        return view("campaign", compact("campaign", '/'));

        return view("campaign");
    }

}
