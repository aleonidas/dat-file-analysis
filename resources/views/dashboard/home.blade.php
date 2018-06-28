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
            <h1>Importar dados do arquivo TXT</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <form action="{{ route('home.upload') }}" method="POST" enctype="multipart/form-data">
                <div class="col-md-12 form-group">
                    <label for="file_import">Arquivo</label>
                    <input type="file" id="file_import" name="file_import" class="form-control" required="required">
                </div>

                <div class="col-sm-1 form-group">
                    <input type="submit" class="btn btn-success" value="Importar">
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>