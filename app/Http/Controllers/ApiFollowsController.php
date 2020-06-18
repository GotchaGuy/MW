<?php

namespace App\Http\Controllers;

use App\Follow;
use Illuminate\Http\Request;

class ApiFollowsController extends Controller
{
    public function index()
    {
        $follows = Follow::all();
//        $follows = Follow::where('user_id', \Auth::user()->id);
        dd($follows);
//return
    }
}
