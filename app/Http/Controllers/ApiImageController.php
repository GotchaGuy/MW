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

            'file' => 'image|mimes:jpeg,png,jpg|max:5072',
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
//        $thumb = Image::make('storage/' . $final_path);

        $thumb->resize(140, 235);

        $thumb->save(public_path('storage/small/' . $final_path));
//        $thumb->save('storage/small/' . $final_path);
// http://idoniraj.test/storage/small/camp_images/LA4QypfGkgSMTzpfYuCCstQJ7NIEfbGAhQIBOZdb.png

        dd($final_path);

//        if (!file_exists($final_path)) {
//            mkdir($final_path, 666, true);
//        }

        return [
            'status' => 200,
            'name' => $final_path
        ];

// file:///C:/laragon/www/idoniraj/public/storage/camp_images/epTlZV1LQ0BjCRLkSEzMq0nfp7C3QjNdjz3hHrZd.png
    }

    public function uploadPost(Request $request)
    {
        $this->validate($request, [

            'file' => 'image|mimes:jpeg,png,jpg|max:5072',
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

            'file' => 'image|mimes:jpeg,png,jpg|max:5072',
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
