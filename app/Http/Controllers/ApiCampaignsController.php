<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class ApiCampaignsController extends Controller
{
    public function index()
    {
         $campaigns = Campaign::with('user', 'category')->orderBy('updated_at', 'desc')->get();


         return $campaigns;
    }
}
