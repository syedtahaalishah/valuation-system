<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait FileUpload
{
    public function uploadFile($file, $destination)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destination, $fileName);

        return $fileName;
    }

    public function deleteFile($file, $destination)
    {
        $filePath = $destination . '/' . $file;
        if (File::exists($filePath)) {
            File::delete($filePath);
            return true;
        }

        return false;
    }
}
