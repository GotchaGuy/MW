<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $final_path = substr($path, 7);
        return [
            'status' => 200,
            'name' => $final_path
        ];
    }
}
