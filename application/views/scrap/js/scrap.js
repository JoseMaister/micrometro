var total= 0;
function load(){
   cargar_venta();
    buscar();
    
}
function buscar(){
        var URL = base_url + "scrap/ajax_getProductos";
    $('#punto_venta tbody tr').remove();
    
    var texto = $("#txtBusqueda").val();
    var modAuto = $("#modAuto").val();
    var ano = $("#ano").val();
    var  slug = $("#slug").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, modAuto : modAuto, ano : ano, slug : slug},
        success: function(result) {
             if(result)
            {
                var tab = $('#punto_venta tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.codigo;
                    ren.insertCell().innerHTML = elem.producto;
                    ren.insertCell().innerHTML  = elem.ubicacion;
                    ren.insertCell().innerHTML = "$ "+elem.precio;
                    ren.insertCell().innerHTML="<input type='number' id='"+elem.codigo+"'></input><button onclick=seleccionar('"+elem.codigo+"','"+elem.idUbi+"') type='button' class='btn btn-primary btn-xs'><i class='fa fa-check' ></i> Seleccionar</button> ";
                });
            }
            else
            {
               // new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}function seleccionar(id, idProd){
    
    var qty = $('#'+id).val();
    var codigo=id;
    var ubi = idProd;


    var URL = base_url + "scrap/ajax_setVentaTemp";
    $('#carrito tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { qty : qty, codigo : idProd, ubi:ubi},
        success: function(result) {
             if(result)
            {
                cargar_venta();
                new PNotify({ title: '¡Se agrego al carrito!', text: '', type: 'success', styling: 'bootstrap3' });
/*
                var tab = $('#carrito tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var total_venta = elem.precio * elem.qty;
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.codigo;
                    ren.insertCell().innerHTML = elem.producto;
                    ren.insertCell().innerHTML = elem.qty;
                    ren.insertCell().innerHTML = "$ "+elem.precio;
                    ren.insertCell().innerHTML= "$ "+ total_venta;
                    total = total + total_venta;
                    $('#total').text("Total: $ "+total);
                });*/
            }
            else
            {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    
}
function cargar_venta(){
     
    var URL = base_url + "scrap/ajax_getVentaTemp";
     $.ajax({
        type: "POST",
        url: URL,
        data: {},
        success: function(result) {
             if(result)
            {
                

                var tab = $('#carrito tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var total_venta = elem.precio * elem.qty;
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.codigo;
                    ren.insertCell().innerHTML = elem.producto;
                    ren.insertCell().innerHTML = elem.ubicacion;
                    ren.insertCell().innerHTML = elem.qty;
                    ren.insertCell().innerHTML = "$ "+elem.precio;
                    ren.insertCell().innerHTML= "$ "+ total_venta;
                    total = total + total_venta;
                    $('#total').text("Total: $ "+total);
                });
            }
            else
            {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

}
function realizar_venta(){
   
     var URL = base_url + "scrap/ajax_set_venta";
     $.ajax({
        type: "POST",
        url: URL,
        data: {total : total},
        success: function(result) {
             if(result)
            {
//                cargar_venta();
                window.location.reload();

            }
            else
            {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });


}

function mdlLocal(id){
    $("#mdlLocal").modal();
    buscarLocal(id);
}

function buscarLocal(id){
    
    var URL = base_url + "/ventas/ajax_get_locales";
    $('#tblLocal tbody tr').remove();
  /*  var texto = $("#txtBuscarProveedor").val();
    texto = texto.trim();*/
    
    
        
        $.ajax({
            type: "POST",
            url: URL,
            data: { id: id },
            success: function(result) {
                
                if(result)
                {
                    
                    var tab = $('#tblLocal tbody')[0];
                    var rs = JSON.parse(result);
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.ubicacion;
                    ren.insertCell().innerHTML = elem.cantidad;
                    ren.insertCell().innerHTML = "<button onclick=asignar('"+elem.idProd+"','"+elem.ubicacion+"','"+elem.idUbi+"') type='button' class='btn btn-primary btn-xs'><i class='fa fa-check' ></i> Seleccionar</button>";
                    });
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    
}

function asignar(id,ubi,idUbi){
    document.getElementById('id_loc'+id).innerHTML = ubi;
    document.getElementById("id_ubi_prod"+id).value = idUbi;
    $("#mdlLocal").modal('hide');
}
function generar() {
    var URL = base_url + "/ventas/ajax_generar_venta";
    $('#tblLocal tbody tr').remove();
  /*  var texto = $("#txtBuscarProveedor").val();
    texto = texto.trim();*/
    
    
        
        $.ajax({
            type: "POST",
            url: URL,
            data: { id: id },
            success: function(result) {
                
                if(result)
                {
                    
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
}