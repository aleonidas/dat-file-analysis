<?php

namespace App\Http\Controllers;

use function file_exists;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('dashboard.home');
    }

    public function show()
    {
        $type  = ['dat'];
        $files = [];

        if ($handle = opendir('data/in')) {
            while ($file = readdir( $handle)) {
                $extension = strtolower( pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($extension, $type)) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }


        return view('dashboard.list')
            ->with('files', $files);
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
                ->route('home.show');
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

    public function uploadOld(Request $request, $id)
    {
        $path = 'estudos/'.$request->input('type');

        if ($request->file('arquivos')) {
            foreach ($request->arquivos as $arquivo) {
                $arquivo->store($path);

                Estudo::create([
                    'type'      => $request->input('type'),
                    'name'      => $arquivo->getClientOriginalName(),
                    'file'      => $arquivo->hashName(),
                    'pessoa_id' => $id
                ]);
            }
        }

        return redirect()
            ->route('estudos', $id)
            ->with('success', 'Arquivos enviados com sucesso.');
    }


}
