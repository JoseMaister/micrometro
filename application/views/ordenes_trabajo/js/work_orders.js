function load(){
   iniciar_daterangepicker();
}
function seleccionarCliente(){
   // alert(CURRENT_QR);
    $('#divBusqueda').show();
    $("#mdlClientes").modal();
    buscarClientes();
}
function seleccionarServicio(){
   // alert(CURRENT_QR);
    $('#divBusqueda').show();
    $("#mdlServicios").modal();
    buscarServicios();
}
function seleccionarUsuario(){
   // alert(CURRENT_QR);
    $('#divBusqueda').show();
    $("#mdlUsuarios").modal();
    buscarUsuarios();
}
function seleccionarPiezas(){
   // alert(CURRENT_QR);
    $('#divBusqueda').show();
    $("#mdlPiezas").modal();
    buscarPiezas();
}
function buscarClientes(){
    
    var URL = base_url + "/ordenes_trabajo/ajax_getReporteServicios";
    $('#tblBuscarProveedores tr').remove();
  /*  var texto = $("#txtBuscarProveedor").val();
    texto = texto.trim();*/
    
    
        
        $.ajax({
            type: "POST",
            url: URL,
          //  data: { texto: texto },
            success: function(result) {
                
                if(result)
                {
                    
                    var tab = $('#tblBuscarProveedores tbody')[0];
                    var rs = JSON.parse(result);
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.id;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.nombre;
                        cell.style.width = "70%";
                        ren.insertCell(2).innerHTML = "<button type='button' onclick='asignarProveedor(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.nombre + " value=" + elem.id + "><i class='fa fa-plus'></i> Seleccionar</button>";
                    });
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    
}

function buscarServicios(){
    
    var URL = base_url + "/ordenes_trabajo/buscarServicios";
    $('#tblServicios tr').remove();  
        
        $.ajax({
            type: "POST",
            url: URL,
          //  data: { texto: texto },
            success: function(result) {
                
                if(result)
                {
                    
                    var tab = $('#tblServicios tbody')[0];
                    var rs = JSON.parse(result);
                    // Agregar campo manual arriba de la tabla
                    var filaManual = tab.insertRow(0);
                    filaManual.insertCell(0).style.display = "none"; // celda vacía oculta
                    filaManual.insertCell(1).innerHTML = `
                        <input type="text" id="txt_manual_desc" class="form-control" placeholder="Agregar Servicio">`;
                    filaManual.insertCell(2).innerHTML = `
                        <button type='button' onclick='insertarServicioManual()' class='btn btn-success btn-xs'>
                            <i class='fa fa-plus'></i> Seleccionar
                        </button>`;

                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.id;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.codigo;
                        cell.innerHTML = elem.descripcion;
                        cell.style.width = "70%";
                        ren.insertCell(2).innerHTML = "<button type='button' onclick='asignarServicio(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.nombre + " value=" + elem.id + "><i class='fa fa-plus'></i> Seleccionar</button>";
                    });
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    
}
function insertarServicioManual() {
    var desc = $("#txt_manual_desc").val();

    if (!desc.trim()) {
        new PNotify({ title: 'Advertencia', text: 'Ingrese una descripción', type: 'warning', styling: 'bootstrap3' });
        return;
    }

    var URL = base_url + "ordenes_trabajo/ajax_insertarServicioManual";

    $.ajax({
        type: "POST",
        url: URL,
        data: { descripcion: desc },
        success: function (idNuevo) {

            if (idNuevo) {
                asignarServicio(idNuevo);

            }
            
        },
        error: function (data) {
            new PNotify({ title: 'ERROR', text: 'Error al insertar servicio manual.', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        }
    });
}

function insertarPiezaManual() {
    var desc = $("#txt_manual_pieza").val();

    if (!desc.trim()) {
        new PNotify({ title: 'Advertencia', text: 'Ingrese una descripción', type: 'warning', styling: 'bootstrap3' });
        return;
    }

    var URL = base_url + "ordenes_trabajo/ajax_insertarPiezaManual";

    $.ajax({
        type: "POST",
        url: URL,
        data: { descripcion: desc },
        success: function (idNuevo) {

            if (idNuevo) {
                asignarPieza(idNuevo);

            }
            
        },
        error: function (data) {
            new PNotify({ title: 'ERROR', text: 'Error al insertar servicio manual.', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        }
    });
}
function buscarPiezas(){
    
    var URL = base_url + "/ordenes_trabajo/buscarPiezas";
    $('#tblPiezas tr').remove();  
        
        $.ajax({
            type: "POST",
            url: URL,
          //  data: { texto: texto },
            success: function(result) {
                
                if(result)
                {
                    
                    var tab = $('#tblPiezas tbody')[0];
                    var rs = JSON.parse(result);
                    var filaManual = tab.insertRow(0);
                    filaManual.insertCell(0).style.display = "none"; // celda vacía oculta
                    filaManual.insertCell(1).innerHTML = `
                        <input type="text" id="txt_manual_pieza" class="form-control" placeholder="Agregar Pieza">`;
                    filaManual.insertCell(2).innerHTML = `
                        <button type='button' onclick='insertarPiezaManual()' class='btn btn-success btn-xs'>
                            <i class='fa fa-plus'></i> Seleccionar
                        </button>`;
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.id;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.nombre;                        
                        ren.insertCell(2).innerHTML = `
                        <select class="form-control" name="medida_pieza">
                            <option value="Std">Std</option>
                            <option value="0.25 mm">0.25 mm</option>
                            <option value="0.50 mm">0.50 mm</option>
                            <option value="0.75 mm">0.75 mm</option>
                            <option value="1.0 mm">1.0 mm</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select>`;
ren.insertCell(3).innerHTML = "<button type='button' onclick='asignarPieza(this)' class='btn btn-primary btn-xs' data-empresa='" + elem.nombre + "' value='" + elem.id + "'><i class='fa fa-plus'></i> Seleccionar</button>";


                    });
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });   
}


function asignarProveedor(btn){
    var id = $(btn).val();
   
    
    var URL = base_url + "ordenes_trabajo/ajax_setCliente";
   //alert(CURRENT_QR);

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
            if(result)
            {
                 var rs = JSON.parse(result);
                 $('#nombre').text(rs.nombre);
                 $('#telefono').text(rs.telefono);
                 $('#correo').text(rs.correo);
                 document.getElementById("cliente").value = rs.id;
    $("#mdlClientes").modal('hide');

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}
function asignarServicio(btn) {
    var id;
    if (btn && typeof btn === 'object' ) {
    id = $(btn).val();
    }else{
        id=btn;
    }
    
    var URL = base_url + "ordenes_trabajo/ajax_setServicio";
    
    $('#tblServicio tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
            if (result) {
                var tab = $('#tblServicio tbody')[0];
                var rs = JSON.parse(result);

                $.each(rs, function(i, elem) {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML =
                        elem.magnitud +
                        " <input type='number' value='" + elem.precio + "' style='width:15%;' id='id_ser_" + elem.id + "'>" +
                        " <button onclick='eliminar_servicio(this)' type='button' class='btn btn-danger btn-xs' value='" + elem.id + "'><i class='fa fa-trash'></i> Eliminar</button>";
                });

                // Agrega una fila con el botón "Guardar todos"
                var filaBoton = tab.insertRow(tab.rows.length);
                var celda = filaBoton.insertCell();
                celda.colSpan = 1;
                celda.innerHTML = `
                    <div class="text-right">
                        <button type="button" onclick="guardar_todos_los_precios()"class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>`;

                //$("#mdlServicios").modal('hide');
            }
        },
        error: function(data) {
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        }
    });
}
function guardar_todos_los_precios_piezas() {
    var precios = [];

    // Recorre todas las filas con inputs numéricos
    $("#tblPiezasServ tbody tr").each(function () {
        var input = $(this).find("input[type='number']");
        if (input.length > 0) {
            var id = input.attr("id").replace("id_pi_", "");
            var precio = input.val();
            precios.push({ id: id, precio: precio });
        }
    });

    var URL = base_url + "ordenes_trabajo/ajax_setPrecioPiezasTemp";

    $.ajax({
        type: "POST",
        url: URL,
        data: { datos: JSON.stringify(precios) },
        success: function (result) {
            if (result) {
                var tab = $('#tblPiezasServ tbody')[0];
                tab.innerHTML = ""; // limpia tabla
                var rs = JSON.parse(result);

                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    //ren.insertCell().innerHTML = elem.nombre+"  <input type='number' value='" + elem.precio + "' style='width:15%;' id='id_pi_" + elem.id + "'><button onclick=eliminar_pieza(this) type='button' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash' ></i> Eliminar</button> ";
                ren.insertCell().innerHTML = elem.nombre;
ren.insertCell().innerHTML ="  <input type='number' value='" + elem.precio + "' style='width:40%;' id='id_pi_" + elem.id + "'>";
ren.insertCell().innerHTML = elem.size;
ren.insertCell().innerHTML = "  <button onclick=eliminar_pieza(this) type='button' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash' ></i> Eliminar</button> ";


                });

                 // Agrega una fila con el botón "Guardar todos"
                var filaBoton = tab.insertRow(tab.rows.length);
                var celda = filaBoton.insertCell();
                celda.colSpan = 1;
                celda.innerHTML = `
                    <div class="text-right">
                        <button type="button" onclick="guardar_todos_los_precios_piezas()" class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar 
                        </button>
                    </div>`;

                new PNotify({
                    title: 'Éxito',
                    text: 'Todos los precios han sido guardados correctamente.',
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
        },
        error: function (data) {
            new PNotify({
                title: 'ERROR',
                text: 'Ocurrió un error al guardar los precios.',
                type: 'error',
                styling: 'bootstrap3'
            });
            console.log(data);
        }
    });
}
function guardar_todos_los_precios() {
    var precios = [];

    // Recorre todas las filas con inputs numéricos
    $("#tblServicio tbody tr").each(function () {
        var input = $(this).find("input[type='number']");
        if (input.length > 0) {
            var id = input.attr("id").replace("id_ser_", "");
            var precio = input.val();
            precios.push({ id: id, precio: precio });
        }
    });

    var URL = base_url + "ordenes_trabajo/ajax_setPrecioTemp";

    $.ajax({
        type: "POST",
        url: URL,
        data: { datos: JSON.stringify(precios) },
        success: function (result) {
            if (result) {
                var tab = $('#tblServicio tbody')[0];
                tab.innerHTML = ""; // limpia tabla
                var rs = JSON.parse(result);

                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML =
                        elem.magnitud +
                        " <input type='number' value='" + elem.precio + "' style='width:15%;' id='id_ser_" + elem.id + "'>" +
                        " <button onclick='eliminar_servicio(this)' type='button' class='btn btn-danger btn-xs' value='" + elem.id + "'><i class='fa fa-trash'></i> Eliminar</button>";
                });

                // Vuelve a insertar el botón "Guardar todos"
                var filaBoton = tab.insertRow(tab.rows.length);
                var celda = filaBoton.insertCell();
                celda.colSpan = 1;
                celda.innerHTML = `
                    <div class="text-right">
                        <button type="button" class="btn btn-success" onclick="guardar_todos_los_precios()">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>`;

                new PNotify({
                    title: 'Éxito',
                    text: 'Todos los precios han sido guardados correctamente.',
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
        },
        error: function (data) {
            new PNotify({
                title: 'ERROR',
                text: 'Ocurrió un error al guardar los precios.',
                type: 'error',
                styling: 'bootstrap3'
            });
            console.log(data);
        }
    });
}
function asignarPieza(btn){
    var id;
    if (btn && typeof btn === 'object') {
        id = $(btn).val();
    } else {
        id = btn;
    }

    var fila = $(btn).closest("tr");
    var size = fila.find("select[name='medida_pieza']").val();

    var URL = base_url + "ordenes_trabajo/ajax_setPieza";
    $('#tblPiezasServ tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id, size: size },
        success: function(result) {
            if(result) {
                var tab = $('#tblPiezasServ tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = "<input type='number' value='" + elem.precio + "' style='width:40%;' id='id_pi_" + elem.id + "'>";
                    ren.insertCell().innerHTML = elem.size;
                    ren.insertCell().innerHTML = "<button onclick='eliminar_pieza(this)' type='button' class='btn btn-danger btn-xs' value='" + elem.id + "'><i class='fa fa-trash'></i> Eliminar</button>";                
                });
                var filaBoton = tab.insertRow(tab.rows.length);
                var celda = filaBoton.insertCell();
                celda.colSpan = 1;
                celda.innerHTML = `
                    <div class="text-right">
                        <button type="button" onclick="guardar_todos_los_precios_piezas()" class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar 
                        </button>
                    </div>`;
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        }
    });
}


function eliminar_pieza(btn){
    var id = $(btn).val();
    
    var URL = base_url + "ordenes_trabajo/ajax_delPieza";
$('#tblPiezasServ tbody tr').remove();
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
            if(result)
            {

                var tab = $('#tblPiezasServ tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
ren.insertCell().innerHTML = elem.nombre;
ren.insertCell().innerHTML ="  <input type='number' value='" + elem.precio + "' style='width:40%;' id='id_pi_" + elem.id + "'>";
ren.insertCell().innerHTML = elem.size;
ren.insertCell().innerHTML = "  <button onclick=eliminar_pieza(this) type='button' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash' ></i> Eliminar</button> ";

                  //  ren.insertCell().innerHTML = elem.nombre+"  <input type='number' value='" + elem.precio + "' style='width:15%;' id='id_pi_" + elem.id + "'><button onclick=eliminar_pieza(this) type='button' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash' ></i> Eliminar</button> ";
                });
                 // Agrega una fila con el botón "Guardar todos"
                var filaBoton = tab.insertRow(tab.rows.length);
                var celda = filaBoton.insertCell();
                celda.colSpan = 1;
                celda.innerHTML = `
                    <div class="text-right">
                        <button type="button" onclick="guardar_todos_los_precios_piezas()" class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar 
                        </button>
                    </div>`;

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}
function eliminar_servicio(btn){
    var id = $(btn).val();
    
    var URL = base_url + "ordenes_trabajo/ajax_delServicio";
$('#tblServicio tbody tr').remove();
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
            if(result)
            {

                var tab = $('#tblServicio tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.magnitud+"  <input type='number' value=" + elem.precio + " style='width:15%;'  id='id_ser_"+elem.id+"'></input>"+"<button onclick=eliminar_servicio(this) type='button' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash' ></i> Eliminar</button> ";
                });
                 // Agrega una fila con el botón "Guardar todos"
                var filaBoton = tab.insertRow(tab.rows.length);
                var celda = filaBoton.insertCell();
                celda.colSpan = 1;
                celda.innerHTML = `
                    <div class="text-right">
                        <button type="button" onclick="guardar_todos_los_precios()" class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>`;

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function iniciar_daterangepicker() {
    $("#txtFechaAccion").daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        timePickerIncrement: 15,
           formatTime:"h:i a",

        locale: {
            format: 'YYYY-MM-DD H:mm'
        }
    });
}


function buscarUsuarios(){
    
    var URL = base_url + "/ordenes_trabajo/buscarUsuarios";
    $('#tblUsuarios tr').remove();
  /*  var texto = $("#txtBuscarProveedor").val();
    texto = texto.trim();*/
    
    
        
        $.ajax({
            type: "POST",
            url: URL,
          //  data: { texto: texto },
            success: function(result) {
                
                if(result)
                {
                    
                    var tab = $('#tblUsuarios tbody')[0];
                    var rs = JSON.parse(result);
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.id;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.name;
                        cell.style.width = "70%";
                        ren.insertCell(2).innerHTML = "<button type='button' onclick='asignarUsuario(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.name + " value=" + elem.id + "><i class='fa fa-plus'></i> Seleccionar</button>";
                    });
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    
}
function asignarUsuario(btn){
    var id = $(btn).val();
   
    var URL = base_url + "ordenes_trabajo/ajax_setUsuarios";
   

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
            if(result)
            {
                 var rs = JSON.parse(result);
                 $('#name').text(rs.name);
                 $('#correoU').text(rs.correo);
                 document.getElementById("usuario").value = rs.id;
                 $("#mdlUsuarios").modal('hide');

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}
/*function enviarSolicitud(){
   
var URL = base_url + "ordenes_trabajo/ajax_setWO";
var cliente = $('#cliente').val();
//var servicio = $('#servicio').val();
var usuario = $('#usuario').val();
var fecha =$('#txtFechaAccion').val().trim();
var descripcion = $('#descripcion_trabajo').val().trim();
var piezas = $('#piezas').val();
var vehiculo = $('#vehiculo').val();
var motor = $('#motor').val();
$.ajax({
        type: "POST",
        url: URL,
        data: {cliente:cliente, usuario:usuario, fecha:fecha, descripcion:descripcion, piezas:piezas, motor:motor, vehiculo:vehiculo },
        success: function(result) {
            if(result)
            {
                var rs= JSON.parse(result);
               // window.location.href = base_url + 'ordenes_trabajo/ver_wo/'+rs;

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

}*/
function enviarSolicitud() {
    var cliente = $('#cliente').val().trim();
    var usuario = $('#usuario').val().trim();
    var fecha = $('#txtFechaAccion').val().trim();
    var descripcion = $('#descripcion_trabajo').val().trim();
   // var piezas = $('#piezas').val().trim();
    var vehiculo = $('#vehiculo').val().trim();
    var motor = $('#motor').val().trim();

    // Validación de campos vacíos
    if (!cliente || !usuario || !fecha || !descripcion) {
        alert('Campos incompletos');
    }

    // Validar si la tabla de servicios tiene al menos una fila (asumiendo id="tablaServicios")
    else if ($('#tblServicio tbody tr').length === 0) {
        alert("Servicios vacíos");
    }
else{
    var URL = base_url + "ordenes_trabajo/ajax_setWO";

    $.ajax({
        type: "POST",
        url: URL,
        data: {
            cliente: cliente,
            usuario: usuario,
            fecha: fecha,
            descripcion: descripcion,
            motor: motor,
            vehiculo: vehiculo
        },
        success: function(result) {
            if (result) {
                var rs = JSON.parse(result);
                window.location.href = base_url + 'ordenes_trabajo/ver_wo/'+rs;
            }
        },
        error: function(data) {
            new PNotify({
                title: 'ERROR',
                text: 'Error al enviar la solicitud.',
                type: 'error',
                styling: 'bootstrap3'
            });
            console.log(data);
        }
    });
}
}

function guardar_precio(id){
    var total = $("#id_ser_"+id).val();
    
    var URL = base_url + "ordenes_trabajo/ajax_setPrecioTemp";
   //alert(CURRENT_QR);
$('#tblServicio tbody tr').remove();
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id, total:total },
        success: function(result) {
            if(result)
            {
                 var tab = $('#tblServicio tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.magnitud+"  <input type='number' value=" + elem.precio + " style='width:15%;'  id='id_ser_"+elem.id+"'></input>"+"<button onclick=eliminar_servicio(this) type='button' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash' ></i> Eliminar</button> ";
                });

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}