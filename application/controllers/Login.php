<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->library('correos_tickets');
    }

    function index() {
        date_default_timezone_set('America/Chihuahua');
        $data['url_actual'] = base_url('inicio');
        if(isset($this->session->url_actual))
        {
          $data['url_actual']=$this->session->url_actual;
        }
        $this->session->sess_destroy();
        $this->load->view('login', $data);
    }

    function autenticar() {
        //$this->output->enable_profiler(TRUE);
        $url_actual = $this->input->post('url_actual');
        $usuario = $this->input->post('user');
        $pass = $this->input->post('pass');
        $res = $this->usuarios_model->autenticar($usuario, $pass);
        if ($res) {
            $row = $res->row();
            $this->session->nombre = $row->User;
            $this->session->id = $row->id;
            $this->session->no_empleado = $row->no_empleado;
            $this->session->password = $row->password;
            $this->session->vencimiento_password = $row->vencimiento_password;
            $this->session->password_correo = $row->password_correo;
            $this->session->correo = $row->correo;
            $this->session->puesto = $row->puesto;
            $this->session->activo = $row->activo;
            $this->session->foto = $row->foto;
            $this->session->chats = '{ "chatbox0" : "CHAT"}';
            $this->session->departamento = $row->departamento;

            //SE LEEN LAS TABLAS DE PRIVILEGIOS SEGUN EL PUESTO
            $this->session->privilegios = $this->usuarios_model->getPrivilegios($this->session->id);

            $this->usuarios_model->ultimaSesion($row->id);
            
            /*
            $fecha = date("y-m-d", strtotime($row->ultima_sesion));
            $today = date("y-m-d", strtotime("today"));
            */

            $us = $this->Conexion->consultar("SELECT max(ultima_sesion) as us from usuarios", true);
            $fecha = date("y-m-d", strtotime($us->us));
            $today = date("y-m-d", strtotime("today"));
            
            
            redirect($url_actual);


        } else {
            $ERRORES = array();
            $error = array('titulo' => 'ERROR', 'detalle' => 'Usuario y/o Contraseña incorrectas');
            array_push($ERRORES, $error);
            $this->session->errores = $ERRORES;

            $this->session->url_actual = $url_actual;
            redirect(base_url('login'));
        }
    }

    public function cerrar_sesion() {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

}
