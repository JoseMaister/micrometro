<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                     <h2>Venta</h2>
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                     </ul>
                     <div class="clearfix"></div>
                     <?php 
                        if ($estatus =='CREADA') {
                        
                      ?>
                     <button onclick="modalAsignarCliente();" class="btn btn-primary btn-xs">Agregar Cliente</button>
                     <?php 
                        }
                      ?>
                  </div>
                  <div class="x_content" >
                     <div class="table-responsive" >
                        <table class="table table-striped">
                           <thead>
                              <tr class="headings">
                                 <th  class="column-title text-center"># Venta</th>
                                 <th  class="column-title text-center">Cliente</th>
                                 <th  class="column-title text-center">Codigo</th>
                                 <th  class="column-title text-center">Producto</th>
                                 <th  class="column-title text-center">Local</th>
                                 <th  class="column-title text-center">Cantidad</th>
                                 <th  class="column-title text-center">Precio</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $total=0;
                                  foreach ($venta as $elem) { 
                                 //  
                                   ?>
                              <tr class="even pointer">
                                 <td  class="text-center"><?= $elem->id_venta ?></td>
                                 <td  class="text-center"><?= $elem->cliente ?></td>
                                 <td  class="text-center"><?= $elem->codigo ?></td>
                                 <td  class="text-center"><?= $elem->producto ?></td>
                                 <td  class="text-center"><?= $elem->ubicacion ?></td>
                                 <td  class="text-center"><?= $elem->qty ?></td>
                                 <td  class="text-center">$ <?= $elem->precio ?></td>
                              </tr>
                              <?php
                                 $total=$elem->total;
                                 }
                                 ?>
                           </tbody>
                        </table>
                        <br>
                        <h2 class="pull-right">Total: $ <?= $total ?></h2>
                        <br>
                     </div>
                     <?php 
                        if ($estatus =='CREADA') {
                          
                      ?>

                      <button onclick="mdlVenta();" class="btn btn-primary pull-right">Realizar Pago</button>
                      <button onclick="mdlAnticipo();" class="btn btn-success pull-right">Dar Anticipo</button>
                      <button onclick="mdlverAnticipo(<?=$id;?>);" class="btn btn-warning pull-right">Ver Anticipos</button>
                     <?php 
                       

                     
                      ?>   
                      <a  href=<?= base_url("ventas/cerrar_venta/".$id); ?>><button class="btn btn-danger pull-right">Cerrar Venta</button></a>
                      <?php 
                        

                     }
                      ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="mdlVenta" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="lblCodigo">Pagar</h4>
         </div>
         <div class="modal-body">
            <form>
            <form>
               <div class="col-xs-6 ">
                  <p>
                     <input onchange="descuento()" type="radio" class="flat" name="rbDescuento"  value="0" checked />
                     N/A: 
                  </p>
                  <p>
                     <input onchange="descuento()" type="radio" class="flat" name="rbDescuento"  value="5"  />
                     5%
                  </p>
                  <p>
                     <input onchange="descuento()" type="radio" class="flat" name="rbDescuento"  value="10" />
                     10%
                  </p>
                  <p>
                     <input onchange="descuento()" type="radio" class="flat" name="rbDescuento"  value="15"  />
                     15%
                  </p>
                  <p>
                     <input onchange="descuento()" type="radio" class="flat" name="rbDescuento"  value="30" />
                     30%
                  </p>
                  <p>
                     <input onchange="descuento()" type="radio" class="flat" name="rbDescuento"  value="otro" />
                     OTRO
                  </p>
                  <p id="descuento" style="display:none;">
                     <label>Tipo de descuento</label>   
                     <select style="width: 70%; margin-right: 10px;" required="required" class="select2_single form-control" id="tipo_descuento" name="tipo_descuento">
                        <option value=""></option>
                        <option value="efectivo">Efectivo</option>
                        <option value="porcentaje">Porcentaje</option>
                     </select>
                     <input id="txtDescuento" style="display: inline; width: 70%; margin-right: 10px;" type="number" >
                     <button  type="button" onclick="aplicar_descuento()" class="btn btn-warning btn-xs"><i class='fa fa-plus'></i> Aplicar</button>
                  </p>
               </div>
               <div class="col-xs-6">
                  <label>Tipo de pago</label>   
                  <select style="width:90%;" required="required" class="select2_single form-control" id="tipo">
                     <option value="efectivo">Efectivo</option>
                     <option value="tarjeta">Tarjeta</option>
                  </select>
                  <label id="total">Total: $<?=$total?></label> 
                  <br>
                  <label id="cambio"></label>
                  <input style="text-transform: uppercase;"  class="form-control col-md-7 col-xs-7" name="monto" id="monto" placeholder="" required="required" type="text" value=<?= $total ?>>
                  <br>
               </div>
            </form>
            <div class="modal-footer">
               <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
               <button id="btnCombrar" type="button" onclick="cobrar()" class="btn btn-primary"><i class='fa fa-plus'></i> Cobrar</button>
               <button id="btnCerrar" type="button"  onclick="cerrar_compra(<?=$id;?>)" class="btn btn-success" hidden><i class='fa fa-plus'></i> Cerrar Compra</button>
            </div>
         </div>
      </div>
   </div>
