<?php

namespace App\Http\Controllers;

use function file;
use Illuminate\Http\Request;

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

//            if ($request->file('arquivos')) {
//                foreach ($request->arquivos as $arquivo) {
//                    $arquivo->store($path);
//                }

            $file_received = file($request->file('file_import'));

            //Ler os dados do array
            foreach ($file_received as $row) {
                $row = trim($row);

                echo '<pre>';
                print_r($row);
                echo '</pre>';
            }

            // Validar Upload
            //if ($request->file('photo')->isValid()) {
            //}
//            $this->validate($request, [
//                'name' => 'required',
//                'email' => 'required|email|unique:users'
//            ]);

            // Captutrar upload
            // $file = $request->file('photo');

            // Mover
            //$request->file('photo')->move($destinationPath, $fileName);


//            $path = 'estudos/'.$request->input('type');
//
//            if ($request->file('arquivos')) {
//                foreach ($request->arquivos as $arquivo) {
//                    $arquivo->store($path);
//                }
//            }

        }


        exit;
    }

    public function process()
    {
        //Receber os dados do formulário
        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];

        //ler todo o arquivo para um array
        $dados = file($arquivo_tmp);

        //Ler os dados do array
        foreach($dados as $linha){
            //Retirar os espaços em branco no inicio e no final da string
            $linha = trim($linha);
            //Colocar em um array cada item separado pela virgula na string
            $valor = explode(',', $linha);

            echo '<pre>';
            print_r($linha);
            echo '</pre>';

            echo '<pre>';
            print_r($valor);
            echo '</pre>';
            echo '<hr>';

            //Recuperar o valor do array indicando qual posição do array requerido e atribuindo para um variável
            $nome    = $valor[0];
            $email   = $valor[1];
            $usuario = $valor[2];
            $senha   = $valor[3];

            //Criar a QUERY com PHP para inserir os dados no banco de dados
            $result_usuario = "INSERT INTO usuarios (nome, email, usuario, senha) VALUES ('$nome', '$email', '$usuario', '$senha')";

            //Executar a QUERY para inserir os registros no banco de dados com MySQLi
            $resultado_usuario = mysqli_query($conn, $result_usuario);
        }

        exit;
        //Criar a variável global com a mensagem de sucesso
        $_SESSION['msg'] = "<p style='color: green;'>Carregado os dados com sucesso!</p>";
        //Redirecionar o usuário com PHP para a página index.php
        header("Location: ../index.php");
    }

    public function update(Request $request, $id)
    {
        Estudo::create([
            'type'      => $request->input('type'),
            'name'      => $request->input('name'),
            'pessoa_id' => $id
        ]);

        return redirect()
            ->route('estudos', $id)
            ->with('success', 'Estudo adicionado com sucesso.');
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