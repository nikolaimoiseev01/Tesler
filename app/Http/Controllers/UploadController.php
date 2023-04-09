<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request) {
        if ($request->hasFile($request->file_source)) {
            $id = uniqid();
            $file = $request ->file($request->file_source);
            $filename  = $file->getClientOriginalName();
            $folder = $request->file_source . '/' . $id . '-' . now()->timestamp;
            $file_path = $folder . '/' . $filename;
            $file->storeAs('media/filepond_temp/' . $folder, $filename, 'public');
            return $file_path;
        }
        else {
            return '';
        }

    }
}
