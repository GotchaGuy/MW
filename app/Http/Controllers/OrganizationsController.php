<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class OrganizationsController extends Controller
{
    public function show($id)
    {
        $organization = Organization::where('id', $id)->with(['user' => function($query){
            $query->with(['campaigns']);
        }])->orderBy('updated_at', 'desc')->first();


        return view("organization", compact("organization"));
    }
}
