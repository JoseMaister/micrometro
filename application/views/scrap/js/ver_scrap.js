var TOTAL;
var venta;
function load() {
   TOTAL;
}
function mdlVenta() {
    $("#mdlVenta").modal();
    $("#btnCerrar").hide();
}
function  cobrar() {
    var total = document.getElementById('total').textContent;
    var monto = $('#monto').val();
    total=total.substring(8);
    if (monto < total) {

        var r=total-monto;
      $("#total").text("Total: $"+r);
    
    }else if(total => monto){
        var re = monto - total;
        $("#cambio").text("Cambio: $"+re);
         $("#btnCombrar").hide();
         $("#btnCerrar").show();


    }
}
function cerrar_compra(id) {
    
    var motivo=$( "#motivo" ).val();

     var URL = base_url + 'scrap/ajax_cerrar_venta';
    $.ajax({
            type: "POST",
            url: URL,
            data: { motivo:motivo, id:id},
            success: function(result) {
                if(result)
                {   
                    //window.location.href = base_url + 'scrap/catalogo';

                }
            },
        });
}
function descuento(){
    var descuento = $("input[name=rbDescuento]:checked").val();
    var total = document.getElementById('total').textContent;


    total=total.substring(8);
    var des=0;
    var total_final=0;
    if (descuento == "otro") {
        $("#descuento").show()

    }else{
        $("#descuento").hide();
         desc = descuento/100;
        desc = desc * TOTAL;
        total_final = TOTAL-desc;
         $("#total").text("Total: $"+total_final);
        //alert(total_final);
    }
}
function aplicar_descuento() {

    var des=0;
    var total_final=0;

    var tipo=$("#tipo_descuento" ).val();
    var txt_desc=$( "#txtDescuento" ).val();
    

    if (tipo=="efectivo") {
        total_final = TOTAL-txt_desc;
         $("#total").text("Total: $"+total_final);

    }else if (tipo=="porcentaje") {
         desc = txt_desc/100;
        desc = desc * TOTAL;
        total_final = TOTAL-desc;
         $("#total").text("Total: $"+total_final);

    }
}
function modalAsignarCliente(){
    $("#mdlClientes").modal();
}
function buscarCliente(){
    var URL = base_url + "/ventas/ajax_getClientes";
    $('#tblBuscarClientes tr').remove();
    var cliente = $("input[name=rbCliente]:checked").val();
    var texto = $("#txtBuscarCliente").val();
    texto = texto.trim();
    
    if(texto)
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { texto: texto, cliente:cliente },
            success: function(result) {
                if(result)
                {
                    var tab = $('#tblBuscarClientes tbody')[0];
                    var rs = JSON.parse(result);
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.id;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.nombre;
                        cell.style.width = "70%";
                        ren.insertCell(2).innerHTML = "<button type='button' onclick='infoCliente(this)' class='btn btn-default btn-xs' value=" + elem.id + "><i class='fa fa-info-circle'></i> Info </button> <button type='button' onclick='asignarCliente(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.nombre + " value=" + elem.id + "><i class='fa fa-plus'></i> Asignar</button>";
                    });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }

}


function infoCliente(btn){
    var id = $(btn).val();
    var URL = base_url + "ventas/ajax_getCliente"
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);

                $("#cliente").html(rs.nombre);
                $("#lstTelefono").html("Telefono: "+rs.telefono);
                $("#lstCorreo").html("Correo: "+rs.correo);
                $("#lstRFC").html("RFC: "+rs.rfc);
                $("#lstDire").html("Direccion Fiscal: "+rs.dir_fiscal);                
                $('#mdlInfo').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}
function asignarCliente(btn){
    var id= $(btn).val();
   
    
    var URL = base_url + "ventas/ajax_setCliente";
   //alert(CURRENT_QR);

    $.ajax({
        type: "POST",
        url: URL,
        data: { venta : venta, id: id },
        success: function(result) {
            if(result)
            {
               window.location.reload();

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}