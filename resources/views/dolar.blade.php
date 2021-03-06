@extends('layouts.noMenu')

@section('content')
<div class="container" style="margin-top: 10%;">
    <div class="row">
        <div class="col m8 offset-s2">
            <div class="panel panel-default">
                <div class="panel-heading">Precio del Dolar</div>
                <div class="panel-body">
                    
                    <p>Precio sugerido: <span>{{$precio}}</span></p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/dolar') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="dolar" class="col m4 control-label">Introducir el valor del Dolar</label>

                            <div class="col m6">
                                <input id="dolar" type="number" step="0.01" class="form-control" name="dolar">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col m6 offset-s4">
                                <button type="submit" class="btn btn-primary" style="float:right">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
