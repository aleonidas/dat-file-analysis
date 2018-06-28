<?php

namespace App\Http\Upload;

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

    public function moveAndRenameFileDone($filename)
    {
        $source  = env('STORAGE_IN'). DIRECTORY_SEPARATOR .$filename;
        $destiny = env('STORAGE_OUT');

        $info = pathinfo($source);
        $basename = $info['filename'].'.done.'.$info['extension'];
        $to = $destiny . DIRECTORY_SEPARATOR . $basename;

        return rename($source, $to);
    }

}