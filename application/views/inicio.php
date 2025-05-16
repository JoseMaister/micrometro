<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <ul class="nav navbar-right panel_toolbox">
                     <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                     <li><a class="close-link"><i class="fa fa-close"></i></a>
                     </li>
                  </ul>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <center>
                     <img style="width: 60%;" src=<?= base_url('template/images/logo.png') ?>>
                  </center>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-sm-6 col-xs-12">
       <?php 

         if ($tickets) { ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tickets Pendientes</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">WO</th>
                                            <th class="column-title">Fecha de Comentario</th>
                                            <th class="column-title">Comentario</th>
                                            <th class="column-title">Estatus</th>
                                            <th class="column-title">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    <?php

                                    $BTN_CLASS = 'btn btn-default';
                                    foreach ($tickets->result() as $elem) {
                                        switch ($elem->estatus) {

                                            case 'ABIERTO':
                                                $BTN_CLASS = 'btn btn-primary';
                                                break;

                                            case 'EN CURSO':
                                                $BTN_CLASS = 'btn btn-info';
                                                break;

                                            case 'DETENIDO':
                                                $BTN_CLASS = 'btn btn-warning';
                                                break;

                                            case 'CANCELADO':
                                                $BTN_CLASS = 'btn btn-default';
                                                break;

                                            case 'CONCLUIDA':
                                                $BTN_CLASS = 'btn btn-success';
                                                break;

                                            case 'CERRADO':
                                                $BTN_CLASS = 'btn btn-dark';
                                                break;
                                        }
                                        ?>
                                            <tr class="even pointer">
                                                <td><?= str_pad($elem->wo, 6, "0", STR_PAD_LEFT) ?></td>
                                                <td>
                                                    <?php $date = date_create($elem->fecha); ?>
                                                    <a><?= date_format($date, 'd/m/Y h:i A'); ?></a>
                                                </td>
                                                <td><?= $elem->comentario ?></td>
                                                <td><a href=<?= base_url("ordenes_trabajo/ver_wo/" . $elem->wo) ?>><button type="button" class=<?= "'" . $BTN_CLASS . "'" ?> ><?= $elem->estatus ?></button></a></td>
                                                <td><a href=<?= base_url("ordenes_trabajo/cerrar_comentario/" . $elem->id) ?>><button type="button" class="btn btn-dark" >Cerrar</button></a></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                <?php }
              ?>

</div>
         <!-----Esto-->
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
<!-- SCRIPTS -->
<div id="custom_notifications" class="custom-notifications dsp_none">
   <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
   </ul>
   <div class="clearfix"></div>
   <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<script>
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
   
   
   
</script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
</body>
</html>