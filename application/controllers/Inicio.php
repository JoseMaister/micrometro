<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function index() {
          $this->load->model('Ordenes_model', 'Modelo');

        //$this->output->enable_profiler(TRUE);
        if(isset($this->session->id))
        {
          $id = $this->session->id;
         

          $datos['tickets'] = $this->Modelo->getMis_tickets_pendientes($this->session->id);
      
        }

        $this->load->view('header');
        $this->load->view('inicio', $datos);
    }

    function primera_sesion()
    {
        $this->load->view('inicio/capturar_datos');
    }

    /*function manual()
    {
      $this->load->helper('download');
      echo '<a href="'.base_url('template/files/test.zip').'">asdasdas</a>';
      force_download('Manual.zip', file_get_contents(base_url('template/files/test.zip')));
    }*/

    function confirmar_datos()
    {
      $this->load->model('inicio_model','Modelo');
      $ACIERTOS = array(); $ERRORES = array();

      $data['correo'] = trim($this->input->post('correo'));
      $data['password'] = sha1($this->input->post('password'));
      $data['activo'] = "1";
      if($this->Modelo->confirmarDatos($this->session->id, $data))
      {
        $this->session->correo = $data['correo'];
        $this->session->password = $data['password'];
        $acierto = array('titulo' => 'Datos Actualizados', 'detalle' => 'Recuerda que puedes iniciar sesión con tu Numero de Empleado o Correo');
        array_push($ACIERTOS, $acierto);
      }
      else
      {
        $error = array('titulo' => 'ERROR', 'detalle' => 'Error al actualizar Datos');
        array_push($ERRORES, $error);
      }
      $this->session->aciertos = $ACIERTOS;
      $this->session->errores = $ERRORES;
      redirect(base_url('inicio'));
    }

}
