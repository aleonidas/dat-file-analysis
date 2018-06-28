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

    public function rules()
    {
        return [
            'file_import' => 'required|file|mimes:dat',
        ];
    }

    public function validFileFormat(UploadedFile $uploadedFile)
    {
        if (in_array($uploadedFile->getClientOriginalExtension(), $this->extensions)) {
            return true;
        }
        return false;
    }


}