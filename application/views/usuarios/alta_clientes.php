<!-- page content -->
<div class="right_col" role="main">
  
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Registrar Cliente</h2>
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
                        <form method="POST" action=<?= base_url('usuarios/registrar_cliente') ?> class="form-horizontal form-label-left" novalidate>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre(s) <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="name" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <!--<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Apellido(s) <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="apellidos" class="form-control col-md-7 col-xs-12" name="apellidos" placeholder="" required="required" type="text">
                                </div>
                            </div>-->
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="emtelefonoail">Telefono <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="telefono" name="telefono" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Correo <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" id="email" name="correo" class="form-control col-md-7 col-xs-12" >
                                </div>
                            </div>
                            <!--<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rfc">RFC <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="rfc" name="rfc"  class="form-control col-md-7 col-xs-12" mask="AAAAAAAAAA-AAA">
                                </div>
                            </div>-->
<!--                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dir_fiscal">Direccion Fiscal <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="dir_fiscal" class="form-control col-md-7 col-xs-12" name="dir_fiscal" placeholder="" type="text" >
                                </div>
                            </div>-->
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dir_fiscal">Numero Ext. <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="num_exterior" class="form-control col-md-7 col-xs-12" name="num_exterior" placeholder="" type="text" >
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dir_fiscal">Numero Int. (Opc.) <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="num_interior" class="form-control col-md-7 col-xs-12" name="num_interior" placeholder="" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dir_fiscal">Colonia <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="colonia" class="form-control col-md-7 col-xs-12" name="colonia" placeholder="" type="text" >
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dir_fiscal">Ciudad <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="ciudad" class="form-control col-md-7 col-xs-12" name="ciudad" placeholder="" type="text" >
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dir_fiscal">Codigo Postal <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input style="text-transform: uppercase;" id="codigo_postal" class="form-control col-md-7 col-xs-12" name="codigo_postal" placeholder="" type="text" >
                                </div>
                            </div>
                           

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">Crear Cliente</button>
                                </div>
                            </div>
                        </form>
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

<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<script src=<?= base_url("template/vendors/jquery.mask.min.js"); ?>></script>


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
<script>
    $(document).ready(function(){
      $('#rfc').mask('AAAAAAAAAA-AAA');
    });
  </script>

</body>
</html>
