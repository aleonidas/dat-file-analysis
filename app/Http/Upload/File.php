<?php

namespace App\Http\Upload;


use function in_array;

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

    public function validFileFormat($file_received)
    {
        if (in_array($file_received->getClientOriginalExtension(), $this->extensions)) {
            return true;
        }
        return false;
    }


}