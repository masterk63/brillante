<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GestorVentas extends Model
{
    public function nueva(Ventas $v)
    {
        $params = array(
            $v->vMonto,
            $v->vCadena,);
        
    	$result = DB::select('call venta_nueva(?,?)',$params);
        return $result;
    }
    
    public function listar(){
        $data = DB::select('call venta_listar'); 
        return $data;
    }
    
    public function dame($id){
        $result = DB::select('call venta_dame(?)',array($id));
        return $result;   
    }
    
    public function cobrar($id){
        $result = DB::select('call venta_cobrar(?)',array($id));
        return $result;
        
    }
        
    public function baja($id)
    {
        $parametro = array($id);
        $result = DB::select('call venta_eliminar(?)',$parametro); 
        return $result;
    }

}
