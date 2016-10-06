@extends('layouts.app')

@section('scripts')
{{ Html::script('js/productos.js')}}
{{ Html::script('js/highlighttable.js')}}
{{ Html::style('css/style.css')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div>
                    <ul class="list-inline">
                        <li>
                            <div class="form-group">
                                {{ Form::label('q', 'Consultar Producto') }}
                            </div> 
                        </li>
                        <li>
                            <div class="form-group">
                                {{ Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Ej: Lavandina','class'=> 'form-control'])}}
                            </div> 
                        </li>
                        <li>
                            <a href="{{ route('productos.create') }}" class="btn btn-default">Nuevo Producto</a>
                        </li>
                    </ul>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">Lista de Productos</div>
                <div class="panel-body">
                    <div  class="table-responsive" style="height: 500px;overflow-y: scroll;overflow-x: scroll;">              
                        <table id="data" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio sin iva</th>
                                    <th>Ganancia</th>
                                    <th>Precio Venta</th>
                                    <th>Stock General</th>
                                    <th>Stock Deposito</th>
                                    <th>Stock Local</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="resultado">
                                @foreach ($listaProductos as $l)
                                <tr>
                                    <td>{{$l->nombre}}</td>
                                    @if($l->cotizacion=='Dolares')
                                    <td><font color="#04B431">u$s {{$l->precio}}<font></td>
                                    @else
                                    <td>$ {{$l->precio}}</td>
                                    @endif
                                    <td>{{$l->ganancia}}%</td>
                                    <td>$ {{$l->precioVenta}}</td>
                                    <td>{{$l->stock}}</td>
                                    <td>{{$l->stockDeposito}}</td>
                                    <td>{{$l->stockLocal}}</td>
                                    <td><a style='float:left;' href="{{route('productos.edit',$l->idProducto)}}">Editar</a></td>
                                    <td>
                                        <button class="btn btn-link"  onclick="productoEliminar(this)" data-idproducto="{{$l->idProducto}}"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>     
                </div>
            </div>
        </div>
    </div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>  
        </div>
        <div id="tituloModal" class="modal-title" align="center">
        </div>
        <div id="mensajeModal" class="modal-body" align="center">
        </div>
        <div id="botonModal" class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>
@endsection

