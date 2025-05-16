<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Privilegios extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('privilegios_model');
        $this->load->model('conexion_model','Conexion');
    }

    function index() {
        //$this->output->enable_profiler(TRUE);
        $datos['privilegios'] = $this->privilegios_model->listadoPuestos();
        $this->load->view('header');
        $this->load->view('privilegios/roles', $datos);
    }

    public function administrar($id_privilegio) {
        $datos['privilegio'] = $this->privilegios_model->getPrivilegios($id_privilegio);
        $this->load->view('header');
        $this->load->view('cambiar_privilegios', $datos);
    }

    function agregar() {
      $ACIERTOS = array(); $ERRORES = array();

        $nombre_puesto = trim(strtoupper($this->input->post('puesto')));
        $datos = array('puesto' => $nombre_puesto);
        if($this->privilegios_model->agregarPuesto($datos))
        {
          $acierto = array('titulo' => $nombre_puesto, 'detalle' => 'Se han agregado Rol');
          array_push($ACIERTOS, $acierto);
        }
        else {
          $error = array('titulo' => 'ERROR', 'detalle' => 'Error al agregar Rol');
          array_push($ERRORES, $error);
        }

        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('privilegios'));
    }

    public function modificar() {
        $ACIERTOS = array(); $ERRORES = array();
        /*$aprobador_compras = $this->input->post('opAprobadorCompra');
        $aprobador_compras_venta = $this->input->post('opAprobadorCompra_venta');
        $aprobador_cotizacion = $this->input->post('opAprobadorCotizacion');*/
        $usuario = $this->input->post('usuario');


        //SET APROBADOR
	if (filter_var($this->input->post('autorizarTC'), FILTER_VALIDATE_BOOLEAN) ==true) {
            $aprobadorTC=$usuario;
        }else{
            $aprobadorTC = $this->input->post('autorizadorTC');
        }
/*
        $query = "UPDATE usuarios set autorizador_compras = $aprobador_compras, autorizador_compras_venta = $aprobador_compras_venta, autorizador_cotizacion = $aprobador_cotizacion where id=$usuario";
        $this->Conexion->comando($query);*/


        $datos = array(
            'usuario' => $usuario,
            'administrar_usuarios' => filter_var($this->input->post('administrar_usuarios'), FILTER_VALIDATE_BOOLEAN),
	        'produTC'=> filter_var($this->input->post('produTC'), FILTER_VALIDATE_BOOLEAN),
            'crearPedidosTC'=> filter_var($this->input->post('crearPedidosTC'), FILTER_VALIDATE_BOOLEAN),
            'autorizarTC'=> filter_var($this->input->post('autorizarTC'), FILTER_VALIDATE_BOOLEAN),
            'movimientosTC'=> filter_var($this->input->post('movimientosTC'), FILTER_VALIDATE_BOOLEAN),
            'crear_garantia'=> filter_var($this->input->post('crear_garantia'), FILTER_VALIDATE_BOOLEAN),
            'retiro'=> filter_var($this->input->post('retiro'), FILTER_VALIDATE_BOOLEAN),
            'crear_carrito'=> filter_var($this->input->post('crear_carrito'), FILTER_VALIDATE_BOOLEAN),
            'crear_venta'=> filter_var($this->input->post('crear_venta'), FILTER_VALIDATE_BOOLEAN),
            'crear_orden'=> filter_var($this->input->post('crear_orden'), FILTER_VALIDATE_BOOLEAN),
            'crear_scrap'=> filter_var($this->input->post('crear_scrap'), FILTER_VALIDATE_BOOLEAN),
            'adm_scrap'=> filter_var($this->input->post('adm_scrap'), FILTER_VALIDATE_BOOLEAN),
            'admin_orden'=> filter_var($this->input->post('admin_orden'), FILTER_VALIDATE_BOOLEAN),


        );

        if ($this->privilegios_model->setPrivilegios($datos, $usuario)) {
            if($this->session->id == $usuario)
            {
              $this->load->model('usuarios_model');
              $this->session->privilegios = $this->usuarios_model->getPrivilegios($this->session->id);
            }
            $acierto = array('titulo' => 'Privilegios', 'detalle' => 'Se han modificado Privilegios');
            array_push($ACIERTOS, $acierto);
        } else {
            $error = array('titulo' => 'ERROR', 'detalle' => 'Error al modificar Privilegios');
            array_push($ERRORES, $error);
        }
        $this->session->aciertos = $ACIERTOS;
        $this->session->errores = $ERRORES;
        redirect(base_url('usuarios/ver/'). $usuario);
    }

}
