<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Organization;
use Illuminate\Http\Request;

class PostFormController extends Controller
{
    public function index()
    {
                return view('post-form');
    }
}
