<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RZ2</title>
    <link href="{{ '/assets/css/bootstrap.min.css' }}" rel="stylesheet"/>

    <style>
        .card {
            background: #eee;
            padding: 15px;
            margin: 1px;
        }
    </style>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Análise de Arquivos</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('process.index') }}">Processar Arquivos</a> |
            Arquivos Processados
        </div>
    </div>

    @yield('content')

</div>
</body>
</html>