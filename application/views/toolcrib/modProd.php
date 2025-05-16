<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                     <h2>Editar Producto</h2>
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                     </ul>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content" >
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="x_panel">
                           <div class="x_title">
                              <ul class="nav navbar-right panel_toolbox">
                                 <li><a class="collapse-link"><i></i></a>
                                 </li>
                                 <li><a class="close-link"><i></i></a>
                                 </li>
                              </ul>
                              <div class="clearfix"></div>
                           </div>
                           <div class="x_content">
                              <div style="text-align: center; overflow: hidden; margin: 10px;">
                                 <img width="100%" src="<?= 'data:image/bmp;base64,' . base64_encode($productos->foto); ?>">  
                                 <label class="btn btn-default btn-sm" for="imgAuto">
                                 <input accept="image/png, image/gif, image/jpeg" target="_blank" onchange="uploadFoto();" type="file" class="sr-only" id="imgAuto" name="imgAuto">
                                 <i class="fa fa-file"></i> Cambiar foto
                                 </label>             
                              </div>
                              <div style="text-align: center; overflow: hidden; margin: 10px;">
                                                 
                              
                                                               <button onclick="mdlAutos();" class="btn btn-primary">Ver autos</button>
                                </div>
                           </div>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-striped">
                           
                           <tbody>
                              <tr>
                                 <td>
                                    <form method="POST" action=<?= base_url('toolcrib/actualizarProducto') ?> class="form-horizontal form-label-left" novalidate enctype="multipart/form-data">
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Codigo <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="idp" class="form-control col-md-7 col-xs-12" name="idp" placeholder="" required="required" type="hidden" value=<?= $productos->idProducto ?>>
                                             <input style="text-transform: uppercase;" id="codigo" class="form-control col-md-7 col-xs-12" name="codigo" placeholder="" required="required" type="text" value=<?= $productos->codigo ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Categoria <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="categoria" class="form-control col-md-7 col-xs-12" name="categoria" placeholder="" required="required" type="text" value=<?= $productos->categoria ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Producto <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="producto" class="form-control col-md-7 col-xs-12" name="producto" placeholder="" required="required" type="text" value=<?= $productos->producto ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Descripcion <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <textarea style="text-transform: uppercase;" id="descripcion" class="form-control col-md-7 col-xs-12" name="descripcion" required="required" type="text" ><?= $productos->descripcion ?></textarea>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Proveedor <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="proveedor" value="<?= $productos->proveedor ?>" class="form-control col-md-7 col-xs-12" name="proveedor" placeholder="" required="required" type="text">
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Marca <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="marca" class="form-control col-md-7 col-xs-12" name="marca" placeholder="" required="required" type="text" value=<?= $productos->marca ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Modelo <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="modelo" class="form-control col-md-7 col-xs-12" name="modelo" placeholder="" required="required" type="text" value=<?= $productos->modelo ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Precio <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="precio" class="form-control col-md-7 col-xs-12" name="precio" placeholder="" required="required" type="text" value=<?= $productos->precio ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Unidad de Medida</label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <select required="required" class="select2_single form-control" name="um" id="um">
                                                <option value=<?= $productos->um ?>><?= $productos->um ?></option>
                                                <option value="Piezas">Piezas</option>
                                                <option value="Kg">Kg</option>
                                                <option value="Paquete">Paquete</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Garantia <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="garantia" class="form-control col-md-7 col-xs-12" name="garantia" placeholder=""  type="text" value="<?= $productos->garantia ?>">
                                </div>
                            </div> 
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Cantidad Minima <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="cantMin" class="form-control col-md-7 col-xs-12" name="cantMin" placeholder="" required="required" type="number" value=<?= $productos->cantMin ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Cantidad Maxima <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input style="text-transform: uppercase;" id="cantMax" class="form-control col-md-7 col-xs-12" name="cantMax" placeholder="" required="required" type="number" value=<?= $productos->cantMax ?>>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus</label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?php if($productos->estatus!=0){?>
                                             <p>
                                                Activo
                                                <input type="checkbox" class="flat" name="estatus" value="1" checked />
                                             </p>
                                             <?php
                                                }else{?>
                                             <p>
                                                Activar
                                                <input type="checkbox" class="flat" name="estatus" value="1"/>
                                             </p>
                                             <?php
                                                }?>
                                          </div>
                                       </div>
                                       <div class="item form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Comentarios <span class="required">*</span>
                                          </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                             <textarea style="text-transform: uppercase;" id="comentario" class="form-control col-md-7 col-xs-12" name="comentario" placeholder="" required="required"></textarea>
                                          </div>
                                       </div>
                                       <div class="ln_solid"></div>
                                       <div class="form-group">
                                          <div class="col-md-6 col-md-offset-3">
                                             <button id="send" type="submit" class="btn btn-success">Actualizar Producto</button>
                                          </div>
                                       </div>
                                    </form>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                     <div class="x_content">
                                <h2>Comentarios</h2>
                            <div class="table-responsive">
                                <table id="tabla" class="table table-bordered">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title text-center">Tipo</th>
                                            <th class="column-title text-center">Usuario</th>
                                            
                                            <th class="column-title text-center">Comentarios</th>
                                            <th class="column-title text-center">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if($movimientos) { $i = 1;
                                     foreach ($movimientos->result() as $elem) { ?>

                                            <tr class="even pointer">
                                                <td  class="text-center"><?= $elem->tipo ?></td>
                                                <td  class="text-center"><?= $elem->nombre ?></td>
                                                <td  class="text-center"><?= $elem->comentario ?></td>
                                                <td  class="text-center"><?= $elem->fecha ?></td>
                                                
                                            </tr>
                                    <?php $i++; }
                                      }
                                    ?>
                                    </tbody>

                                </table>

                            </div>


                                    
                        </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="mdlAutos" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="lblCodigo">Agregar Autos</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-xs-6">
                        
                        <label>Marca</label>   
                        <select style="width:90%;" required="required" class="select2_single form-control" id="slug" name="slug">
                           <option value="0"></option>'
                                        <?php foreach ($marcas as $elem) { 
                                         echo '<option value="'.$elem->id.'">'.$elem->Nombre.'</option>';
                                        } ?>
                        </select>
                        <label>Modelo</label>   
                        <select style="width:90%;" required="required" class="select2_single form-control" id="modAuto" name="modAuto">
                        </select>
                        <label>
                        Año 
                     </label>
                     <select  style="width:90%;" required="required" class="select2_single form-control" id="year" name="year">
                    
                     </select>
                     <label>
                        Motor 
                     </label>
                     <select  style="width:90%;" required="required" class="select2_single form-control" id="motor" name="motor">
                    
                     </select>
                    </div>
                </form>




            </div>
             <div class="x_content">
                            <div class="table-responsive">
                                <table id="tabla_autos" class="table table-bordered">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title text-center">Año</th>
                                            <th class="column-title text-center">Marca</th>
                                            <th class="column-title text-center">Modelo</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>

                            </div>


                                    
                        </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnAgregar" type="button" onclick="agregar()" class="btn btn-primary"><i class='fa fa-plus'></i> Agregar</button>
            </div>
            

        </div>
    </div>
</div>
<!-- /page content -->
<!-- footer content -->
<footer>
   <div class="pull-right">
      Equipo de Desarrollo | MAS Metrología
   </div>
   <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<script src=<?= base_url("application/views/toolcrib/js/modProd.js"); ?>></script>

<script type="text/javascript">
   var id = $("#idp").val();

   function uploadFoto(){
     var files = document.getElementById("imgAuto").files;
     var file = files[0];
     var URL = base_url + 'toolcrib/updateFoto';
     var formdata = new FormData();
     formdata.append("file", file);
     formdata.append("id", id);
     var ajax = new XMLHttpRequest();
     ajax.open("POST", URL);
     ajax.send(formdata);
     ajax.onload = function(){
       window.location.reload();
     }
   }  

   
   $(function(){
        load();
    });

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
    $("#modAuto option:selected").each(function() {
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
    $("#year option:selected").each(function() {
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