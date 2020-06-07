<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Category;
use App\Donation;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function show($id)
    {
        $campaign = Campaign::find($id);
        $categories = Category::all();
        $donations = Donation::where('campaign_id', "==", $id);
        return view("campaign", compact("campaign", 'categories', 'donations'));
    }

}
