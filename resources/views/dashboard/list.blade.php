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
                    <td class="text-right">
                        <form action="{{ route('process.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="filename" value="{{ $file }}">
                            <input type="submit" class="btn btn-primary" value="Processar">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection