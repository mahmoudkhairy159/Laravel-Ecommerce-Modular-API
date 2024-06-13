<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    public function uploadFile($file, string $folder, string $disk = "public_uploads")
    {
        $fileName = $file->hashName();
        $file = $file->storeAs($folder, $fileName, $disk);
        return $fileName;
    }

    public function getFileAttribute($path)
    {
        return ($path != null) ? asset('storage/' . $path) : '';
    }

    public function deleteFile($imageName, $directory)
    {
        if (File::exists(public_path('uploads/' . $directory . '/' . $imageName))) {
            Storage::disk('public_uploads')->delete($directory . '/' . $imageName);
        }
    }
}
