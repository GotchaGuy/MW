<?php

namespace App\Http\Controllers;

use App\Donation;
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
            'backup_campaign_id' => $request->input('backup_campaign_id'),
      ]);
    }
}
