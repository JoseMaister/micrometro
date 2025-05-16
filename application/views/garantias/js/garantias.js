function buscar(){
       var URL = base_url + "ventas/ajax_getGarantias";
       $('#tabla tbody tr').remove();
       
       var parametro = $("input[name=rbBusqueda]:checked").val();
       var texto = $("#txtBuscar").val();
   
   
       $.ajax({
           type: "POST",
           url: URL,
           data: { texto : texto, parametro : parametro },
           success: function(result) {
               //alert(result);
               if(result)
               {
                   var tab = $('#tabla tbody')[0];
                   var rs = JSON.parse(result);
                   $.each(rs, function(i, elem){
                       var ren = tab.insertRow(tab.rows.length);
                       ren.insertCell().innerHTML =elem.id;
                       ren.insertCell().innerHTML =elem.nombre;
                       ren.insertCell().innerHTML =elem.fecha;
                       ren.insertCell().innerHTML ="$ "+elem.total_final;
                       ren.insertCell().innerHTML = '<a href="'+base_url+'/ventas/crear_garantia/' + elem.id+'"><button type="button"class="btn btn-warning btn-xs">Crear garantia</button></a>';
   
                   });
               }
               else
               {
               }                   new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });

             },
           error: function(data){
               new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
   
               console.log(data);
           },
         });
   }
   function enviarSolicitud(){
var URL = base_url + "ventas/ajax_setGarantia";
var motivo = $('#motivo').val();
var accion= $('#accion').val();
var garantia= $('#garantia').val();

var  articulo= $('#articulo').val();
var  dinero= $('#dinero').val();
var  credito= $('#credito').val();

$.ajax({
        type: "POST",
        url: URL,
        data: {accion:accion, motivo:motivo, venta:venta,garantia:garantia, articulo:articulo, dinero:dinero, credito:credito },
        success: function(result) {
            if(result)
            {
                var rs= JSON.parse(result);
                window.location.href = base_url + 'ventas/ver_garantia/'+rs;    
               
                

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

}
