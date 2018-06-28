<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        // Form
        return view('dashboard.home');
    }

    public function upload(Request $request)
    {
        if ($request->file('file_import')->isValid()) {
            $path = 'data/in';

            // Extension
            // echo $request->file('file_import')->getClientOriginalExtension();

            // Nome original
            // echo $request->file('file_import')->getClientOriginalName();

            $validator = $this->validateDatFormat($request->file('file_import'));

            if ($validator) {
                return redirect()
                    ->route('home')
                    ->with('error', 'Houve um erro.');
            }

            $original_name = $request->file('file_import')->getClientOriginalName();
            $request->file('file_import')->move($path, $original_name);

            // Mover
            //$request->file('photo')->move($destinationPath, $fileName);

            return redirect()
                ->route('home')
                ->with('success', 'Arquivo enviado com sucesso.');
        }

        return redirect()
            ->route('home');
    }

    public function validateDatFormat($request_file)
    {
        if ($request_file->getClientOriginalExtension() === 'dat') {
            return 'FORMATO: DAT';
        }

        return 'FORMATO NAO ACEITO';
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
