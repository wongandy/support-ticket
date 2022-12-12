<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {
            $folder = uniqid() . '-' . now()->timestamp;
            $file = $request->file('upload');
            $fileName = $file->hashName();
            $file->store('uploads/tmp/' . $folder, 'public');

            TemporaryFile::create([
                'folder' => $folder,
                'file_name' => $fileName,
            ]);

            return $folder;
        }

        return '';
    }

    public function destroy(Request $request)
    {
        TemporaryFile::where('folder', $request->getContent())->first()->delete();
        Storage::disk('public')->deleteDirectory('uploads/tmp/' . $request->getContent());
        return $request->getContent();
    }
}
