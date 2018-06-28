@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <div class="col-md-4">
                <h2>Pesquisa: {{ $search }}</h2>
                <br>
            </div>
            <div class="col-md-8">
                <form action="{{ url('/buscar/'. $search) }}" class="col-md-3 pull-right" method='get'>
                    <label for="filter">Ordenar</label>
                    <select name="filter" id="" class='form-control'>
                        <option value="new">Mais novos</option>
                        <option value="old">Mais antigos</option>
                        <option value="alfa">De A a Z</option>
                    </select>
                    <br>
                    <input type="submit" value="Ordenar" class='btn-filter btn btn-sm btn-primary'>
                </form>
            </div>
            <div class="clearfix"></div>
            @include('video.videosList')
        </div>
    </div>
</div>
@endsection
