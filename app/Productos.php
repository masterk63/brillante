<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Productos extends Model
{
    public $pIdProducto;
    public $pNombre;
    public $pPrecio;
    public $pEstado;
    
    public $timestamps = false; 
      
    function __construct()
    {
        $args = func_get_args();
        $nargs = func_num_args();
        switch($nargs){ 
        case 1:
        self::__construct1();
        break;
        case 2:
        self::__construct2($args[0], $args[1]);
        break;
        }
    }

    function __construct1()
    {
        
    }
    
    function __construct2($nombre, $precio)
    {
        $this->pNombre = $nombre;
        $this->pPrecio = $precio;
    }
    
    
    protected $fillable = [
        'nombre', 'precio',
    ];
   
     public function dame($id){
        $result = DB::select('call producto_dame(?)',array($id));
        //el foreach me ayuda a pasar la consulta estructurada de store procedure
        // a objeto, de esa manera se puede trabajar mas facil y autocompleta los campos
        // gracias al form::model , el objeto es un Model de la base de datos por eso 
        // uso fill() para completarlo.
        foreach ($result as $r) {
                $this->fill([
                "nombre" => $r->nombre,
                "precio" => $r->precio,
            ]);
                $this->pIdProducto = $r->idProducto;
        }
    }

}
