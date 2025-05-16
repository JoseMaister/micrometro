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
                  </div>
                  <div class="x_content" >
                     <div class="table-responsive" >
                        <table class="table table-striped">
                           <thead>
                              <tr class="headings">
                                 <th  class="column-title text-center"># Venta</th>
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
                                 <td  class="text-center"><?= $elem->id_scrap ?></td>
                                 <td  class="text-center"><?= $elem->codigo ?></td>
                                 <td  class="text-center"><?= $elem->producto ?></td>
                                 <td  class="text-center"><?= $elem->ubicacion ?></td>
                                 <td  class="text-center"><?= $elem->qty ?></td>
                                 <td  class="text-center">$ <?= $elem->precio ?></td>
                              </tr>
                              <?php
                                 $total=$elem->precio+$total;
                                 }
                                 ?>
                           </tbody>
                        </table>
                        <br>
                        <h2 class="pull-right">Total: $ <?= $total ?></h2>
                        <br>
                     </div>
                     <button onclick="mdlVenta();" class="btn btn-danger pull-right">Realizar Scrap</button></
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
            <h4 class="modal-title" id="lblCodigo">Capturar Scrap</h4>
         </div>
         <div class="modal-body">
            <form>
            <form>
               
               <div class="col-xs-6">
                  <label>Motivo</label>   
                  <textarea id="motivo"></textarea>
               </div>
            </form>
            <div class="modal-footer">
               <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
               <button id="btnCombrar" type="button" onclick="cerrar_compra(<?=$id;?>)" class="btn btn-primary"><i class='fa fa-plus'></i> Capturar</button>
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
            <button onclick="mdlVenta();" class="btn btn-success btn-xs">Agregar Cliente</button>
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
<script src=<?= base_url("application/views/scrap/js/ver_scrap.js"); ?>></script>
<script type="text/javascript">
   $(document).ready(function(){
       load();
       TOTAL='<?=$total;?>';
       venta='<?=$id;?>';
   });
   
</script>
</body>
</html>