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
                  <h2>
                     <?= 'Garantia-' . str_pad($id, 6, "0", STR_PAD_LEFT) ?>
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
                           <div id="divCliente"  class="x_content">
                             
                              <label>Cliente/Customer:</label>
                              <p><?=$venta->nombre?></p>
                              <p><?=$venta->dir_fiscal?></p>
                              <p><?=$venta->correo?></p>
                              <p>Telefono: <?= $venta->telefono?> </p>
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-4">
                           <label style="display: block;">Motivo</label>
                           <p id="motivo"><?= $venta->motivo?></p>
                           <label style="display: block;">Accion</label>
                           <p id="accion"><?= $venta->accion?></p>
                                  <?php
                                    if($ticket) { $i = 1;
                           
                           
                         ?>
                                         <label style="display: block;">Tickets Tool Crib</label>
                                          <?php
                           
                                     foreach ($ticket as $elem) { ?>
                                       
                                        <button class="btn btn-success btn-xs"><a target="_blank" href='<?= base_url('/toolcrib/verPedido/'.$elem->idToolCrib)?>'><?=  str_pad($elem->idToolCrib, 6, "0", STR_PAD_LEFT)?></a> </button>

                            <?php
                            }}
                         ?>
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
                                         <input type="checkbox" id="articulo" <?= $venta->articulo == '1' ? 'checked' : '' ?> disabled>
                                         <span class="slider round"></span>
                                       </label>
                                       <br>
                                       <label style="display: block">Devolucion de Dinero:</label>
                                       <label class="switch">
                                         <input type="checkbox" id="dinero" <?= $venta->dinero == '1' ? 'checked' : '' ?> disabled>
                                         <span class="slider round"></span>
                                       </label>
                                       <br>
                                       <label style="display: block">Credito en Tienda:</label>
                                       <label class="switch">
                                         <input type="checkbox" value="credito" <?= $venta->credito == '1' ? 'checked' : '' ?> disabled>
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
<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Solicitud de Refacciones</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      
                          <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p style="display: inline;">
                                        
                                        Código :
                                        <input type="radio" class="flat" name="rbBusqueda" id="codigo" value="codigo" checked />
                                        Producto : 
                                        <input type="radio" class="flat" name="rbBusqueda" id="prod" value="prod"/>
                                    
                                    </p>


                                    <input id="txtBuscar" style="display: inline;" type="text" name="txtBuscar">


                                    <button id="btnBuscar" onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>

                                </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                        <!--<button onclick="agregar()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar Requisito </button>-->
                            <div class="table-responsive">
                                <table id="tabla" class="table table-bordered" >
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title text-center">Codigo</th>
                                            <th class="column-title text-center">Producto</th>
                                            <th class="column-title text-center">Descripcion</th>
                                            
                                            <th class="column-title text-center">Marca</th>
                                            <th class="column-title text-center">Modelo</th>
                                            <th class="column-title text-center">Stock</th>
                                            <th class="column-title text-center">Precio</th>
                                            
                                            
                                            
                                            
                                            <th class="column-title text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if($productos) { $i = 1;
                                     foreach ($productos->result() as $elem) { ?>

                                            <tr class="even pointer">
                                                <td  class="text-center"><?= $elem->codigo ?></td>
                                                <td  class="text-center"><?= $elem->producto ?></td>
                                                <td style="width: 500px;"><?= $elem->descripcion ?></td>
                                                <td  class="text-center"><?= $elem->marca ?></td>
                                                <td  class="text-center"><?= $elem->modelo ?></td>
                                                <td  class="text-center"><?= $elem->cantidad ?></td>
                                                
                                                <td  class="text-center"><?= "$ ".$elem->precio ?></td>
                                                
                                                
                                                
                                                
                                                <td class="text-center">
                                                    <form method="POST" action=<?= base_url('ventas/registrarVentaTool') ?>>
                                                        <input id='cantidad'  type='number' name='cantidad' min='0' max='10' class='border' required>
                                                        <input id='producto' style='display: inline;' type='hidden' name='producto' value="<?= $elem->idProducto ?>">
                                                        <input id='id_garantia' style='display: inline;' type='hidden' name='id_garantia' value="<?= $id ?>">



                                                        <button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Agregar </button>
                                                    </form>
                                               
                                                
                                                </td>
                                            </tr>
                                    <?php $i++; }
                                      }
                                    ?>
                                   
                                    </tbody>

                                </table>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                   <!-- <button id="send" type="submit" class="btn btn-success">Agregar producto</button>-->
                                </div>

                            </div>
                        </form>
                        
                        

                        
                            
                              
                            
                        






                    </div>

                    <div class="x_content">
                        <!--<button onclick="agregar()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar Requisito </button>-->
                            <div class="table-responsive">
                                  <?php

                                    if($tool) { 
                                    //echo var_dump($venta->result());die();

                                        ?>
                                <table  class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title text-center">Codigo</th>
                                            <th class="column-title text-center">Producto</th>
                                            <th class="column-title text-center">Cantidad</th>
                                            <th class="column-title text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    
                                     foreach ($tool->result() as $elem) { 


                                        ?>

                                            <tr class="even pointer">
                                                
                                                <td class="text-center"><?= $elem->codigo ?></td>
                                                <td class="text-center"><?= $elem->producto ?></td>
                                                <td class="text-center"><?= $elem->cantidad ?></td>
                                                <td class="text-center">
                                                <a href=<?= base_url("ventas/cancelarProducto/".$elem->idvt."/".$id); ?>><button type="button"class="btn btn-danger btn-xs"><i class="fa fa-eye"></i> Eliminar </button></a>                                                
                                                </td>
                                               
                                            </tr>
                                    <?php }
                                      
                                    ?>
                                    </tbody>

                                </table>
                                <form method="POST" action=<?= base_url('ventas/registrarPedido') ?>>
                                    <input id='garantia' style='display: inline;' type='hidden' name='garantia' value="<?= $id ?>">

                                
                               
                                 <?php }
                                      
                                    ?>
                                    <button id="send" type="submit" class="btn btn-primary">Realizar pedido</button>
                                    

                                    </form>
                            </div>


                        </div>




                </div>
            </div>
        </div>
<!-- /footer content -->
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

 <script>

function buscar(){
    var URL = base_url + "toolcrib/productos";
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
                    ren.insertCell(0).innerHTML = elem.codigo;
                    ren.insertCell(1).innerHTML = elem.producto;
                    ren.insertCell(2).innerHTML = elem.descripcion;
                    ren.insertCell(3).innerHTML = elem.marca;
                    ren.insertCell(4).innerHTML = elem.modelo;
                    ren.insertCell(5).innerHTML = elem.cantidad;
                    ren.insertCell(6).innerHTML = "$ "+elem.precio;
                    ren.insertCell(7).innerHTML = "<form method='POST' action="+base_url+"toolcrib/registrarVenta><input id='cantidad'  type='number' name='cantidad' min='0' max='10' class='border' required><input id='producto' style='display: inline;' type='hidden' name='producto' value="+elem.idProducto+"><button type='submit'class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Agregar </button></form>";

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

</script>
<script type="text/javascript">
    function compra()
{
   var cantidad = $("#cantidad").val();
   var producto = $("#producto").val();
   alert(cantidad);

    $.ajax({
        type: "POST",
        url: '<?= base_url('toolcrib/registrarVenta') ?>',
        data: { cantidad : cantidad, producto : producto},
        error: function(data){
          alert("Errorri");
          console.log(data);
        },
      });
    location.reload();
  
}
</body>
</html>