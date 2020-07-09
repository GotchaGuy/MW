<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Donation;
use Illuminate\Http\Request;

class ApiDonationsController extends Controller
{
     public function store(Request $request)
    {
        //user automatically follows campaign upon donating
        $campaign = Campaign::where('id', $request->input('campaign_id'))->first();
        $campaign->follows()->attach(\Auth::user()->id);

        return $donation = Donation::create([
            'euro_amount' => $request->input('euro_amount'),
            'plan_b' => $request->input('plan_b'),
            'user_id' => \Auth::user()->id,
            'campaign_id' => $request->input('campaign_id'),
            'backup_campaign_id' => $request->input('backup_campaign_id'),
      ]);
    }

//    public function store_b(Request $request)
//    {
//        return $donation = Donation::create([
//            'euro_amount' => $request->input('euro_amount'),
//            'plan_b' => 1,
//            'user_id' => \Auth::user()->id,
//            'campaign_id' => $request->input('backup_campaign_id'),
//      ]);
//    }

    public function delete($id)
    {
       return Donation::destroy($id);
    }
}
