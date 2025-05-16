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
                  <h2>Catalogo de Garantias
                  </h2>
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
                  <button onclick="modalAgregar()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar</button>
                  <div class="table-responsive">
                     <table id="tbl_catalogo"  class="table table-bordered" >
                        <thead>
                           <tr class="headings">
                              <th class="column-title">#</th>
                              <th class="column-title">Titulo</th>
                              <th class="column-title">Descripcion</th>
                              <th class="column-title">Opciones</th>
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
<!-- MODALS -->
<div id="mdlAlta" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="">Agregar Garantia</h4>
         </div>
         <div class="modal-body">
            <form method="POST" action=<?= base_url('ventas/ingresar_garantia') ?>  novalidate enctype="multipart/form-data">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">Titulo <span class="required">*</span>
               </label>
               <input style="text-transform: uppercase;" id="producto" class="form-control col-md-7 col-xs-12" name="titulo" placeholder="" required="required" type="text" >
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripcion <span class="required">*</span>
               </label>
               <textarea style="text-transform: uppercase; height: 200px;" id="descripcion" class="form-control col-md-7 col-xs-12" name="descripcion" required="required" type="text" ></textarea>
               <div class="clearfix"></div>
               <div class="modal-footer">
                  <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                  <button id="btnAgregar" type="submit"  class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div id="mdlEditar" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="">Editar Garantia</h4>
         </div>
         <div class="modal-body">
            <form method="POST" action=<?= base_url('ventas/ingresar_garantia') ?> novalidate enctype="multipart/form-data">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">Titulo <span class="required">*</span>
               </label>
               <input style="text-transform: uppercase;" id="edit_producto" class="form-control col-md-7 col-xs-12" name="titulo" placeholder="" required="required" type="text" >
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripcion <span class="required">*</span>
               </label>
               <textarea style="text-transform: uppercase; height: 200px;" id="edit_descripcion" class="form-control col-md-7 col-xs-12" name="descripcion" required="required" type="text" ></textarea>
               <div class="clearfix"></div>
               <div class="modal-footer">
                  <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                  <button id="btnAgregar" type="submit"  class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div id="mdlObservaciones" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Descripcion</h4>
            </div>
            <div class="modal-body">
            <form>
                <p id='lblObservaciones'></p>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary"><i class="fa fa-check"></i> Aceptar</button>
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
<script src=<?= base_url("application/views/garantias/js/catalogo.js"); ?>></script>
<script>
   $(function(){
     load();
   });
</script>
</body>
</html>