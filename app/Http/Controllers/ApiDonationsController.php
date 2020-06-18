<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDonationsController extends Controller
{
     public function store(Request $request)
    {
        return $donation = Donation::create([
            'euro_amount' => $request->input('euro_amount'),
            'plan_b' => $request->input('plan_b'),
            'user_id' => \Auth::user()->id,
            'campaign_id' => $request->input('campaign_id'),
      ]);
    }
}
