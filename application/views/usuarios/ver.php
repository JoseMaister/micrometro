

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?= $usuario->no_empleado ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="usuario img-responsive avatar-view" src="<?= 'data:image/bmp;base64,' . base64_encode($usuario->foto); ?>">
                        </div>
                      </div>
                      <h3><?= ucwords(strtolower($usuario->User)) ?></h3>

                      <ul class="list-unstyled user_data">
                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?= ucfirst(strtolower($usuario->puesto)) ?>
                        </li>
                        <li>
                          <i class="fa fa-envelope user-profile-icon"></i> <?= $usuario->correo ?>
                        </li>
                        <li>
                          <?php $date = date_create($usuario->ultima_sesion); ?>
                          <i class="fa fa-clock-o user-profile-icon"></i> <small>Ultima Sesión: <?= date_format($date, 'd/m/Y h:i A'); ?></small>
                        </li>
                      </ul>
                      <?php if ($this->session->privilegios['administrar_usuarios']) { ?>
                      <div class="row">
                              <div class="col-md-12" style="margin-top: 50px;">
                                <center>
                                  <button  type="button" id="" onclick="mdlPass()" class="btn btn-primary"><i class='fa fa-lock'></i> Cambiar contraseña</button>
                                </center>
                              </div>
                            </div>
                            <?php } ?>
                    </div>

                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Datos de Usuario</a></li>

                          <?php if ($this->session->privilegios['administrar_usuarios']) { ?>
                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Privilegios</a></li>
                          <?php } ?>
                        </ul>
                        <div id="myTabContent" class="tab-content">

                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Nombre:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtNombre" readonly>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>A. Paterno:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtPaterno" readonly>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>A. Materno:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtMaterno" readonly>
                              </div>
                              <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Departamento:</label>
                                <input style="text-transform: uppercase;" maxlength="80" class="form-control" id="txtDepartamento" readonly>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Correo:</label>
                                <input style="text-transform: lowercase;" maxlength="100" class="form-control" id="txtCorreo" readonly>
                              </div>

			     <?php if ($this->session->privilegios['administrar_usuarios']) { ?>
                              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Password Correo:</label>
                                <input  maxlength="100" class="form-control" id="txtPassCorreo" readonly>
                              </div>
                              <?php } ?>

                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Puesto:</label>
                                <select class="select2_single form-control" id="opPuesto">
                                </select>
                              </div>
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label>Jefe Directo:</label>
                                <select class="select2_single form-control" id="opJefeDirecto">
                                </select>
                              </div>
                              <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <label style="display: block;">Activo:</label>
                                <input style="display: block;" type="checkbox" class="flat" id="cbActivo" readonly>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12" style="margin-top: 50px;">
                                <center>
                                  <button style="display: none;" type="button" id="btnGuardarDatos" onclick="guardarDatos()" class="btn btn-success"><i class='fa fa-save'></i> Guardar Datos</button>
                                </center>
                              </div>
                            </div>
                            
                          </div>

                          <?php if ($this->session->privilegios['administrar_usuarios']) { ?>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <form method="POST" id="frmPrivilegios" action=<?= base_url("privilegios/modificar/") ?> >
                              <input type="hidden" name="usuario" value=<?= $usuario->id ?>>
                              <div class="row">
                              <div class="col-xs-2">
                                <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-left">
                                  <li class="active"><a href="#usuarios" data-toggle="tab">Usuarios</a></li>
                                 
				                          <li><a href="#tool_crib" data-toggle="tab">Tool Crib</a></li>
                                  <li><a href="#garantias" data-toggle="tab">Garantia</a></li>
                                  <li><a href="#retiro" data-toggle="tab">Retiros</a></li>
                                  <li><a href="#venta" data-toggle="tab">Ventas</a></li>
                                  <li><a href="#ordenes" data-toggle="tab">Ordenes de Trabajo</a></li>
                                  <li><a href="#scrap" data-toggle="tab">Scrap</a></li>
                                </ul>
                              </div>
                              <div class="col-xs-10">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                  <div class="tab-pane active" id="usuarios">
                                    <p class="lead">Usuarios</p>
                                    <label>
                                      Administrar Usuarios <input type="checkbox" name="administrar_usuarios" class="flat" <?= $privilegio->administrar_usuarios == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>


				                          <div class="tab-pane" id="tool_crib">
                                    <p class="lead">Tool Crib</p>
                                    <label>
                                      Productos <input type="checkbox" name="produTC" id="produTC" class="flat" <?= $privilegio->produTC == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Crear Pedidos <input type="checkbox" name="crearPedidosTC" id="crearPedidosTC" class="flat" <?= $privilegio->crearPedidosTC == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Aprobador <input type="checkbox" id="autorizarTC" name="autorizarTC" class="flat" <?= $privilegio->autorizarTC == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Movimientos <input type="checkbox" id="movimientosTC" name="movimientosTC" class="flat" <?= $privilegio->movimientosTC == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <div style="margin-top: 25px; margin-bottom: 20px;" id="divAprobadorCompras" class="row">
                                      <div class="col-md-6">
                                        <label>Aprobador de Tool Crib</label>
                                        <select style="width:80%;" id="autorizadorTC" name="autorizadorTC" class="select2_single form-control">'
                                          <option selected value="0">N/A</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="tab-pane" id="garantias">
                                    <p class="lead">Garantias</p>
                                    <label>
                                      Crear Garantia <input type="checkbox" name="crear_garantia" class="flat" <?= $privilegio->crear_garantia == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="retiro">
                                    <p class="lead">Retiros</p>
                                    <label>
                                      Retiros <input type="checkbox" name="retiro" class="flat" <?= $privilegio->retiro == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="venta">
                                    <p class="lead">Ventas</p>
                                    <label>
                                      Crear carrito <input type="checkbox" name="crear_carrito" class="flat" <?= $privilegio->crear_carrito == '1' ? 'checked' : '' ?> />
                                    </label>
                                    <label>
                                      Crear venta <input type="checkbox" name="crear_venta" class="flat" <?= $privilegio->crear_venta == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>
                                   <div class="tab-pane" id="ordenes">
                                    <p class="lead">Ordenes de Trabajo</p>
                                    <label>
                                      Crear orden <input type="checkbox" name="crear_orden" class="flat" <?= $privilegio->crear_orden == '1' ? 'checked' : '' ?> />
                                    </label>
                                   <label>
                                      Administrar ordenes <input type="checkbox" name="admin_orden" class="flat" <?= $privilegio->admin_orden == '1' ? 'checked' : '' ?> />
                                    </label>
                                  </div>

                                  <div class="tab-pane" id="scrap">
                                    <p class="lead">Scrap</p>
                                    <label>
                                      Crear Ticket de Scrap <input type="checkbox" name="crear_scrap" class="flat" <?= $privilegio->crear_scrap == '1' ? 'checked' : '' ?> />
                                      Administrar Scrap<input type="checkbox" name="adm_scrap" class="flat" <?= $privilegio->adm_scrap == '1' ? 'checked' : '' ?> />

                                    </label>
                                   
                                  </div>


                                </div>

                              </div>
                              </div>
                              <center>
                                <input type="submit" id="btnEditarPrivilegios" onclick="guardarAprobador()" class="btn btn-success" value="Editar Privilegios" />
                              </center>
                            </form>
                          </div>
                          <?php } ?>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

    <div id="mdlPass" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="lblCodigo">Cambiar Contraseña</h4>
         </div>
         <div class="modal-body">
           <form method="POST" action=<?= base_url('usuarios/new_pass') ?> class="form-horizontal form-label-left" novalidate>
        <div class="form-group">
          <label for="exampleInputEmail1">Nueva Contraseña</label>
          <input type="hidden" class="form-control" id="id" name="id" placeholder="Contraseña" value="<?= $usuario->id ?>">
          <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <hr />

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
    <script src=<?=base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?=base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?=base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?=base_url("template/vendors/nprogress/nprogress.js"); ?>></script>
    <!-- morris.js -->
    <script src=<?=base_url("template/vendors/raphael/raphael.min.js"); ?>></script>
    <script src=<?=base_url("template/vendors/morris.js/morris.min.js"); ?>></script>
    <!-- bootstrap-progressbar -->
    <script src=<?=base_url("template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"); ?>></script>
    <!-- bootstrap-daterangepicker -->
    <script src=<?=base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
    <script src=<?=base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js"); ?>></script>
    <!-- Custom Theme Scripts -->
    <script src=<?=base_url("template/build/js/custom.js"); ?>></script>
    <!-- Switchery -->
    <script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
    <!-- PNotify -->
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
    <script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
    <!-- JS File -->
    <script src=<?= base_url("application/views/usuarios/js/ver.js"); ?>></script>

    <script>
    const ID = '<?= $usuario->id ?>';
    const AC = '<?= $usuario->autorizador_compras ?>';
    const ACV = '<?= $usuario->autorizador_compras_venta ?>';
    const ACOT = '<?= $usuario->autorizador_cotizacion ?>';
    const ATC = '<?= $usuario->autorizadorTC ?>';

    $(function(){
      load();
    });



    <?php
    if (isset($this->session->errores)) {
        foreach ($this->session->errores as $error) {
            echo "new PNotify({ title: '" . $error['titulo'] . "', text: '" . $error['detalle'] . "', type: 'error', styling: 'bootstrap3' });";
        }
        $this->session->unset_userdata('errores');
    }
    if (isset($this->session->aciertos)) {
        foreach ($this->session->aciertos as $acierto) {
            echo "new PNotify({ title: '" . $acierto['titulo'] . "', text: '" . $acierto['detalle'] . "', type: 'success', styling: 'bootstrap3' });";
        }
        $this->session->unset_userdata('aciertos');
    }
    ?>
    function mdlPass() {
       $('#mdlPass').modal();
    }
    </script>

  </body>
</html>
