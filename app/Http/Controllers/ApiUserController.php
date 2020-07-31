<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function userInfo()
    {
        return User::where('id',  \Auth::user()->id)->first;
    }
}
