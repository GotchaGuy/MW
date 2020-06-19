<?php

namespace App\Http\Controllers;

use App\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiFollowsController extends Controller
{
    public function index()
    {
       $user = \Auth::user();
        return $user->follows;

//return
    }
}
