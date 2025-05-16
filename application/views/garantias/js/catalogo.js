function load(){
    buscar();

}
function modalAgregar(){
    $('#btnEditar').hide();
    $('#btnAgregar').show();
    $('#mdlAlta').modal();    
}
function buscar(){
       var URL = base_url + "ventas/ajax_getCatalogoGarantias";
       $('#tbl_catalogo tbody tr').remove();
   
   
       $.ajax({
           type: "POST",
           url: URL,
          // data: { texto : texto, parametro : parametro },
           success: function(result) {
               //alert(result);
               if(result)
               {
                   var tab = $('#tbl_catalogo tbody')[0];
                   var rs = JSON.parse(result);
                   $.each(rs, function(i, elem){
                       var ren = tab.insertRow(tab.rows.length);
                       ren.insertCell().innerHTML =elem.id;
                       ren.insertCell().innerHTML =elem.titulo;
                       ren.insertCell().innerHTML ="<button type='button' onclick='verObservaciones(this)'  value=" + encodeURIComponent(elem.descripcion) + " class='btn btn-primary btn-xs'><i class='fa fa-comments'></i></button>"+elem.descripcion;
                       ren.insertCell().innerHTML = "<button type='button' onclick='mdlModificar(this)' value=" + elem.id + " class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Editar</button>";
                       
   
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

   function mdlModificar(btn){
    var URL = base_url + "ventas/ajax_getGarantia";
    var id = $(btn).val();

    $('#opMagnitud option').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#edit_producto').val(rs.titulo);
                $('#edit_descripcion').val(rs.descripcion);

                

                
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    
    $('#mdlEditar').modal();
}
function verObservaciones(btn){
    var observaciones = decodeURIComponent($(btn).val());

    $('#lblObservaciones').text(observaciones);
    
    $('#mdlObservaciones').modal();
}   