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
                @foreach($processed as $file)
                    <tr>
                        <td>
                            <?php
                            echo '<pre>';
                            print_r($file);
                            echo '</pre>';
                            ?>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection


