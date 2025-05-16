<style type="text/css">
   #tabla tr td  { 

text-align:center;
}
</style>
<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Cerrar Ventas</h2>
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
                           Usuario : 
                           <input type="radio" class="flat" name="rbBusqueda" id="user" value="user"/>
                        </p>
                        <input id="txtBuscar" style="display: inline;" type="text" name="txtBuscar">
                        <select onchange="buscar()" style="display: inline; width: 12%; margin-right: 10px;" required="required" class="select2_single form-control" id="opEstatus">
                           <option value="CREADA">CREADAS</option>
                           <option value="CERRADA">CERRADAS</option>
                        </select>
                        <input id="fecha1" style="display: inline;" type="date" name="fecha1">
                        <input id="fecha2" style="display: inline;" type="date" name="fecha2">
                        <button id="btnBuscar" onclick="buscar()" style="display: inline;" class="btn btn-success" type="button"><i class="fa fa-search"></i> Buscar</button>
                     </div>
                     <div class="clearfix"></div>
               </div>
               <div class="x_content">
               <!--<button onclick="agregar()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar Requisito </button>-->
               <div class="table-responsive">
               <table id="tabla"  class="table table-bordered" >
               <thead>
               <tr class="headings">
               <th class="column-title text-center">#</th>
               <th class="column-title text-center">Usuario</th>
               <th class="column-title text-center">Fecha</th>
               <th class="column-title text-center">Total</th>
               <th class="column-title text-center">Estatus</th>
               </tr>
               </thead>
               <tbody>
               </tbody>
               </table>
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
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js") ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js") ?>></script>
<!-- FastClick -->
<script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js") ?>></script>
<!-- NProgress -->
<script src=<?= base_url("template/vendors/nprogress/nprogress.js") ?>></script>
<!-- validator -->
<script src=<?= base_url("template/vendors/validator/validator.js") ?>></script>
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<script src=<?= base_url("application/views/ventas/js/catalogo.js"); ?>></script>

<script>
       $(function(){
         load();
       });
   
   
           
</script>

</body>
</html>