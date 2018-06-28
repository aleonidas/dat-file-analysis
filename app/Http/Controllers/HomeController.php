<?php

namespace App\Http\Controllers;

use function file_exists;
use Illuminate\Http\Request;
use function utf8_encode;

class HomeController extends Controller
{

    public function index()
    {
        return view('dashboard.home');
    }

    public function upload(Request $request)
    {
        if ($request->file('file_import')->isValid()) {
            $path = 'data/in';
            $file_received = $request->file('file_import');

            if ($this->invalidFileFormat($file_received)) {
                return redirect()
                    ->route('home');
            }

            $filename = $file_received->getClientOriginalName();
            $file_received->move($path, $filename);

            return redirect()
                ->route('process.index');
        }

        return redirect()
            ->route('home');
    }

    public function invalidFileFormat($request_file)
    {
        if ($request_file->getClientOriginalExtension() !== 'dat') {
            return true;
        }
    }

}
