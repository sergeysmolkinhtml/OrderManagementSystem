<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final readonly class Files
{
    /**
     * @throws Exception
     */
    public static function upload(
        mixed $image,
        string $directory,
        int $width = null,
        int $height = null,
        bool $crop = null
    ): string
    {
        config(['filesystems.default' => 'local']);

        /**
         * @var UploadedFile $uploadedFile
         */
        $uploadedFile = $image;
        $folder = $directory . '/';

        if(!$uploadedFile->isValid()){
            throw new Exception('File was not uploaded correctly');
        }
        $newFilename = self::generateNewFileName($uploadedFile->getClientOriginalName());
        $tempPath = public_path('uploads/temp/' . $newFilename);

        if(!File::exists(public_path('uploads/' . $folder))) {
            File::makeDirectory(public_path('uploads/' . $folder),0775, true);
        }
        $newPath = $folder . '/' . $newFilename;

        $uploadedFile->storeAs('temp', $newFilename);

        return $newFilename;
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
