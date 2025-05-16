<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                     <h2>Punto de ventas</h2>
                     <?php 
                    // echo var_dump($caja->tipo);die();
                        if (empty($caja) || $caja->caja != 'APERTURA') {
                      ?>
                     <button onclick="mdlAbrirCaja()" style="display: inline;" class="btn btn-primary  btn-md pull-right" type="button"><i class="glyphicon glyphicon-check"></i> Abrir Caja</button>
                     <?php
                     }elseif ($caja || $caja->caja == 'APERTURA') {
                       
                     ?>
                     <button onclick="mdlCerrarCaja()" style="display: inline;" class="btn btn-danger btn-md  pull-right" type="button"><i class="fa fa-close"></i> Cerrar Caja</button>
                     <?php
                  }
                     ?>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content" >
                     <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php
                        if ($caja) {
                     if ($caja->caja == 'APERTURA') {
                       
                     ?>
                    
                     <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                        Marca 
                     </p>
                     <select  style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="slug" name="slug">
                        <option value="0"></option>
                        '
                        <?php foreach ($marcas as $elem) { 
                           echo '<option value="'.$elem->id.'">'.$elem->Nombre.'</option>';
                           } ?>
                     </select>
                     <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                        Modelo 
                     </p>
                     <select  style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="modAuto" name="modAuto">
                    
                     </select>
                     <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                        Año 
                     </p>
                     <select  style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="year" name="year">
                    
                     </select>
                     <p style="display: inline; margin-right: 10px; margin-left: 10px;">
                        Motor 
                     </p>
                     <select  style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="motor" name="motor">
                    
                     </select>
                     <br>
                     <br>
                     <p style="display: inline;">
                        Producto:
               
                     <input id="txtBusqueda" name="txtBusqueda" style="display: inline;" type="text" >
                     <button onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>
                  </p>
                     <?php
                  }}
                     ?>
                     <div class="table-responsive" >
                        <table id="punto_venta" class="table table-striped">
                           <thead>
                              <tr class="headings">
                                 <!--<th class="column-title">Responsable</th>-->
                                 <th >Codigo</th>
                                 <th >Producto</th>
                                 <th >Local</th>
                                 <th >Precio</th>
                                 <th>Opciones</th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>

</div>   
<div class="col-md-4 col-sm-4 col-xs-12 "> 
     <?php
     if ($caja) {
                     if ($caja->caja == 'APERTURA') {
                       
                     ?>
   <div class="x_panel"  style="text-align: center; overflow: hidden; margin: 10px;">
   <h3>Carrito</h3>
   <div class="table-responsive" >
                        <table id="carrito" class="table table-striped">
                           <thead>
                              <tr class="headings">
                                 <!--<th class="column-title">Responsable</th>-->
                                 <th >Codigo</th>
                                 <th >Producto</th>
                                 <th >Local</th>
                                 <th >Cant.</th>
                                 <th >Precio</th>
                                 <th >Total</th>
                                 
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                        <label id="total" class="pull-right"></label>
                     </div>
                     <button class="btn btn-danger btn-md pull-left" onclick="cancelar_venta();"><i class="glyphicon glyphicon-trash"></i> Cancelar</button>
                       <button class="btn btn-success btn-md pull-right" onclick="realizar_venta();"><i class="glyphicon glyphicon-check"></i> Realizar</button>
</div>
<?php
                 } }
                     ?>
</div>

<div id="mdlLocal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Seleccionar Local</h4>
         </div>
          <div class="modal-body">
                <form>
                    <br>
                    <table id="tblLocal" class="data table table-striped no-margin">
                     <thead>
                              <tr class="headings">
                                 <th >Local</th>
                                 <th >Stock</th>
                                 <th ></th>
                              </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
      </div>
   </div>
</div>

<div id="mdlAbrirCaja" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Apertura de Caja</h4>
         </div>
          <div class="modal-body">
                <form>
               <label>Saldo Inicial</label>
               <input id="total_apertura" type="number" min="0"></input>
                </form>
            </div> 
            <div class="modal-footer">
            <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
            <button id="btnComentario" type="button" onclick="abrirCaja()" class="btn btn-success btn-sm"><i class='fa fa-times-comment'></i> Aceptar</button>
         </div>
      </div>
   </div>
</div>
<div id="mdlCerrarCaja" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Cerrar Caja</h4>
         </div>
          <div class="modal-body">
                <form>
               <label>Topo</label>
               <select style="width:90%;" required="required" class="select2_single form-control" id="tipo_corte" name="tipo_corte">
                  <option value="PARCIAL">Corte Parcial de Caja</option>   
                  <option value="TOTAL">Corte Total de Caja</option>
               </select>
                </form>
            </div> 
            <div class="modal-footer">
            <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
            <button id="btnComentario" type="button" onclick="cerrarCaja()" class="btn btn-success btn-sm"><i class='fa fa-times-comment'></i> Aceptar</button>
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
</div>
<!-- /page content -->
<!-- footer content -->
<footer>
   <div class="pull-right">
   </div>
   <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>
<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.min.js"); ?>></script>
<script src=<?= base_url("application/views/ventas/js/ventas.js"); ?>></script>

<script type="text/javascript">
   $(function(){
       load();
       $( '#txtBusqueda' ).on( 'keypress', function( e ) {
            if( e.keyCode === 13 ) {
                buscar();
            }
        });
   });
  
  /* function ComboAno(){
   var n = (new Date()).getFullYear()
   var select = document.getElementById("ano");
   for(var i = n; i>=1900; i--)select.options.add(new Option(i,i)); 
   }*/

var marca;

$(document).ready(function() {                       
    $("#slug").change(function() {
      
    marca = $('#slug').val();
    $("#slug option:selected").each(function() {
    $.post(base_url+"toolcrib/modelos", { marca : marca }, 
        function(data) {            
            $("#modAuto").html(data);
            });
        });
    });
});
var modelo;

$(document).ready(function() {                       
    $("#modAuto").change(function() {
      
    modelo = $('#modAuto').val();
    $("#slug option:selected").each(function() {
    $.post(base_url+"toolcrib/year", { modelo : modelo }, 
        function(data) {            
            $("#year").html(data);
            });
        });
    });
});
var year;

$(document).ready(function() {                       
    $("#year").change(function() {
      
    year = $('#year').val();
    $("#slug option:selected").each(function() {
    $.post(base_url+"toolcrib/motor", { year : year }, 
        function(data) {            
            $("#motor").html(data);
            });
        });
    });
});
</script>
</body>
</html>