</div>


<div id="mdlAnticipo" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="lblCodigo">Dar Anticipo</h4>
         </div>
         <div class="modal-body">
            <form>
            <form>
               
                  <label>Tipo de pago</label>   
                  <select style="width:90%;" required="required" class="select2_single form-control" id="tipo_anticipo">
                     <option value="efectivo">Efectivo</option>
                     <option value="tarjeta">Tarjeta</option>
                  </select>
                  <label id="total_anticipo">Total: $<?=$total?></label> 
                  <label id="total_anticipo">Restante Anticipo: $<??></label> 

                  
                  <input style="text-transform: uppercase;"  class="form-control col-md-7 col-xs-7" name="monto_anticipo" id="monto_anticipo" placeholder="" required="required" type="text" value=<? ?>>
                  <br>
               </div>
            </form>
            <div class="modal-footer">
               <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
               <button id="btnCerrarAnticipo" type="button"  onclick="cobrar_anticipo(<?=$id;?>)" class="btn btn-success" hidden><i class='fa fa-plus'></i> Cobrar Anticipo</button>
            </div>
         </div>
      </div>
   </div>
</div>


<div id="mdlVerAnticipo" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="lblCodigo">Anticipos</h4>
         </div>
         <div class="modal-body">
            <form>
            <form>
               <table id="tblAnticipos" class="data table table-striped no-margin">
                  <thead>
                                <tr class="headings">
                                    <th class="column-title">Anticipo</th>
                                    <th class="column-title">Restante</th>
                                    <th class="column-title">Usuario</th>
                                    <th class="column-title">Fecha</th>
                                </tr>
                            </thead>
                  <tbody>
                  </tbody>

               </table>
               <h2 id="lblTotal" class="pull-right"></h2>
            </form>
            <div class="modal-footer">
               <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="mdlClientes" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 id= "mdlBusquedaTitulo" class="modal-title">Asignar cliente</h4>
            <a target="_blank" href=<?= base_url("usuarios/alta_cliente"); ?>><button id="send" type="button"  class="btn btn-primary btn-xs">Agregar Cliente</button></a>
         </div>
         <div class="modal-body">
            <form>
               <div id="divBusqueda">
                  <label>Buscar: </label>
                  <p>   
                     Telefono:
                     <input type="radio" class="flat" name="rbCliente"  value="telefono" checked />
                     Correo:
                     <input type="radio" class="flat" name="rbCliente"  value="correo"  />
                  </p>
                  <div class="input-group">
                     <input id="txtBuscarCliente" type="text" class="form-control" placeholder="Buscar Cliente...">
                     <span class="input-group-btn">
                     <button onclick="buscarCliente()" class="btn btn-default" type="button">Buscar</button>
                     </span>
                  </div>
               </div>
               <br>
               <table id="tblBuscarClientes" class="data table table-striped no-margin">
                  <tbody>
                  </tbody>
               </table>
            </form>
         </div>
      </div>
   </div>
</div>
<div id="mdlInfo" class="modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h3 id="tituloEmpresa" class="modal-title"></h3>
         </div>
         <div class="modal-body">
            <form>
               <div class="row">
                  <div class="col-md-8">
                     <h4 id="cliente">Cliente:</h4>
                     <ul id="lstTelefono"></ul>
                     <ul id="lstCorreo"></ul>
                     <ul id="lstRFC"></ul>
                     <ul id="lstDire"></ul>
                  </div>
               </div>
            </form>
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
<script src=<?= base_url("application/views/ventas/js/ver_venta.js"); ?>></script>
<script type="text/javascript">
   $(document).ready(function(){
       load();
       TOTAL='<?=$total;?>';
       venta='<?=$id;?>';
   });
   
</script>
</body>
</html>
