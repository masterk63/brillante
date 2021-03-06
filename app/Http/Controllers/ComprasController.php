<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use \App\GestorProductos;
use App\Productos;
use App\Http\Requests\VentasRequest;
use App\GestorCompras;
use App\GestorProveedores;
use App\Proveedores;
use App\Ventas;
use App\Compras;

class ComprasController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index()
    {   
        return View('compras.index'); 
    }
    
    public function listaCompras()
    {
        $gestor = new GestorCompras();
        $listaCompra = $gestor->listar();
        return view('compras.lista',compact ('listaCompra'));  
    }
    
    public function autocomplete()
    { //Se conecta con autocomplete.js para autocompletar los inputs de busqueda con 
      // el listado de prodcutos
        
        // la consulta es del estilo GET /search/autocomplete?term=la
        // el search/autocomplete es la direccion source del js autocomplete
        // y el termino term es el que se crea para ralizar la busqueda,
        // yo busco el valor de term
	$term = Input::get('term'); 	
        $gp = new GestorProductos();
        $consulta = $gp->listar($term);        
        return Response::json($consulta);
    }

 
    public function create(Request $request)
    {     
        // cuando doy de alta la venta con un SP, en ese mismo SP llevo el string de las lineas y hago todo de una sola vez
        // asi se hace.. para evitar problemas de q JUSTO paso algo..
        // entonces obtengo monto y fecha (para generar una nueva venta y despues generamos el STRING de las lineas contac.
//        $idProveedor = $request->idProveedor; 
        $monto = $request->total; 
        
        $resultado = $request->productosPOSTajax; //obtengo el envio de datos tipo 
        //POST que envie de ajax con el nombre  productosPOSTajax
        //como se envie, contiene varios varios arrays de arrays (matriz)
        // recorro con un foreach cada fil y obtengo las columnas con el 
        // nombre de cada una.
        $cadena = null;
        
        foreach ($resultado as $p){
            //hago este if solo para el formato,para que terminen sin || ( 1|2*2|2 )
            if ($cadena == null) {
                $cadena = $cadena.$p['id']."|".$p['cantidad'];
            }
            else{
                $cadena = $cadena."*".$p['id']."|".$p['cantidad'];
            }
            
        }
        //concat tiene las lineas de venta primero ID despues cantidad
        // resultado de una concatenacion primero id producto $$ cantidad producto
        // || siguiente producto.
        
        //Ahora q tenemos el monto fecha (para venta), tenemos el contac de las lineas
        //Generamos la venta y a su vez las lineas ventas en un solo SP
        $c = new Compras($monto,$cadena); 
        $gc = new GestorCompras();
        $consulta=$gc->nueva($c); // lo agrego a la base de datos
        return $consulta;

    }
    
     public function agregarLinea(Request $request)
    {      
        $p=new Productos();
        $p->dame($request->consulta);
        return Response::json($p); 
    }

 
//    public function store(VentasRequest $request)
//    {
//        $gv = new GestorVentas();
//        $v = new Ventas();
//        $v->fill($request->all());// completo los atributos del objeto Ventas
//        $resultado = $gv->nueva($v); // lo agrego a la base de datos
//        foreach ($resultado as $r) { // obtengo el mensaje de la base de datos
//            $mensaje = $r->Mensaje;
//        }
//        Session::flash('mensaje',$mensaje); // mando el mensaje de la base datos a la vista
//        return redirect()->back(); // vuelvo a ventas
//    }

    public function mostrar(Request $r) 
    {
        $gc = new GestorCompras();
        $compra = $gc->dame($r->idCompra);
        return view('compras.detalle',compact('compra'));
    }
    
    public function show($id)
    {
        
    }

 
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy(Request $request)
    {
        $id=$request->idCompra;
        $gc = new GestorCompras();
        $resultado = $gc->baja($id);
        return Response::json($resultado);
    }
}