<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="icon" href=<?= base_url("template/images/logo.ico"); ?>>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Inicio de Sesión</title>

  <!-- Bootstrap -->
  <link href=<?= base_url('template/vendors/bootstrap/dist/css/bootstrap.min.css'); ?> rel="stylesheet">
  <!-- Font Awesome -->
  <link href=<?= base_url('template/vendors/font-awesome/css/font-awesome.min.css'); ?> rel="stylesheet">
  <!-- NProgress -->
  <link href=<?= base_url('template/vendors/nprogress/nprogress.css'); ?> rel="stylesheet">
  <!-- Animate.css -->
  <link href=<?= base_url('template/vendors/animate.css/animate.min.css'); ?> rel="stylesheet">
  <!-- PNotify -->
  <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.css"); ?> rel="stylesheet">
  <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.css"); ?> rel="stylesheet">
  <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.css"); ?> rel="stylesheet">
  

  <!-- Custom Theme Style -->
  <link href=<?= base_url('template/build/css/custom.min.css'); ?> rel="stylesheet">

  <style type="text/css">
    #video {
      position: fixed;
      right: 0;
      bottom: 0;
      min-width: 100%;
      min-height: 100%;
    }
.form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.login-title
{
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
  </style>
</head>

<body class="login">

  
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            
            <div class="account-wall">
                <img class="profile-img" src=<?= base_url('template/images/logos_login.png') ?> alt="">
                <form class="form-signin" method="POST" action=<?= base_url('login/autenticar') ?>>
                <input type="text" class="form-control" name="user" placeholder="Usuario" required="">
                <input type="password" class="form-control" placeholder="Password" name="pass" required>
                <button class="btn btn-lg btn-dark btn-block" type="submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>
   
  </div>

<!-- jQuery -->
<script src=<?=base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>


<script>

$(function(){
  notificaciones();
});

function notificaciones(){
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
    }


    function password(){
  window.location.href = '<?= base_url('seguridad/recuperacion_password'); ?>'
}

var cuadro = document.getElementById("log");


function myFunction() {
  if(cuadro.style.display == "none")
  {
    cuadro.style.display = "block";
  }
  else
  {
    cuadro.style.display = "none";
  }
}



</script>



  </body>
</html>
