<?php
$venc = date("y-m-d", strtotime($this->session->vencimiento_password));
$today = date("y-m-d", strtotime("today"));

if (!isset($this->session->activo))
{
    redirect(base_url('login'));
    exit();
}
else
{
   if($this->session->password == sha1($this->session->no_empleado))
    {
        redirect(base_url('inicio/primera_sesion'));
        exit();
    }
    if($today >= $venc)
    {
        redirect(base_url('seguridad/vencimiento_password'));
        exit();       
    }
    if(isset($url_actual))
    {
        $this->session->url_actual = $url_actual;
        
    }
  
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>  
        
        <!-- PARA NO LEER CACHE ELIMINAR DESPUES -->
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <!-- PARA NO LEER CACHE ELIMINAR DESPUES -->

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="icon" href="<?= base_url("template/images/logo.ico"); ?>">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EL MICROMETRO</title>

        <!-- Bootstrap -->
        <link href=<?= base_url("template/vendors/bootstrap/dist/css/bootstrap.css"); ?> rel="stylesheet">
        <!-- Font Awesome -->
        <link href=<?= base_url("template/vendors/font-awesome/css/font-awesome.min.css") ?> rel="stylesheet">
        <!-- NProgress -->
        <link href=<?= base_url("template/vendors/nprogress/nprogress.css") ?> rel="stylesheet">
        <!-- iCheck -->
        <link href=<?= base_url("template/vendors/iCheck/skins/flat/green.css") ?> rel="stylesheet">

        <!-- bootstrap-progressbar -->
        <link href=<?= base_url("template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css") ?> rel="stylesheet">
        <!-- JQVMap -->
        <link href=<?= base_url("template/vendors/jqvmap/dist/jqvmap.min.css") ?> rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.css"); ?> rel="stylesheet">

        <!-- PNotify -->
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.css"); ?> rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href=<?= base_url("template/build/css/custom.css"); ?> rel="stylesheet">
        <!-- Dropzone.js -->
        <link href=<?= base_url("template/vendors/dropzone/dist/min/dropzone.min.css"); ?> rel="stylesheet">
        <!-- FancyBox -->
        <link href=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.css"); ?> rel="stylesheet">
        <!-- Bootstrap Colorpicker -->
        <link href=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.css"); ?> rel="stylesheet">
        <!-- bootstrap-datetimepicker -->
        <link href=<?= base_url("template/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css") ?> rel="stylesheet">

        <!-- FullCalendar -->
        <link href=<?= base_url("template/vendors/fullcalendar/dist/fullcalendar.min.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/fullcalendar/dist/fullcalendar.print.css"); ?> rel="stylesheet" media="print">

    </head>





<!--    <div id="chat_zone">

        <div class="msg_box" style="right:50px;" rel="chatbox0">
            <div class="msg_head"><i class="fa fa-comments"></i> Chat</div>
            <div class="msg_wrap" style="display: none;">
                <div style="padding: 0;" class="msg_body">
                    <table id="tblChatUsers" style="width: 100%;" class="table">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    </div>-->



    

    <body class="nav-md">



        <div class="container body">
            <div class="main_container">


                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div style="border: 0; ">
                            <a href=<?= base_url('inicio'); ?> class="site_title"><img style="height: 60%;" src=<?= base_url('template/images/logoshort.png') ?>> <img style="height: 80%;" src=<?= base_url('template/images/logo_letras.png') ?>></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- /menu profile quick info -->


                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                
                                <ul class="nav side-menu">

                                    <li><a href=<?= base_url('inicio'); ?>><i class="fa fa-home"></i> Inicio </a></li>


                                    

                                    
                                      <?php if ($this->session->privilegios['administrar_usuarios']) { ?>

                                    <li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                                      <ul class="nav child_menu">
                                      
                                          <li><a href='<?= base_url("usuarios/alta") ?>'>Alta de Usuario</a></li>
                                       
                                        <li><a href='<?= base_url("usuarios") ?>'>Ver Usuarios</a></li>
                                        <li><a href='<?= base_url("usuarios/alta_cliente") ?>'>Alta Clientes</a></li>
                                        <li><a href='<?= base_url("usuarios/catalogo") ?>'>Ver Clientes</a></li>
                                      </ul>
                                    </li>

                                     <?php } ?>

                                    <li><a><i class="fa fa-gear"></i> Tool Crib<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">

                                            <?php if ($this->session->privilegios['produTC']) { ?>
                                            <li><a href=<?= base_url("toolcrib/inventario"); ?>> Productos</a></li>
                                            <li><a href=<?= base_url("servicios/"); ?>>Catalogo de Servicios</a></li>
                                            <?php } ?>
                                            <?php if ($this->session->privilegios['crearPedidosTC']) { ?>
                                            <li><a href=<?= base_url("toolcrib/tool_crib"); ?>> Pedidos</a></li>
                                            <?php } ?>
                                            <?php if ($this->session->privilegios['movimientosTC']) { ?>
                                            <li><a href=<?= base_url("toolcrib/pedidos"); ?>>Tool Crib</a></li>
                                            <?php } ?>
                                            <?php if ($this->session->privilegios['movimientosTC']) { ?>
                                            <li><a href=<?= base_url("toolcrib/movimientos"); ?>>Movimientos</a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>

                                    <?php if ($this->session->privilegios['crear_garantia']) { ?>
                                    <li><a><i class="fa fa-check"></i> Garantias<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href=<?= base_url("ventas/garantias"); ?>>Garantias</a></li>
                                            <li><a href=<?= base_url("ventas/catalogo_garantias"); ?>>Catalogo</a></li>
                                        </ul>
                                    </li>
                                     <?php } ?>
<!--  
                                     <?php if ($this->session->privilegios['retiro']) { ?>
                                    <li><a><i class="fa fa-bank"></i> Retiros<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href=<?= base_url("retiros/"); ?>>Retiros</a></li>
                                        </ul>
                                    </li>
 <?php } ?>
-->
                                    <li><a><i class="fa fa-money"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                                      <ul class="nav child_menu">
                                        <?php if ($this->session->privilegios['crear_carrito']) { ?>
                                        <li><a href='<?= base_url("ventas") ?>'>Crear Ventas</a></li>
                                         <?php } ?>
                                         <?php if ($this->session->privilegios['crear_venta']) { ?>
                                        <li><a href='<?= base_url("ventas/catalogo") ?>'>Cerrar Ventas</a></li>
                                        <?php } ?>
                                        <li><a href='<?= base_url("ventas/catalogo_ventas") ?>'>Catalogo Ventas</a></li>
                                        <li><a href='<?= base_url("ventas/catalogo_servicios") ?>'>Catalogo Servicios</a></li>
                                        <li><a href='<?= base_url("ventas/corte_caja") ?>'>Corte de Caja</a></li>
					<?php if ($this->session->privilegios['retiro']) { ?>
                                        <li><a href=<?= base_url("retiros/"); ?>>Retiros</a></li>
                                        <?php } ?>
                                      </ul>
                                    </li>
                                         <?php if ($this->session->privilegios['crear_orden']) { ?>

                                    <li><a><i class="fa fa-briefcase"></i> Ordenes de Trabajo<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href=<?= base_url("ordenes_trabajo/"); ?>>Ordenes de Trabajo</a></li>

                                            

                                        </ul>
                                    </li>
<?php } ?>

                             <li><a><i class="fa fa-trash"></i> Scrap<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                             <?php if ($this->session->privilegios['crear_scrap']) { ?>
                                            <li><a href=<?= base_url("scrap/"); ?>> Crear Ticket</a></li>
                                            <?php } 
                                            if ($this->session->privilegios['adm_scrap']) {
                                                ?>
                                            <li><a href=<?= base_url("scrap/catalogo"); ?>> Catalogo</a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                  

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>




                <!-- top navigation -->
                <div class="top_nav">

                    <div class="nav_menu">


                        <nav>
                                    
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src=<?= 'data:image/bmp;base64,' . base64_encode($this->session->foto); ?> alt=""><?= $this->session->nombre ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href=<?= base_url('usuarios/foto') ?>><i class="fa fa-camera pull-right"></i> Subir Foto</a></li>
                                        <li><a data-toggle="modal" data-target=".bs-example-modal-sm-pass"><i class="fa fa-key pull-right"></i> Cambiar Contraseña</a></li>
                                        <li><a href=<?= base_url('login/cerrar_sesion') ?>><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- Dialogo agregar -->
                <div class="modal fade bs-example-modal-sm-pass" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Cambiar Contraseña</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action=<?= base_url('usuarios/modificar_contrasena') ?>>
                                    <div class="item form-group">
                                        <div class="col-xs-12">
                                            <label class="control-label col-xs-12" for="oldpass">Contraseña Antigüa</label>
                                            <input type="password" required="required" name="oldpass" id="oldpass" class="form-control col-xs-12"/>
                                            <label class="control-label col-xs-12" for="newpass">Nueva Contraseña</label>
                                            <input type="password" required="required" name="newpass" id="newpass" class="form-control col-xs-12"/>
                                            <label class="control-label col-xs-12" for="newpass1">Repetir Contraseña</label>
                                            <input type="password" required="required" name="newpass1" id="newpass1" class="form-control col-xs-12"/>
                                        </div>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" value="Modificar">
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- /Dialogo agregar -->
<audio id="chatBeep">
  <source src=<?= base_url("template/audio/beep.mp3") ?> type="audio/mpeg">
</audio>

<script>
    const base_url = '<?= base_url(); ?>';
    var CHATS_WINDOWS = JSON.parse('<?= $this->session->chats; ?>');
    const ID_USER = '<?= $this->session->id ?>';
    const HTTP_HOST = '<?= $_SERVER['HTTP_HOST']; ?>';
    const PRIVILEGIOS = JSON.parse('<?= json_encode($this->session->privilegios); ?>');

    
</script>
<!-- Moment -->
<script src=<?= base_url("template/vendors/moment/min/moment.min.js") ?>></script>
 
