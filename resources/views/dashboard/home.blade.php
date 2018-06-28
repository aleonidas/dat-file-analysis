@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3>Importar dados do arquivo</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <form action="{{ route('home.upload') }}" method="POST" enctype="multipart/form-data">
            <div class="col-md-12 form-group">
                <label for="file_import">Arquivo</label>
                <input type="file" id="file_import" name="file_import" class="form-control" required="required">
            </div>

            <div class="col-sm-12 form-group">
                <input type="submit" class="btn btn-success" value="Importar">
            </div>
        </form>
    </div>
</div>
@endsection