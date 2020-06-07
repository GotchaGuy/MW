<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class ApiFeedController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('user', 'category', 'donations')->orderBy('updated_at', 'desc')->get();
        foreach ($campaigns as $campaign) {

        }

//        return $campaigns;
    }
}
