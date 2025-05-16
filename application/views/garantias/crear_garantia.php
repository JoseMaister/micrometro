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
   .switch {
   position: relative;
   display: inline-block;
   width: 40px;
   height: 24px;
   }
   .switch input { 
   opacity: 0;
   width: 0;
   height: 0;
   }
   .slider {
   position: absolute;
   cursor: pointer;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background-color: #ccc;
   -webkit-transition: .4s;
   transition: .4s;
   }
   .slider:before {
   position: absolute;
   content: "";
   height: 16px;
   width: 16px;
   left: 4px;
   bottom: 4px;
   background-color: white;
   -webkit-transition: .4s;
   transition: .4s;
   }
   input:checked + .slider {
   background-color: #00913f;
   }
   input:focus + .slider {
   box-shadow: 0 0 1px #00913f;
   }
   input:checked + .slider:before {
   -webkit-transform: translateX(16px);
   -ms-transform: translateX(16px);
   transform: translateX(16px);
   }
   /* Rounded sliders */
   .slider.round {
   border-radius: 34px;
   }
   .slider.round:before {
   border-radius: 50%;
   }
</style>
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Crear garantia:
                     <?= 'Venta-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>
                  </h2>
                  <button type='button' onclick="enviarSolicitud()" class='btn btn-success btn-md pull-right solicitud' id="btnEnviar"><i class='fa fa-send'></i> Crear Garantia</button> 
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
                           <div id="divCliente"  class="x_content">
                              <label>Cliente/Customer:</label>
                              <p><?=$venta->nombre?></p>
                              <p><?=$venta->dir_fiscal?></p>
                              <p><?=$venta->correo?></p>
                              <p>Telefono: <?= $venta->telefono?> </p>
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-4">
                              <label style="display: block;">Garantia</label>
                              <button type="button" onclick="mdlGarantia()" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
                              <textarea id="garantia" readonly></textarea>
                              <label style="display: block;">Motivo</label>
                              <textarea id="motivo"></textarea>
                              <label style="display: block;">Accion</label>
                              <textarea id="accion"></textarea>
                           </div>
                        </div>
                     </div>
                     <!-- D A T O S -->
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div style="border: 0px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div class="x_content">
                              <div id="rowEstatus" style=" margin-top: 30px;" class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <center>
                                       <label style="display: block">Vendedor:</label>
                                       <p><?=$venta->vendedor?></p>
                                       <label style="display: block">Fecha:</label>
                                       <p><?=$venta->fecha?></p>
                                       <label style="display: block">Total:</label>
                                       <p><?="$ ".$venta->total_final?></p>
                                       <label style="display: block">Cambio de Articulo:</label>
                                       <label class="switch">
                                       <input type="checkbox" id="articulo" value="1">
                                       <span class="slider round"></span>
                                       </label>
                                       <br>
                                       <label style="display: block">Devolucion de Dinero:</label>
                                       <label class="switch">
                                       <input type="checkbox" id="dinero" value="1">
                                       <span class="slider round"></span>
                                       </label>
                                       <br>
                                       <label style="display: block">Credito en Tienda:</label>
                                       <label class="switch">
                                       <input type="checkbox" value="credito" value="1">
                                       <span class="slider round"></span>
                                       </label>
                                    </center>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div style="border: 0px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div class="x_content">
                              <div id="rowEstatus" style=" margin-top: 30px;" class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <center>
                                       <label style="display: block">Detalles de venta:</label>
                                       <br>
                                       <div id="divCliente"  class="x_content">
                                          <table id="tblConceptosRS" class="data table table-striped no-margin">
                                             <thead>
                                                <tr>
                                                   <th class="text-center">#Ticket</th>
                                                   <th class="text-center">Codigo</th>
                                                   <th class="text-center">Producto</th>
                                                   <th class="text-center">Cantidad</th>
                                                   <th class="text-center">Total</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                   if($detalles) { $i = 1;
                                                    foreach ($detalles as $elem) { ?>
                                                <tr class="even pointer">
                                                   <td  class="text-center"><?= str_pad($elem->id_venta, 6, "0", STR_PAD_LEFT) ?></td>
                                                   <td  class="text-center"><?= $elem->codigo ?></td>
                                                   <td class="text-center"><?= $elem->producto ?></td>
                                                   <td  class="text-center"><?= $elem->qty ?></td>
                                                   <td  class="text-center"><?= $elem->precio ?></td>
                                                </tr>
                                                <?php $i++; }
                                                   }
                                                   ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </center>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
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

<div id="mdlGarantia" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="lblCodigo">Agregar Garantia</h4>
         </div>
         <div class="modal-body">
            <div class="x_content">
               <div class="table-responsive">
                  <table id="tabla_garantias" class="table table-bordered">
                     <thead>
                        <tr class="headings">
                           <th class="column-title text-center">Titulo</th>
                           <th class="column-title text-center">Descripcion</th>
                           <th class="column-title text-center">Opc.</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
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
   function mdlGarantia(id) {
    var URL = base_url + "ventas/ajax_getCatalogoGarantias";
    $('#tabla_garantias tbody tr').remove();
     $.ajax({
            type: "POST",
            url: URL,
            data: {},
            success: function(result) {
                if(result)
                {
                   var tab = $('#tabla_garantias tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = elem.titulo;
                    ren.insertCell().innerHTML = elem.descripcion;
                    ren.insertCell().innerHTML = "<button type='button' onclick='asignar(this)' class='btn btn-primary btn-xs'  value=" + elem.id + "><i class='fa fa-plus'></i> </button>";

                    
                });
                $('#mdlGarantia').modal();
                }
            },
        });
}
function asignar(btn){
    var id = $(btn).val();
    const garantia = document.getElementById('garantia');
    garantia.value='';
   
    
    var URL = base_url + "ventas/ajax_getGarantia";
   //alert(CURRENT_QR);

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id },
        success: function(result) {
           var rs = JSON.parse(result);
               garantia.value = rs.descripcion;
	       $('#mdlGarantia').modal('hide');

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
