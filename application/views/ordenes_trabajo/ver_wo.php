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
   <?php 
      $total=0;
       ?>
</style>
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Orden de Trabajo:
                     <?= 'WO-' . str_pad($wo->wo_id, 6, "0", STR_PAD_LEFT) ?>
                  </h2>
                  <?php
                     if ($wo->estatus == "PROGRAMADA") {
                        
                     
                                       ?>
                  <a href=<?= base_url("ordenes_trabajo/concluir_wo/".$wo->wo_id) ?> class="btn btn-success btn-xs pull-right"><i class='fa fa-send'></i> Concluir</a>
                  <button type='button' onclick="cancelarWO()" class='btn btn-danger btn-xs pull-right'><i class='fa fa-close'></i> Cancelar</button>
                  <?php
                     }
                     elseif ($wo->estatus == 'CONCLUIDA') {
                        ?>
                  <a href=<?= base_url("ordenes_trabajo/entregar_wo/".$wo->wo_id) ?> class="btn btn-primary btn-xs pull-right"><i class='fa fa-check'></i> Entregar</a>
                  <?php
                     }elseif ($wo->estatus == 'ENTREGADA') {
                              
                        ?>
                  <a href=<?= base_url("ordenes_trabajo/cerrar_wo/".$wo->wo_id) ?> class="btn btn-dark btn-xs pull-right"><i class='fa fa-send'></i> Cerrar</a>
                  <?php
                     }
                               
                         ?>
                  <div class="clearfix"></div>
               </div>
               <a target="_blank" href=<?= base_url("ordenes_trabajo/ticket/".$wo->wo_id) ?> class="btn btn-warning btn-xs "><i class='fa fa-file'></i> Imprimir Recibo</a>
               <a target="_blank" href=<?= base_url("ordenes_trabajo/etiqueta_wo/".$wo->wo_id) ?> class="btn btn-success btn-xs "><i class='fa fa-file'></i> Imprimir etiqueta</a>
               <label class="btn btn-primary btn-xs" for="imgAuto">
               <input target="_blank" onchange="uploadFoto();" type="file" class="sr-only" id="imgAuto" name="imgAuto">
               <i class="fa fa-file"></i> Subir Archivo
               </label>             
               <div class="x_content">
                  <div class="row">
                     <!-- C L I E N T E -->
                     <div class="col-md-3 col-sm-4 col-xs-4">
                        <div style="border: 0; margin-bottom: 0 px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div id="divCliente"  class="x_content">
                              <label>Cliente/Customer:</label>
                              <p><?=$wo->nombre?></p>
                              <p><?=$wo->dir_fiscal?></p>
                              <p><?=$wo->correo?></p>
                              <p>Telefono: <?=$wo->telefono?> </p>
                           </div>
                        </div>
                     </div>
                     <!-- D A T O S -->
                     <div class="col-md-3 col-sm-4 col-xs-12">
                        <div style="border: 0px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div class="x_content">
                              <div id="rowEstatus"  class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <center>
                                       <label style="display: block">Estatus:</label>
                                       <?php
                                          switch ($wo->estatus) {
                                             case 'CREADA':
                                             case 'PROGRAMADA':
                                               $BTN_CLASS = 'btn btn-primary';
                                                   break;
                                             case 'CONCLUIDA':
                                               $BTN_CLASS = 'btn btn-success';
                                                   break;
                                             case 'CERRADA':
                                               $BTN_CLASS = 'btn btn-dark';
                                                   break;
                                             case 'ENTREGADA':
                                               $BTN_CLASS = 'btn btn-warning';
                                                   break;
                                             case 'CANCELADA':
                                               $BTN_CLASS = 'btn btn-danger';
                                                   break;
                                          
                                             
                                             default:
                                                // code...
                                                break;
                                          }
                                          
                                          ?>
                                       <button id="btnEstatus" type="button" class=<?= "'" . $BTN_CLASS . "'" ?>><?=$wo->estatus?></button>
                                    </center>
                                    <center>
                                       <label style="display: block">Descripcion de Trabajo:</label>
                                       <p><?= $wo->descripcion?></p>
                                    </center>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-2 col-sm-4 col-xs-12">
                        <div style="border: 0px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div class="x_content">
                              <div id="rowEstatus"class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <center>
                                       <br>
                                       <div id="divCliente"  class="x_content">
                                          <label>Asignado:</label>
                                          <p><?=$wo->asignado?></p>
                                          <label style="display: block">Vehiulo a Trabajar:</label>
                                          <p><?= $wo->vehiculo?></p>
                                          <label style="display: block">Motor a Trabajar:</label>
                                          <p><?= $wo->motor?></p>
                                       </div>
                                    </center>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php if ($this->session->privilegios['crear_venta']) { ?>
                     <div class="col-md-4 col-sm-4 col-xs-4">
                        <div style="border: 0; margin-bottom: 0 px;" class="x_panel">
                           <div class="x_title">
                              <div class="clearfix"></div>
                           </div>
                           <div id="divPagos"  class="x_content">
                              <label>Pagos/Anticipos:</label>
                              <button type='button' onclick="mdlAnticipo()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-plus'></i> Agregar Anticipo</button>
                           </div>
                           <div class="row">
                              <table id="tblAnticipos" class="col-md-3 col-sm-4 col-xs-4 data table table-striped no-margin">
                                 <thead>
                                    <tr>
                                       <th>Cantidad</th>
                                       <th>Fecha</th>
                                       <th>Usuario</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                                 <h4 class="pull-right" id="lbltotal_abonado">Total</h4>
                                 <br>  
                                 <br>
                                 <br>
                                 <h4 class="pull-right" id="lblrestante">Total</h4>
                              </table>
                              <h4 class="pull-right" id="ptotal">Total</h4>
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="">
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-12">
               <div class="x_panel">
                  <div class="x_content">
                     <div class="row">
                        <div class="row">
                           <!-- C O N C E P T O S   Y   C O M E N T A R I O S -->
                           <div class="col-md-12 col-sm-12 col-xs-12" >
                              <div class="row" >
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style="border: 0;" class="x_panel">
                                       <div class="x_title">
                                          <h3 style="display: inline;">Piezas a Trabajar</h3>
                                          <?php if ($this->session->privilegios['crear_venta']) { ?>
                                          <button type='button' onclick="mdlPiezas()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-plus'></i> Agregar Pieza</button>
                                          <?php } ?>
                                          <div class="clearfix"></div>
                                       </div>
                                       <div class="x_content">
                                          <div class="row">
                                             <table id="tblPiezas" class="data table table-striped no-margin">
                                                <thead>
                                                   <tr>
                                                      <th>Pieza</th>
                                                      <th>Tamaño</th>
                                                      <th>Total</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <?php if ($this->session->privilegios['crear_venta']) { ?>
                                                <h4 class="pull-right" id="lblTotalPiezas">Total</h4>
                                                <?php } ?>
                                             </table>
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
         </div>
      </div>

      <div class="">
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-12">
               <div class="x_panel">
                  <div class="x_content">
                     <div class="row">
                        <div class="row">
                           <!-- C O N C E P T O S   Y   C O M E N T A R I O S -->
                           <div class="col-md-12 col-sm-12 col-xs-12" >
                              <div class="row" >
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style="border: 0;" class="x_panel">
                                       <div class="x_title">
                                          <h3 style="display: inline;">Servicios</h3>
                                          <?php if ($this->session->privilegios['crear_venta']) { ?>
                                          <button type='button' onclick="mdlServicios()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-plus'></i> Agregar Servicio</button>
                                          <?php } ?>
                                          <div class="clearfix"></div>
                                       </div>
                                       <div class="x_content">
                                          <div class="row">
                                             <table id="tblServicios" class="data table table-striped no-margin">
                                                <thead>
                                                   <tr>
                                                      <th>Servicio</th>
                                                      <th>Descripcion</th>
                                                      <?php if ($this->session->privilegios['crear_venta']) { ?>
                                                      <th>Total</th>
                                                      <?php } ?>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <?php if ($this->session->privilegios['crear_venta']) { ?>
                                                <h4 class="pull-right" id="lblTotalServicios">Total</h4>
                                                <?php } ?>
                                             </table>
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
         </div>
      </div>

      <div class="">
         <div class="clearfix"></div>
         <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-12">
               <div class="x_panel">
                  <div class="x_content">
                     <div class="row">
                        <div class="row">
                           <!-- C O N C E P T O S   Y   C O M E N T A R I O S -->
                           <div class="col-md-12 col-sm-12 col-xs-12" >
                              <div class="row" >
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style="border: 0;" class="x_panel">
                                       <div class="x_title">
                                          <h3 style="display: inline;">Tickets Tool Crib</h3>
                                          <?php if ($this->session->privilegios['crear_venta']) { ?>
                                          <button type='button' onclick="mdlTicket()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-plus'></i> Agregar Tickets</button>
                                          <?php } ?>
                                          <div class="clearfix"></div>
                                       </div>
                                       <div class="x_content">
                                          <div class="row">
                                             <h4 class="pull-right" id="lblItemsCount"></h4>
                                             <table id="tblConceptosRS" class="data table table-striped no-margin">
                                                <thead>
                                                   <tr>
                                                      <th class="text-center">#Ticket</th>
                                                      <th class="text-center">Codigo</th>
                                                      <th class="text-center">Producto</th>
                                                      <th class="text-center">Cantidad</th>
                                                      <?php if ($this->session->privilegios['crear_venta']) { ?>
                                                      <th class="text-center">Total</th>
                                                      <?php } ?>
                                                      <th class="text-center">Fecha de entrega</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      if($ticktes) { $i = 1;
                                                       foreach ($ticktes->result() as $elem) { 
                                                            $total=$elem->total;
                                                         ?>
                                                   <tr class="even pointer">
                                                      <td  class="text-center"><?= str_pad($elem->idToolCrib, 6, "0", STR_PAD_LEFT) ?></td>
                                                      <td  class="text-center"><?= $elem->codigo ?></td>
                                                      <td class="text-center"><?= $elem->producto ?></td>
                                                      <td  class="text-center"><?= $elem->cantidad ?></td>
                                                      <?php if ($this->session->privilegios['crear_venta']) { ?>
                                                      <td  class="text-center">$ <?= $elem->total_detalle ?></td>
                                                      <?php } ?>
                                                      <td  class="text-center"><?= $elem->fecha ?></td>
                                                   </tr>
                                                   <?php $i++; }
                                                      }
                                                      ?>
                                                </tbody>
                                                <?php if ($this->session->privilegios['crear_venta']) { ?>
                                                <h4 class="pull-right" id="lblTotalTool">Total: $<?= $total ?></h4>
                                                <?php } ?>
                                             </table>
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
         </div>
      </div>
      <div id="rowComentarios" style="display: ;" class="row">
         <div class="col-md-10 col-sm-10 col-xs-12">
            <div style="border: 0;" class="x_panel">
               <div class="x_title">
                  <h3 style="display: inline;">Comentarios</h3>
                  <button type='button' onclick="mdlComentario()" class='btn btn-primary btn-xs pull-right'><i class='fa fa-comments'></i> Agregar</button>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <ul class="list-unstyled msg_list">
                  <?php
                     if($comentarios)
                     {
                     foreach ($comentarios->Result() as $elem) {
                     $date=date_create($elem->fecha);
                     ?>
                  <li>
                     <a>
                     <label><?= $elem->nombre." ".date_format($date,"Y/m/d H:i:s A")?></label>
                     <label class="message"><?=$elem->comentario ?></label>
                     </a>
                     <?php
                        if ($elem->archivo) {
                        ?>
                     <a id="single_image" href="<?= 'data:image/png;base64,' . base64_encode($elem->archivo) ?>">
                     <span> Ver foto</span>
                     </a>
                     <?php
                        }
                           ?>
                  </li>
                  <?php
                     }}
                        ?>
                  <ul>
               </div>
            </div>
         </div>
         <?php
            $hayArchivos = FALSE; $hayFotos = FALSE;
            if($archivos)
            {
              foreach ($archivos->Result() as $file) {
                if($this->aos_funciones->is_image($file->nombre))
                {
                  $hayFotos = TRUE;
                }else {
                  $hayArchivos = TRUE;
                }
              }
            }
            ?>
         <?php if ($hayArchivos) { ?>
         <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                     <h3 style="display: inline;">Archivos</h3>
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                     </ul>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <?php
                        foreach ($archivos->Result() as $file) {
                          if(!$this->aos_funciones->is_image($file->nombre))
                          {?>
                     <div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
                        <span><?=$file->fecha?></span>
                        <a href="<?= base_url('/ordenes_trabajo/descargas/' . $file->id) ?>">
                           <img style="width: 80%; margin-bottom: 10px;" title="<?= $file->nombre ?>" src="<?= $this->aos_funciones->file_image($file->nombre) ?>" />
                           <p style="height: 41px; text-overflow: ellipsis; overflow: hidden;"><?= $file->nombre ?></p>
                        </a>
                     </div>
                     <?php }
                        }
                        ?>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
         <?php if ($hayFotos) { ?>
         <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                     <h3 style="display: inline;">Fotos</h3>
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                     </ul>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row">
                        <div id="simple_gallery" class="box-content">
                           <?php foreach ($archivos->Result() as $pho) {
                              if($this->aos_funciones->is_image($pho->nombre)) {?>
                           <div class="col-md-55">
                              <div class="image view view-first">
                                 <a id="single_image" href="<?= 'data:image/png;base64,' . base64_encode($pho->file) ?>">
                                 <img style="width: 100%; display: block;" src="<?= base_url('/ordenes_trabajo/get_foto/' . $pho->id) ?>" />
                                 </a>
                                 <span><?=$pho->fecha?></span>
                              </div>
                           </div>
                           <?php }
                              } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</div>
</div>
</div>
</div>
<!-- MODAL RS -->
<div id="mdlRS" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Ingrese RS</h4>
         </div>
         <div class="modal-body">
            <form>
               <h3 style="display: none;" id="lblRS"></h3>
               <div class="input-group">
                  <input id="txtBuscarRS" type="text" class="form-control" placeholder="Buscar RS...">
                  <span class="input-group-btn">
                  <button onclick="buscarRS()" class="btn btn-default" type="button">Buscar</button>
                  </span>
               </div>
               <div id="divSelectTodo" style="display: none"><input id="iptTodo" type="checkbox" class="flat"> Seleccionar Todo</div>
               <table class="data table table-striped no-margin">
                  <thead>
                     <tr>
                        <th>Selecc.</th>
                        <th>RS</th>
                        <th>Item</th>
                        <th>Descripción</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </form>
         </div>
         <div class="modal-footer">
            <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
            <button onclick="agregarRSItems()" type="button" class="btn btn-primary"><i class='fa fa-check'></i> Agregar</button>
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
            <a target="_blank" href=<?= base_url("toolcrib/tool_crib"); ?>><button id="send" type="button"  class="btn btn-primary btn-xs">Crear Ticket</button></a>
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
<div id="mdlServicios" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Seleccionar Servicios</h4>
         </div>
         <div class="modal-body">
            <form>
               <br>
               <table id="tblServicio" class="data table table-striped no-margin">
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
               <br>
               <table id="tblPieza" class="data table table-striped no-margin">
                  <tbody>
                  </tbody>
               </table>
            </form>
         </div>
      </div>
   </div>
</div>
<div id="mdlAnticipo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 id='mdlComentarioTitle' class="modal-title">Agregar Anticipo</h4>
         </div>
         <div class="modal-body">
            <form>
               <label>Anticipo</label>
               <input id="anticipo" type="number" min="0"></input>
            </form>
         </div>
         <div class="modal-footer">
            <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
            <button id="btnComentario" type="button" onclick="agregarAnticipo(<?=$wo->wo_id?>)" class="btn btn-primary btn-sm"><i class='fa fa-times-comment'></i> Agregar</button>
         </div>
      </div>
   </div>
</div>
<div id="mdlComentario" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 id='mdlComentarioTitle' class="modal-title">Agregar Comentario</h4>
         </div>
         <div class="modal-body">
            <form>
               <label>Asignar</label>
               <select style="width:90%;" required="required" class="select2_single form-control" id="usuario" name="usuario">
                  <option value="0"></option>
                  <?php 
                     foreach ($usuarios->result() as $elem) { 
                                            echo '<option value="'.$elem->id.'">'.$elem->User.'</option>';
                                  } 
                        ?>
               </select>
               <label>Comentario</label>
               <textarea style="height: 60px; resize: none;" id="txtComentarios" class="form-control"></textarea>
               <div style="text-align: center; overflow: hidden; margin: 10px;">
                  <label class="btn btn-default btn-sm" for="archivo">
                  <input accept="image/*" target="_blank" type="file" class="sr-only" id="archivo" name="archivo">
                  <i class="fa fa-file"></i> Subir Archivo
                  </label>             
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
            <button id="btnComentario" type="button" onclick="agregarComentario(<?=$wo->wo_id?>)" class="btn btn-primary btn-sm"><i class='fa fa-times-comment'></i> Agregar</button>
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
<script src=<?= base_url("application/views/ordenes_trabajo/js/work_orders.js"); ?>></script>
<script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- FancyBOX -->
<script src=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.js"); ?>></script>
<script>
   var wo = '<?= $wo->wo_id ?>';   
   var total_final = '<?=$total?>';   
   var t=0;
   const crear_venta = '<?= $this->session->privilegios['crear_venta']; ?>';
      $(function(){
          load();
      });
      
    function load(){
      cargarComentarios(wo);
      cargarServicios(wo);
      cargarAnticipo(wo)
   cargarPiezas(wo)
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
   function mdlServicios(){
       $("#mdlServicios").modal();
       buscarServicios();
   }
   function mdlPiezas(){
       $("#mdlPiezas").modal();
       buscarPiezas();
   }
   function mdlAnticipo(){
       $("#mdlAnticipo").modal();
       buscarServicios();
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
   function buscarServicios(){
       var URL = base_url + "/ordenes_trabajo/ajax_get_servicios";
       $('#tblServicio tr').remove();           
           $.ajax({
               type: "POST",
               url: URL,
             //  data: { texto: texto },
               success: function(result) {
                   
                   if(result)
                   {
                       
                       var tab = $('#tblServicio tbody')[0];
                       var rs = JSON.parse(result);
                       $.each(rs, function(i, elem){
                           var ren = tab.insertRow(tab.rows.length);
                          ren.insertCell().innerHTML = elem.magnitud;
                       ren.insertCell().innerHTML = elem.descripcion;
                       ren.insertCell().innerHTML = elem.clave_precio;
                       ren.insertCell().innerHTML = "<button type='button' onclick='asignarServicio(this)' class='btn btn-primary btn-xs' value=" + elem.id + "><i class='fa fa-plus'></i> Seleccionar</button>";
                       });
                   }
   
               },
               error: function(data){
                   new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                   console.log(data);
               },
           });
       
   }
   function buscarPiezas(){
       var URL = base_url + "/ordenes_trabajo/ajax_get_piezas";
       $('#tblPieza tr').remove();           
           $.ajax({
               type: "POST",
               url: URL,
             //  data: { texto: texto },
               success: function(result) {
                   
                   if(result)
                   {
                       
                       var tab = $('#tblPieza tbody')[0];
                       var rs = JSON.parse(result);
                       $.each(rs, function(i, elem){
                           var ren = tab.insertRow(tab.rows.length);
                          ren.insertCell().innerHTML = elem.nombre;
                              // Select con opciones de tamaño
                    ren.insertCell().innerHTML = `
                        <select class="form-control" name="tamano_pieza" data-id="${elem.id}">
                            <option value="STD">Std</option>
                            <option value="0.25 mm">0.25 mm</option>
                            <option value="0.50 mm">0.50 mm</option>
                            <option value="0.75 mm">0.75 mm</option>
                            <option value="1.0 mm">1.0 mm</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select>`;
                       ren.insertCell().innerHTML = "<button type='button' onclick='asignarPieza(this)' class='btn btn-primary btn-xs' value=" + elem.id + "><i class='fa fa-plus'></i> Seleccionar</button>";
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
   
      
       
       var URL = base_url + "ordenes_trabajo/ajax_setTicket";
      //alert(CURRENT_QR);
   
       $.ajax({
           type: "POST",
           url: URL,
           data: { id: id, wo:wo },
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
   function asignarServicio(btn){
       var id = $(btn).val();
       
       var URL = base_url + "ordenes_trabajo/ajax_setServicios";   
       $.ajax({
           type: "POST",
           url: URL,
           data: { id: id, wo:wo },
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
   function asignarPieza(btn){
    var id = $(btn).val();
    var row = $(btn).closest('tr'); // Encuentra la fila actual
    var size = row.find("select[name='tamano_pieza']").val(); // Obtiene el valor del select

    var URL = base_url + "ordenes_trabajo/ajax_setPiezas";   
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: id, wo: wo, size: size }, // envía también el tamaño
        success: function(result) {
            if(result) {
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
       var usuario = $("#usuario").val();
       var files = document.getElementById("archivo").files;
       var file = files[0];
   
       if(comentario.length > 0)
       {
           var formdata = new FormData();
     formdata.append("file", file);
     formdata.append("comentario", comentario);
     formdata.append("wo", wo);
     formdata.append("usuario", usuario);
     var ajax = new XMLHttpRequest();
     ajax.open("POST", URL);
     ajax.send(formdata);
     ajax.onload = function(){
       $('#mdlComentario').modal('hide');
         //cargarComentarios(id);
       window.location.reload();
     }
           
   
          /* $.ajax({
               type: "POST",
               url: URL,
               data: { comentario : comentario, wo:wo, usuario:usuario, archivo:archivo },
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
           });*/
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
                       +        '<label>'
                       +             elem.nombre+ moment(elem.fecha).format('D/MM/YYYY h:mm A') + '</label>'
                       +        '<label class="message">' + elem.comentario + '</label>'
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
   
   function cargarPiezas(id){
       var URL = base_url + "ordenes_trabajo/ajax_getPiezas";
     var total=0;
       $.ajax({
           type: "POST",
           url: URL,
           data: { id : id },
           success: function(result) {
               if(result)
               {
                    var tab = $('#tblPiezas tbody')[0];
                   var rs = JSON.parse(result);
                   $.each(rs, function(i, elem){
                       var ren = tab.insertRow(tab.rows.length);
 total=Number(elem.total) + Number(total);
                       
                       ren.insertCell().innerHTML = elem.nombre;
                       ren.insertCell().innerHTML = elem.size;
                       if (crear_venta ==1) {
                       ren.insertCell().innerHTML = "$<input  id='id_pi_"+elem.id+"' type='text' value=" + elem.total + "></input> <button type='button' onclick='guardar_precio_pieza(" + elem.id + ")' class='btn btn-warning btn-xs' ><i class='fa fa-save'></i> </button>";
                    }
                   });
                   document.getElementById('lblTotalPiezas').innerHTML = 'Total: $'+total;
                   actualizarTotalGeneral();
                   /*t=Number(total)+Number(total_final);
                  document.getElementById('ptotal').innerHTML = "Total $ "+t;*/
                   
               }
           },
           error: function(data){
               new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
               console.log(data);
           },
       });
   }

   function cargarServicios(id){
       var URL = base_url + "ordenes_trabajo/ajax_getServicios";
       var total=0;
       $.ajax({
           type: "POST",
           url: URL,
           data: { id : id },
           success: function(result) {
               if(result)
               {
                    var tab = $('#tblServicios tbody')[0];
                   var rs = JSON.parse(result);
                   $.each(rs, function(i, elem){
                       var ren = tab.insertRow(tab.rows.length);
                       total=Number(elem.total) + Number(total);
                       ren.insertCell().innerHTML = elem.magnitud;
                       ren.insertCell().innerHTML = elem.descripcion;
                       if (crear_venta ==1) {
                       ren.insertCell().innerHTML = "$<input  id='id_ser_"+elem.id+"' type='text' value=" + elem.total + "></input> <button type='button' onclick='guardar_precio(" + elem.id + ")' class='btn btn-warning btn-xs' ><i class='fa fa-save'></i> </button>";
                    }
                   });
                  
                  document.getElementById('lblTotalServicios').innerHTML = 'Total: $'+total;
                  actualizarTotalGeneral();
                   /*t=Number(total)+Number(total_final);
                  document.getElementById('ptotal').innerHTML = "Total $ "+t;*/
   
                   
               }
           },
           error: function(data){
               new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
               console.log(data);
           },
       });
   }
   function actualizarTotalGeneral() {
    let totalServicios = parseFloat(document.getElementById('lblTotalServicios').innerText.replace(/[^\d.-]/g, '')) || 0;
    let totalPiezas = parseFloat(document.getElementById('lblTotalPiezas').innerText.replace(/[^\d.-]/g, '')) || 0;

    let total = totalServicios + totalPiezas;
    document.getElementById('ptotal').innerHTML = "Total $ " + total.toFixed(2);
}

   function guardar_precio(id){
       var total = $("#id_ser_"+id).val();
       
       var URL = base_url + "ordenes_trabajo/ajax_setPrecio";
      //alert(CURRENT_QR);
   
       $.ajax({
           type: "POST",
           url: URL,
           data: { id: id, total:total },
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
   function guardar_precio_pieza(id){
       var total = $("#id_pi_"+id).val();
       
       var URL = base_url + "ordenes_trabajo/ajax_setPrecioPieza";
      //alert(CURRENT_QR);
   
       $.ajax({
           type: "POST",
           url: URL,
           data: { id: id, total:total },
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
   function agregarAnticipo(id){
       var URL = base_url + "ordenes_trabajo/ajax_setAnticipo";
       var anticipo = $("#anticipo").val().trim();
   
      
           
   
           $.ajax({
               type: "POST",
               url: URL,
               data: { anticipo : anticipo, wo:wo },
               success: function(result) {
                   if(result)
                   {
                       $('#mdlAnticipo').modal('hide');
                       cargarAnticipo(id)
                   }
               },
               error: function(data){
                   new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                   console.log(data);
               },
           });
       
   }
   function cargarAnticipo(id){
       var URL = base_url + "ordenes_trabajo/ajax_getAnticipos";
           $('#tblAnticipos tbody tr').remove();
           var total_anticipo=0;
           var total=0;
       $.ajax({
           type: "POST",
           url: URL,
           data: { id : id },
           success: function(result) {
               if(result)
               {
                    var tab = $('#tblAnticipos tbody')[0];
                   var rs = JSON.parse(result);
                   $.each(rs, function(i, elem){
                       var ren = tab.insertRow(tab.rows.length);
                       total_anticipo = total_anticipo+Number(elem.cantidad);
                       ren.insertCell().innerHTML = "$ "+elem.cantidad;
                       ren.insertCell().innerHTML = elem.fecha;
                       ren.insertCell().innerHTML = elem.user;
                   });

                   document.getElementById('lbltotal_abonado').innerHTML = 'Total Abonado: $' + total_anticipo.toFixed(2);
actualizarRestante();
   
                   
               }
           },
           error: function(data){
               new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
               console.log(data);
           },
       });
   }

     function actualizarRestante() {
    let totalGeneral = parseFloat(document.getElementById('ptotal').innerText.replace(/[^\d.-]/g, '')) || 0;
    let totalAbonado = parseFloat(document.getElementById('lbltotal_abonado').innerText.replace(/[^\d.-]/g, '')) || 0;
//alert(totalAbonado);
    let restante = totalGeneral - totalAbonado;
    document.getElementById('lblrestante').innerHTML = 'Restante: $' + restante.toFixed(2);
}
   function cancelarWO() {
      var URL = base_url + "ordenes_trabajo/cancelar_wo";
    
      if (confirm('Desea cancelar la Orden de Trabajo?')){
   $.ajax({
           type: "POST",
           url: URL,
           data: { id : wo },
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
      
   }
   function uploadFoto(){
     var files = document.getElementById("imgAuto").files;
     var file = files[0];
     var URL = base_url + 'ordenes_trabajo/subir_archivo';
     var formdata = new FormData();
     formdata.append("file", file);
     formdata.append("wo", wo);
     var ajax = new XMLHttpRequest();
     ajax.open("POST", URL);
     ajax.send(formdata);
     ajax.onload = function(){
       window.location.reload();
     }
   } 
</script>
</body>
</html>