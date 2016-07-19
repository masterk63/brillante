@extends('layouts.app')

@section('scripts')
{{ Html::script('js/autocomplete.js')}}
{{ Html::script('js/agregarVenta.js')}}
{{ Html::script('js/eliminarfilaventa.js')}}
{{ Html::style('css/style.css')}}
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div>
                 <ul class="list-inline">
                     <li>
                         <a href="{{ route('ventas.index',['seccion'=>'lista']) }}" class="btn btn-default">Ver Ventas</a>
                     </li>    
                </ul>
            </div>
            <div>
                <dl class="list">
                    <dt style="width: 30%;">
                        <div class="form-group">
                            {{ Form::label('q', 'Agregar Producto a la Venta') }}
                            {{ Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Ej: Lavandina','class'=> 'form-control','autofocus'])}}
                            {{ Form::hidden('qId', '', ['id' =>  'qId',])}}
                        </div> 
                    </dt>
                    <dt style="width: 30%;">
                        <div class="form-group2">
                            {{ Form::label('SelectCant', 'Cantidad') }}
                            {{ Form::text('SelectCant', '', ['id' =>  'SelectCant', 'placeholder' =>  '1','class'=> 'form-control'])}}
                        </div> 
                    </dt>
                <dl>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Ventas</div>
                <div class="panel-body">
                    <div  class="table-responsive">              
                        <table class="table table-striped tabla-listaVenta">
                            <thead>
                                <tr>
                                    <th>Cant</th>
                                    <th>Cod</th>
                                    <th>Descripcion</th>
                                    <th>Unit</th>
                                    <th>Importe</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>TOTAL</td>
                                  <td id="total">0</td>
                                  <td></td>
                                </tr>
                            </tfoot>
                            <tbody id="tablaVentas">
                            </tbody>
                        </table>
                    </div>
                </div>     
            </div> 
            <button type="button" class="btn btn-primary" id="realizarVenta" style="float:right;" onclick="cargarVenta()" disabled="disabled">Realizar Venta</button>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Felicidades!!!</h4>
      </div>
      <div class="modal-body">
        <p>Venta Realizada con Exito.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
@endsection
