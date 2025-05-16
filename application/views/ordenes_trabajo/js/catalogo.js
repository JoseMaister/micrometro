function load(){
    buscar();
}
/*function buscar(){
        var URL = base_url + "ordenes_trabajo/ajax_getWos";
    $('#wo').empty();
 
var BTN_CLASS;

    var texto = $("#txtBuscar").val();
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var estatus = $("#opEstatus").val();
var div ='';
    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, estatus : estatus, parametro : parametro},
        success: function(result) {
             if(result)
            {
                
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){

                    switch (elem.estatus) {
                                             case 'CREADA':
                                             case 'PROGRAMADA':
                                               BTN_CLASS = 'background-color: blue;';
                                                   break;
                                             case 'CONCLUIDA':
                                               BTN_CLASS = 'background-color: green;';
                                                   break;
                                             case 'CERRADA':
                                               BTN_CLASS = 'background-color: gray;';
                                                   break;
                                             case 'ENTREGADA':
                                               BTN_CLASS = 'background-color: yellow;';
                                                   break;
                                             case 'CANCELADA':
                                               BTN_CLASS = 'background-color: red;';
                                                   break;                                             
                                             default:
                                                // code...
                                                break;
                                             }

                    div = ''
                    + '<div class="col-md-2 col-sm-2 col-xs-2" style="color:#fff; border-style: solid; height:30%;width:30%;padding-bottom:10%;'+BTN_CLASS+'"onclick="cargar('+elem.wo_id+')">'
                    + '<h3>WO '+elem.wo_id+'</h3>'
                    + '<label>'+elem.descripcion+'</label>'
                    + '</div> ';
                    $("#wo").append(div);   
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
}*/

function buscar(){
    var URL = base_url + "ordenes_trabajo/ajax_getWos";
    $('#wo').empty();

    var texto = $("#txtBuscar").val();
    var parametro = $("input[name=rbBusqueda]:checked").val() || 'contenido'; // fallback a 'contenido'
    var estatus = $("#opEstatus").val();
    var BTN_CLASS;
    var div = '';

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto: texto, estatus: estatus, parametro: parametro },
        success: function(result) {
            if(result) {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    switch (elem.estatus) {
                        case 'CREADA':
                        case 'PROGRAMADA':
                            BTN_CLASS = 'background-color: blue;';
                            break;
                        case 'CONCLUIDA':
                            BTN_CLASS = 'background-color: green;';
                            break;
                        case 'CERRADA':
                            BTN_CLASS = 'background-color: gray;';
                            break;
                        case 'ENTREGADA':
                            BTN_CLASS = 'background-color: yellow;';
                            break;
                        case 'CANCELADA':
                            BTN_CLASS = 'background-color: red;';
                            break;
                        default:
                            BTN_CLASS = 'background-color: black;';
                            break;
                    }

                    div = ''
                        + '<div class="col-md-2 col-sm-2 col-xs-2" style="color:#fff; border-style: solid; height:30%;width:30%;padding-bottom:10%;' + BTN_CLASS + '" onclick="cargar(' + elem.wo_id + ')">'
                        + '<h3>WO ' + elem.wo_id + '</h3>'
                        + '<label>' + elem.descripcion + '</label>'
                        + '</div> ';
                    $("#wo").append(div);
                });
            } else {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
        },
        error: function(data) {
            new PNotify({ title: 'ERROR', text: 'Error al buscar', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function boton(id, estatus, user){
    var clase = "btn dropdown-toggle btn-sm";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=verRequerimiento(this)><i class='fa fa-eye'></i> Ver</a></li>"
    

    switch(estatus){
        case "PROGRAMADA":
        case "REPROGRAMADA":
            clase += " btn-primary";
            if(user == uid)
            {
                opcs += "<li><a onclick=cancelar(this)><i class='fa fa-close'></i> Cancelar</a></li></ul></div>";
            }
            break;

       
        case "CONCLUIDA":
            clase += " btn-success";
            break;

        case "CANCELADA":
            clase += " btn-danger";
            break;

        case "CERRADA":
            clase += " btn-dark";
            break;

    }
    
    
    
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' value=" + id + " class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


}

function verRequerimiento(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "ordenes_trabajo/ver_wo", { 'id': id });
}

function editar(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "facturas/editar_solicitud", { 'id': id });
}

function cancelar(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    if(confirm("¿Desea cancelar Solicitud?"))
    {
        var URL = base_url + 'facturas/ajax_editSolicitud';
        
        var solicitud = { 
            id : id,
            estatus : 'CANCELADO'
        };

        $.ajax({
            type: "POST",
            url: URL,
            data: { solicitud : JSON.stringify(solicitud) },
            success: function(result) {
                if(result)
                {
                    buscar();
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}


function buscarClientes(){
    var URL = base_url + "ordenes_trabajo/ajax_getClientesCotizaciones";
    $('#tblClientes tbody tr').remove();
    
    var texto = $("#txtBuscarCliente").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblClientes tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.Cust_ID;
                    ren.dataset.nombre = elem.nombre;
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = "<button onclick='seleccionarCliente(this)' type='button' class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Seleccionar</button> ";
                });

                $('#mdlClientes').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarCliente(btn){
    var row = $(btn).closest('tr')[0];

    $('#txtCliente').val(row.dataset.nombre);
        $('#txtCliente').data('id', row.dataset.id);
        $('#txtClienteId').val(row.dataset.id);
    $('#btnRemoverCliente').show();
    $('#mdlClientes').modal('hide');

    buscar();
}

function removerCliente(){
    $('#btnRemoverCliente').hide();
    $('#txtCliente').val("TODOS");
    $('#txtClienteId').val("");
    $('#txtCliente').data('id', 0);

    buscar();
}
function cargar(id) {
window.location.href = base_url + 'ordenes_trabajo/ver_wo/'+id;    
}

