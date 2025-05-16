<!-- page content -->
<?php
   $item=null;
   ?>
   <style type="text/css">
     [type="file"] {
  height: 0;
  overflow: hidden;
  width: 0;
}

[type="file"] + label {
  background: #5cb85c;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  display: inline-block;
   font-family: 'Rubik', sans-serif;
   font-size: inherit;
  font-weight: 500;
  margin-bottom: 1rem;
  outline: none;
  padding: 1rem 50px;
  position: relative;
  transition: all 0.3s;
  vertical-align: middle;
  
  
  
 
}


   </style>
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Retiros
                  </h2>


                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <!-- C L I E N T E -->
                           <div class="col-md-4 col-sm-4 col-xs-4">
                        <div style="border: 0; margin-bottom: 0 px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div class="col-md-8 col-sm-8 col-xs-8">
                           <form method="POST" action=<?= base_url('retiros/registrar_retiro') ?> class="form-horizontal form-label-left" >
                           <h3>Cantidad a retirar</h3>
                           <input style="text-transform: uppercase;" id="retiro" class="form-control col-md-7 col-xs-12" name="retiro" placeholder="" required="required" type="number" min="0">
                           <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">Retirar</button>
                                </div>
                            </div>
                        </form>
                        </div>

                        </div>
                     </div>
                     <!-- D A T O S -->
                     <div class="col-md-8 col-sm-8 col-xs-6">
                        <div style="border: 0px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div class="x_content">
                             
                                 
                                    <h1>Total Efectivo en Caja: $ <?= $total_efectivo->total?></h1>
                                    <h1>Total Ventas En Efectivo: $ <?= $total_ventas_efectivo->total?></h1>
                                    <h1>Total Ventas En Tarjeta: $ <?= $total_tarjeta->total?></h1>
                                    <h1>Total Anticipos Ventas: $ <?= $anticipo_ventas->total?></h1>
                                    <h1>Total Anticipos Servicios: $ <?= $anticipo->dia?></h1>

                                    <h1>Total Retiros: $ <?= $total_retiro->total?></h1>
                                    <h1>Total al Dia: $ <?= $total_dia->dia?></h1>
                                    <h1>Total al Dia en Ventas/Anticipos: $ <?= $total_dia->dia+$anticipo->dia?></h1>

                               
                            
                           </div>
                        </div>
                     </div>




                  </div>
               </div>
            </div>
         </div>
      </div>
     
<!-- MODAL RS -->
<div id="mdlRS" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ingrese RS</h4>
         </div>
         <div class="modal-body">
            <form>
               <h3 style="display: none;" id="lblRS"></h3>
               <div class="input-group">
                  <input id="txtBuscarRS" type="text" class="form-control" placeholder="Buscar RS...">
                  <span class="input-group-btn">
                  <button onclick="buscarRS()" class="btn btn-default" type="button">Buscar</button>
                  </span>
               </div>
               <div id="divSelectTodo" style="display: none"><input id="iptTodo" type="checkbox" class="flat"> Seleccionar Todo</div>
               <table class="data table table-striped no-margin">
                  <thead>
                     <tr>
                        <th>Selecc.</th>
                        <th>RS</th>
                        <th>Item</th>
                        <th>Descripción</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </form>
         </div>
         <div class="modal-footer">
            <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
            <button onclick="agregarRSItems()" type="button" class="btn btn-primary"><i class='fa fa-check'></i> Agregar</button>
         </div>
      </div>
   </div>
</div>
<!-- /footer content -->
</div>
</div>

<div id="mdlTicket" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Seleccionar Tickets</h4>
         </div>
          <div class="modal-body">
                <form>
                    <br>
                    <table id="tblTickets" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
      </div>
   </div>
</div>

<div id="mdlComentario" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 id='mdlComentarioTitle' class="modal-title">Rechazar Item</h4>
         </div>
         <div class="modal-body">
            <form>
               <label>Comentario</label>
               <textarea style="height: 60px; resize: none;" id="txtComentarios" class="form-control"></textarea>
            </form>
         </div>
         <div class="modal-footer">
            <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
            <button id="btnComentario" type="button" onclick="agregarComentario(<?=$id?>)" class="btn btn-primary btn-sm"><i class='fa fa-times-comment'></i> Agregar</button>
         </div>
      </div>
   </div>
