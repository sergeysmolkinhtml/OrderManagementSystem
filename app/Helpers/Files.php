<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final readonly class Files
{
    public static function upload(
        mixed $image,
        string $directory,
        int $width = null,
        int $height = null,
        bool $crop = null
    )
    {

    }

    public static function deleteFile($image,$folder) : bool
    {
        $dir = trim($folder,'/');
        $path = $dir . '/' . $image;

        if(!File::exists(public_path($path))) {
            Storage::delete($path);
        }
       return true;
    }

    public static function generateNewFileName($currentFileName) : string
    {
        $extension =  strtolower(File::extension($currentFileName));
        $newName = md5(microtime());

        if($extension === '') return $newName;

        return $newName . '.' . $extension;
    }
}
