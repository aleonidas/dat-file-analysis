<?php

namespace App\Http\Controllers;

use App\Http\Upload\Validate;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function index()
    {
        return view('dashboard.home');
    }

    public function upload(Request $request, Validate $validate)
    {
        if ($request->file('file_import')->isValid()) {
            $file_received = $request->file('file_import');

            if ($validate->validFileFormat($file_received)) {
                $filename = $file_received->getClientOriginalName();
                $file_received->move(env('STORAGE_IN'), $filename);

                return redirect()
                    ->route('process.index');
            }
        }

        return redirect()
            ->route('home');
    }

}