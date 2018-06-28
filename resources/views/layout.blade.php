<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>RZ2</title>

    <link href="{{ '/assets/css/bootstrap.min.css' }}" rel="stylesheet"/>
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