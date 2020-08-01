<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ApiImageController extends Controller
{
    public function uploadCamp(Request $request)
    {
        $this->validate($request, [

            'file' => 'image|mimes:jpeg,png,jpg|max:3072',
        ]);
        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'No File Uploaded'
            ]);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'File is not valid!'
            ]);
        }
        //saving the file
        $path = $file->store('public/camp_images');

//        dd($path);
        $final_path = substr($path, 7);
//        dd(public_path('storage/' . $final_path));
        $thumb = Image::make(public_path('storage/' . $final_path));

        $thumb->resize(100, 100);
        $thumb->save(public_path('storage/small/' . $final_path));


        return [
            'status' => 200,
            'name' => $final_path
        ];
    }

    public function uploadPost(Request $request)
    {
        $this->validate($request, [

            'file' => 'image|mimes:jpeg,png,jpg|max:3072',
        ]);
        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'No File Uploaded'
            ]);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'File is not valid!'
            ]);
        }
        //saving the file
        $path = $file->store('public/post_images');

        $final_path = substr($path, 7);
        return [
            'status' => 200,
            'name' => $final_path
        ];
    }

    public function uploadLogo(Request $request)
    {
        $this->validate($request, [

            'file' => 'image|mimes:jpeg,png,jpg|max:3072',
        ]);
        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'No File Uploaded'
            ]);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'File is not valid!'
            ]);
        }
        //saving the file
        $path = $file->store('public/logo_images');

        $final_path = substr($path, 7);
        return [
            'status' => 200,
            'name' => $final_path
        ];
    }

    public function updateLogo(Request $request, $id)
    {
        return Organization::where('id', $id)->update([
            'org_logo' => $request->input('org_logo'),
        ]);
    }
}