</div>

<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- formatCurrency -->
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- bootstrap-wysiwyg -->
<script src=<?=base_url("template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"); ?>></script>
<script src=<?=base_url("template/vendors/jquery.hotkeys/jquery.hotkeys.js"); ?>></script>
<script src=<?=base_url("template/vendors/google-code-prettify/src/prettify.js"); ?>></script>
<!-- jQuery Tags Input -->
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/garantias/js/garantias.js"); ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- FancyBOX -->
<script src=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.js"); ?>></script>
<script> 
var venta='<?=$id?>' ;
   $(function(){
       load();
   });
   
 function load(){
   //cargarComentarios(wo);
 }  
$(document).ready(function () {

    /* This is basic - uses default settings */

    $("a#single_image").fancybox();

    /* Using custom settings */

    $("a#inline").fancybox({
        'hideOnContentClick': true
    });

    /* Apply fancybox to multiple items */

    $("a.group").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false
    });
});

$(document).ready(function() {                       
    $("#tipo_cal").change(function() {
    tipo = $('#tipo_cal').val();
    var x = document.getElementById("textarea");
    if (tipo == 'Normal') {
        $('#textarea').hide();

    }else{
         $('#textarea').show();

    }
    
    });
});
function mdlTicket(){
  
    $("#mdlTicket").modal();
    buscarTickets();
}
function buscarTickets(){
    
    var URL = base_url + "/ordenes_trabajo/ajax_get_ticktes";
    $('#tblTickets tr').remove();
  /*  var texto = $("#txtBuscarProveedor").val();
    texto = texto.trim();*/
    
    
        
        $.ajax({
            type: "POST",
            url: URL,
          //  data: { texto: texto },
            success: function(result) {
                
                if(result)
                {
                    
                    var tab = $('#tblTickets tbody')[0];
                    var rs = JSON.parse(result);
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.idToolCrib;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.idToolCrib.padStart(6,"0");;
                        cell.style.width = "70%";
                        ren.insertCell(2).innerHTML = "<button type='button' onclick='asignarTicket(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.estatus + " value=" + elem.idToolCrib + "><i class='fa fa-plus'></i> Seleccionar</button>";
                    });
                }

            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    
}
function asignarTicket(btn){
    var id = $(btn).val();

   
    
    var URL = base_url + "ordenes_trabajo/ajax_setTicket_garantia";
   //alert(CURRENT_QR);

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id, venta:venta },
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

function mdlComentario(){
    $('#txtComentarios').val("");
    $('#btnComentario').show();
    $('#btnRechazar').hide();
    $('#mdlComentarioTitle').text('Agregar Comentario');
    $('#mdlComentario').modal();
}

function agregarComentario(id){
    var URL = base_url + "ordenes_trabajo/ajax_setComentarios";
    var comentario = $("#txtComentarios").val().trim();

    if(comentario.length > 0)
    {
        

        $.ajax({
            type: "POST",
            url: URL,
            data: { comentario : comentario, wo:wo },
            success: function(result) {
                if(result)
                {
                    $('#mdlComentario').modal('hide');
                    cargarComentarios(id);
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
    else{
        alert("Comentario en blanco");
    }
}
function cargarComentarios(id){
    var URL = base_url + "ordenes_trabajo/ajax_getComentarios";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                $('#ulComments').html("");
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var c = '<li>'
                    +    '<a>'
                    +        '<span>'
                    +            '<small>' + elem.nombre + '<small> ' + moment(elem.fecha).format('D/MM/YYYY h:mm A') + '</small></span>'
                    +        '</span>'
                    +        '<span class="message">' + elem.comentario + '</span>'
                    +    '</a>'
                    +'</li>';
                    $('#ulComments').append(c);
                });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

</script>
</body>
</html>