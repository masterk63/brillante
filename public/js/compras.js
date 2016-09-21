$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "searchCompras/autocomplete",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        //la variable que va a la consulta se llama term, emulando la consulta
        // GET que hace el jQuery cuando busca, va vacia porque quiero todos
        // los productos
        data: {term: ''},
        dataType: "html",
        success: function(data) //cuando finaliza la consulta
            { 
                //Function para autoCompletar el campo de busqueda
                var jsonResponse = JSON.parse(data);  //parse convierte la consulta (data) en un array
                var productos = []; //creo el array de productos que le voy a dar a autocomplete()
                $.each(jsonResponse, function(index) { //la variable value es el nombre
                        productos.push({value:jsonResponse[index].nombre,id:jsonResponse[index].idProducto});
                });
                // llamo la funcion autocomplete
                $( "#q" ).autocomplete({ //Tomo el input de id = q y uso la funcion ya definida por jQuery
                    source: productos, //array creado arriba, ya no mas busqueda todo el tiempo
                    minLength: 1,     //caracter minimo para empezar a autocompletar
                    cacheLength: 0, //evita que se guarde el cache
                    delay: 0,
                    select: function(event, ui) {
                          $('#q').val(ui.item.value);
                          $('#qId').val(ui.item.id);
                    }
                });

                //Al apretar enter con el nombre del producto saltamos a cantidad
                $("#q").keyup(function (e){
                    switch(e.which) 
                    {
                        case 13: //detecta el enter
                            //muestro el stock y despues salto a FOCUS EN CANTIDAD
                            //la variable value es el nombre
                            $("#SelectCant").focus();
                        break;
                    }
                });

                //Funcion para agregar una linea de compra
                $("#SelectCant").keyup(function (e){
                    realizarCompra(e);
                });

                function realizarCompra(e){
                    switch(e.which) 
                    {
                        case 13: //detecta el enter
                            id=$("#qId").val();
                            cant = $("#SelectCant").val();
                            if(cant <= 0){
                                alert("Debe ingresar una cantidad positiva");
                                break;
                            } 
                            if(cant === ''){
                                cant = 1;
                            }   
                            if (id)
                            {
                                busqueda(id,cant);
                                $("#q").val(null);
                                $("#qId").val(null);
                                $("#SelectCant").val(null);
                                $("#q").focus();
                                $('#realizarCompra').prop('disabled', false);     
                            }
                            break;
                    }
                }

                function busqueda(id,cant)
                {  
                    $.each(jsonResponse, function(index) { //la variable value es el nombre
                        if(jsonResponse[index].idProducto === id){
                            var cantidad = parseFloat(cant);
                            importe = jsonResponse[index].precio*cantidad;
                            importe = importe.toFixed(2);
                            importe = parseFloat(importe);

                            $("#tablaCompras").append( // append modifica el DOM (el esqueleto html, en nuestro caso, la tabla LISTA PRODCUTOS)
                                "<tr>"+
                                    "<td>"+cantidad+"</td>"+
                                    "<td>"+id+"</td>"+
                                    "<td>"+jsonResponse[index].nombre+"</td>"+
                                    "<td>$ "+jsonResponse[index].precio+"</td>"+
                                    "<td id='importe'>$ "+importe+"</td>"+
                                    "<td><button class='btn btn-danger btn-sm' onclick='eliminarFila(this)'>Eliminar</button></td>"+
                                "</tr>"
                                );
                            $('#total').html((parseFloat($('#total').html())+importe).toFixed(2));
                        }
                    });
                }    
            }
        });
});


// el parametro obj que recibe, es el elemento que lo llama osea (this)
// etonces el elemento que lo llama mediante en el evento
// onclick, llama a la funcion eliminarFila(this)
// de esa manera identifico bien que lo esta llamando.
// y $(obj) al escibrilo de esa forma, lo coniverto en un objeto
// de jQuery y trabajo sobre el normalmente.
function eliminarFila(obj){   
//    $(obj).parents('tr').fadeOut('slow',function(){})
  $('#total').html(parseInt($('#total').html())-parseInt($(obj).parents('tr').find('#importe').html()));  
  $(obj).parents('tr').remove();
  desabilitarBoton();
}

function desabilitarBoton() {
    // Existen elementos?
    if($('#tablaCompras tr').length === 0)
    {
       $('#realizarCompra').prop('disabled', true);
    }
}

function cargarCompra(){ 
    var productos = [];
    $('#tablaCompras').children('tr').each(function( i, val) {
    cantidad = $(this).find('td').eq(0).html();
    id = $(this).find('td').eq(1).html();
    precio = $(this).find('td').eq(3).html();
      productos[i] = {"cantidad": cantidad,"id": id,"precio": precio};
    });
    var total = parseFloat($('#total').html());
    enviarCompra(productos,total);
}


function enviarCompra(produc,total)
    {
        $.ajax({ 
            type: "POST",
            url: "compras/realizarCompra",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {productosPOSTajax: produc,total: total},
            dataType: "html",
            success: function(data)
                    {       
                    $("#tablaCompras").empty();
                    $('#total').html(0);
                    $("#q").focus();
                    $('#realizarCompra').prop('disabled', true);   
                    $("#myModal").modal('show');
                    }
            });
    }

