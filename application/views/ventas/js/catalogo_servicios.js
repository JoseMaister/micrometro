function load() {
    buscar();
}
function buscar(){
       var URL = base_url + "ventas/ajax_get_Allservicios";
       $('#tabla tbody tr').remove();
       
       var parametro = $("input[name=rbBusqueda]:checked").val();
       var texto = $("#txtBuscar").val();
       var estatus = $("#opEstatus").val();
        var  fecha1 = $("#fecha1").val();
        var fecha2 = $("#fecha2").val();
   
   
       $.ajax({
           type: "POST",
           url: URL,
        data: { texto : texto, estatus : estatus, parametro : parametro, fecha1 : fecha1, fecha2 : fecha2 },
           success: function(result) {
               //alert(result);
               if(result)
               {
                   var tab = $('#tabla tbody')[0];
                   var rs = JSON.parse(result);
                   $.each(rs, function(i, elem){
                       var ren = tab.insertRow(tab.rows.length);
                       ren.insertCell().innerHTML =elem.id;
                       ren.insertCell().innerHTML =elem.user;
                       ren.insertCell().innerHTML =elem.cliente;
                       ren.insertCell().innerHTML =elem.fecha;
                       ren.insertCell().innerHTML ="$ "+elem.total;
                       ren.insertCell().innerHTML = '<a href="'+base_url+'/ventas/ver_servicio/' + elem.id+'"><button type="button"class="btn btn-primary btn-xs">'+elem.estatus +'</button></a>';

   
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