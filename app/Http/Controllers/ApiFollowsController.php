<?php

namespace App\Http\Controllers;

use App\Follow;
use Illuminate\Http\Request;

class ApiFollowsController extends Controller
{
    public function index()
    {
        return Follow::where('user_id', \Auth::user()->id);

    }
}
