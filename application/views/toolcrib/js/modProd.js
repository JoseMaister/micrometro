function load(){
   // ComboAno();
    cargar_datos(id)
}

function mdlAutos(){

    $('#btnEditar').hide();
    $('#btnAgregar').show();
    $('#mdlAutos').modal();
    cargar_datos(id)

}
function ComboAno(){
   var n = (new Date()).getFullYear()
   var select = document.getElementById("ano");
   for(var i = n; i>=1900; i--)select.options.add(new Option(i,i)); 
}
function agregar(){
    var year = $('#year').val();
    var slug = $('#slug').val();
    var modAuto = $('#modAuto').val();
    var idp = $('#idp').val();
    var motor = $('#motor').val();
    var URL = base_url + 'toolcrib/ajax_guardarDatos';
    $.ajax({
            type: "POST",
            url: URL,
            data: { year : year, slug : slug,modAuto : modAuto,idp : idp, motor:motor},
            success: function(result) {
                if(result)
                {   
                    cargar_datos(id)
                    new PNotify({ title: 'Usuario', text: 'Se ha agregado vehiculo', type: 'success', styling: 'bootstrap3' });
                }
            },
        });
}

function cargar_datos(id) {
   
    var URL = base_url + "toolcrib/cargar_datos";
    $('#tabla_autos tbody tr').remove();
     $.ajax({
            type: "POST",
            url: URL,
            data: { id : id},
            success: function(result) {
                if(result)
                {
                   var tab = $('#tabla_autos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = elem.ano;
                    ren.insertCell().innerHTML = elem.marca;
                    ren.insertCell().innerHTML = elem.modelo;

                    
                });
                }
            },
        });
}