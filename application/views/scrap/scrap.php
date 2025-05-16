<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                     <h2>Crear Ticket de Scrap</h2>
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                     </ul>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content" >
                     <div class="col-md-8 col-sm-8 col-xs-12">
                     <p style="display: inline;">
                        Producto:
                     </p>
                     <input id="txtBusqueda" name="txtBusqueda" style="display: inline;" type="text" >
                     <button onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>
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
                     <button class="btn btn-danger btn-md pull-left"><i class="glyphicon glyphicon-trash"></i> Cancelar</button>
                       <button class="btn btn-success btn-md pull-right" onclick="realizar_venta();"><i class="glyphicon glyphicon-check"></i> Realizar</button>
</div>
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
<script src=<?= base_url("application/views/scrap/js/scrap.js"); ?>></script>

<script type="text/javascript">
   $(function(){
   //    load();
   });
  
</script>
</body>
</html>
