@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Arquivos Enviados</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                @foreach($files as $file)
                <tr>
                    <td>
                        {{ $file }}
                    </td>
                    <td>
                        <a href="">
                            Processar
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection