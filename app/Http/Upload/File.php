<?php

namespace App\Http\Upload;

use Illuminate\Http\UploadedFile;

class File
{

    private $extensions;

    public function __construct()
    {
        $this->extensions = [
            'dat'
        ];
    }

    public function getExtensions()
    {
        return $this->extensions;
    }

    public function getFilesDirIn()
    {
        $files = [];

        if ($handle = opendir(env('STORAGE_IN'))) {
            while ($file = readdir( $handle)) {
                $extension = strtolower( pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($extension, $this->getExtensions())) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        return $files;
    }

}