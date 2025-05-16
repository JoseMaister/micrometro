<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Orden de Trabajo</h2>
                  <button type='button' onclick="enviarSolicitud()" class='btn btn-success btn-md pull-right solicitud' id="btnEnviar"><i class='fa fa-send'></i> Crear WO</button>                     
                  <div class="clearfix"></div>
               </div>
               <div class="col-md-4 col-sm-4 col-xs-12" class="row">
                  <div class="modal-body">
                     <form>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <button type='button' onclick="seleccionarCliente()" class='btn btn-primary btn-xs  pull-left solicitud'><i class='fa fa-plus'></i> Clientes</button>
                        </div>
                         <div id="divCliente"  class="x_content">
                              <label>Cliente/Customer:</label>
                              <p id="nombre"></p>
                              <p id="telefono"></p>
                              <p id="correo"></p>
                              <input type="hidden" id="cliente">
                              
                           </div>

                           <div class="col-md-8 col-sm-8 col-xs-12">
                           <label style="display: block;">Fecha Programada de Entrega</label>
                           <input type="text" class="form-control pull-right" id="txtFechaAccion">
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <label style="display: block;">Descripcion de Trabajo</label>
                           <textarea id="descripcion_trabajo"></textarea>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-md-4 col-sm-4 col-xs-12" class="row">
                  <div class="modal-body">
                     <form>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <button type='button' onclick="seleccionarServicio()" class='btn btn-primary btn-xs pull-left solicitud'><i class='fa fa-plus'></i> Seleccionar Servicio</button>
                        </div>
                         <div id="divCliente"  class="x_content">
                              <label>Servicio/Service:</label>
                              <div class="table-responsive">
                                <table id="tblServicio" class="">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                              
                           </div>
                           
                     </form>
                  </div>
               </div>

                <div class="col-md-4 col-sm-4 col-xs-12" class="row">
                  <div class="modal-body">
                     <form>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <button type='button' onclick="seleccionarUsuario()" class='btn btn-primary btn-xs pull-left solicitud'><i class='fa fa-plus'></i> Asignar Usuarios</button>
                        </div>
                         <div id="divCliente"  class="x_content">
                              <label>Usuario/User:</label>
                              <p id="name"></p>
                              <p id="correoU"></p>
                              <input type="hidden" id="usuario">
                              
                              
                           </div>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                           <button type='button' onclick="seleccionarPiezas()" class='btn btn-primary btn-xs pull-left solicitud'><i class='fa fa-plus'></i> Piezas a Trabajar</button>
                        </div>
                        <div id="divCliente"  class="x_content">
                              <label>Piezas/:</label>
                              <div class="table-responsive">
                                <table id="tblPiezasServ" class="table ">
                                 <thead>
                                        <tr class="headings">
                                            <th class="column-title">Pieza</th>
                                            <th class="column-title">Precio</th>
                                            <th class="column-title">Tamaño</th>
                                            <th class="column-title">Opc.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                              
                           </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <label style="display: block;">Vehiculo</label>
                           <input type="text" class="form-control pull-right" id="vehiculo">
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <label style="display: block;">Motor</label>
                           <input type="text" class="form-control pull-right" id="motor">
                        </div>
                     </form>
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
      Equipo de Desarrollo 
   </div>
   <div class="clearfix"></div>
</footer>
<!-- MODAL RS -->
<div id="mdlClientes" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Seleccionar Cliente</h4>
         </div>
          <div class="modal-body">
                <form>
                    <div style="display: none;" id="divBusqueda">
                        <!--<label>Ingrese Numero de Telefono: </label>
                        <div class="input-group">
                            <input id="txtBuscarProveedor" type="text" class="form-control" >
                            <span class="input-group-btn">
                            <button onclick="buscarClientes()" class="btn btn-default" type="button">Buscar</button>
                            </span>
                        </div>-->
                    </div>
                    <br>
                    <table id="tblBuscarProveedores" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
      </div>
   </div>
</div>

<div id="mdlServicios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Seleccionar Servicio</h4>
         </div>
          <div class="modal-body">
                <form>
                    <div style="display: none;" id="divBusqueda">
                        <!--<label>Ingrese Numero de Telefono: </label>
                        <div class="input-group">
                            <input id="txtBuscarProveedor" type="text" class="form-control" >
                            <span class="input-group-btn">
                            <button onclick="buscarClientes()" class="btn btn-default" type="button">Buscar</button>
                            </span>
                        </div>-->
                    </div>
                    <br>
                    <table id="tblServicios" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
      </div>
   </div>
</div>


<div id="mdlUsuarios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Asignar Usuario</h4>
         </div>
          <div class="modal-body">
                <form>
                    <div style="display: none;" id="divBusqueda">
                    </div>
                    <br>
                    <table id="tblUsuarios" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div> 
      </div>
   </div>
</div>
<div id="mdlPiezas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Seleccionar Piezas</h4>
         </div>
          <div class="modal-body">
                <form>
                    <div style="display: none;" id="divBusqueda">
                    </div>
                    <br>
                    <table id="tblPiezas" class="data table table-striped no-margin">
                        <tbody>
                        </tbody>
                    </table>
                </form>
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
<!-- Custom Them`e Scripts -->
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
<script src=<?= base_url("application/views/ordenes_trabajo/js/work_orders.js"); ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<script>
   
   $(function(){
       load();
   });
   
   
</script>
</body>
</html>