@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Processamento de arquivo enviado</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 card">
            <p>Quantidade de Vendedores</p>
            <h3>{{ $processed['quantity_salesman'] }}</h3>
        </div>
        <div class="col-md-3 card">
            <p>Quantidade de Clientes</p>
            <h3>{{ $processed['quantity_customer'] }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 card">
            <p>Média salarial dos vendedores</p>
            <h3>{{ $processed['average_salary_of_sellers'] }}</h3>
        </div>
        <div class="col-md-3 card">
            <p>#ID Melhor Venda</p>
            <h3>{{ $processed['id_best_selling'] }}</h3>
        </div>
        <div class="col-md-3 card">
            <p>Pior Vendedor</p>
            <h3>{{ $processed['id_worst_seller'] }}</h3>
        </div>
    </div>
@endsection


