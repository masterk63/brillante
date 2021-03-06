<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GestorCompras extends Model
{ 
     
    public function nueva(Compras $i)
    {
        $params = array(
            $i->cMonto,
            $i->cCadena,);
    	$result = DB::select('call compra_nueva(?,?)',$params);
        return $result;
    }
    
    public function listar(){
        $data = DB::select('call compra_listar'); 
        return $data;
    }
    
    public function dame($id){
        $result = DB::select('call compra_dame(?)',array($id));
        return $result;
        
    }

    public function baja($id)
    {
        $parametro = array($id);
        $result = DB::select('call compra_eliminar(?)',$parametro); 
        return $result;
    }
    
}
