<?php

namespace App\Http\Upload;

use Illuminate\Http\UploadedFile;

class Validate extends File
{
    
    public function rules()
    {
        return [
            'file_import' => 'required|file|mimes:dat',
        ];
    }

    public function validFileFormat(UploadedFile $uploadedFile)
    {
        if (in_array($uploadedFile->getClientOriginalExtension(), $this->getExtensions())) {
            return true;
        }
        return false;
    }


}