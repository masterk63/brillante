<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use \App\GestorProductos;
use App\Productos;
use App\Http\Requests\VentasRequest;
use App\GestorVentas;
use App\Ventas;

class VentasController extends Controller
{
    public function index()
    {
        return view('ventas.index');
    }
    
    public function autocomplete()
    { //Se conecta con autocomplete.js para autocompletar los inputs de busqueda con 
      // el listado de prodcutos
	$term = Input::get('term');
	
        $gp = new GestorProductos();
        $consulta = $gp->buscar($term);
	
	foreach ($consulta as $query)
	{
	    $resultado[] = [ 'id' => $query->idProducto, 'value' => $query->nombre];
	}
        return Response::json($resultado);
    }

 
    public function create(Request $request)
    {     
        foreach ($request as $r){
            $r->cantidad;
            $r->id;
        }
    }
    
     public function agregarLinea(Request $request)
    {      
        $p=new Productos();
        $p->dame($request->consulta);
        return Response::json($p); 
    }

 
    public function store(VentasRequest $request)
    {
        $gv = new GestorVentas();
        $v = new Ventas();
        $v->fill($request->all());// completo los atributos del objeto Ventas
        $resultado = $gv->nueva($v); // lo agrego a la base de datos
        foreach ($resultado as $r) { // obtengo el mensaje de la base de datos
            $mensaje = $r->Mensaje;
        }
        Session::flash('mensaje',$mensaje); // mando el mensaje de la base datos a la vista
        return redirect()->back(); // vuelvo a ventas
    }

    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}