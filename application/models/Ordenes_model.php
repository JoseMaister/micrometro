<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ordenes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function registrar_orden($datos) {
        $this->db->db_debug = FALSE;
    
        if($this->db->insert('ordenes_trabajo', $datos)){
          return $this->db->insert_id();
         // echo var_dump($datos);die();
        }
        else {
          return FALSE;
      }
    }
     function get_wo($idp)
    {
        $this->db->select('wo.id as wo_id, wo.*, concat(a.nombre, " ", a.paterno) as asignado, c.* ');
        $this->db->where('wo.id',$idp);
        $this->db->from('ordenes_trabajo wo');
        $this->db->join('usuarios a', 'a.id = wo.id_asignado');
        $this->db->join('clientes c', 'c.id = wo.id_cliente');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            false;
        }
    }
     function get_wos(){
        //$this->db->select('P.id, P.puesto, (SELECT count(*) from usuarios where puesto=P.id ) as Usuarios');
        $this->db->select('wo.id as wo_id, wo.*, concat(a.nombre, " ", a.paterno) as asignado, c.* ');
        $this->db->from('ordenes_trabajo wo');
        $this->db->join('usuarios a', 'a.id = wo.id_asignado');
        $this->db->join('clientes c', 'c.id = wo.id_cliente');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
     function get_ticktets($id){
        //$this->db->select('P.id, P.puesto, (SELECT count(*) from usuarios where puesto=P.id ) as Usuarios');
        $this->db->select('tc.*, p.codigo, p.producto, dv.cantidad, dv.total as total_detalle ');
        $this->db->from('VentToolCrib tc');
        $this->db->join(' detalleVentTC dv', 'dv.idVenta=tc.idToolCrib');
        $this->db->join('productos p', 'p.idProducto=dv.idProd');
        $this->db->where('tc.id_servicio',$id);

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
     public function getMis_tickets_pendientes($id_usuario) {


        $query = $this->db->query("SELECT cw.*, wo.id as wo,wo.estatus from comentarios_wo cw JOIN ordenes_trabajo wo on wo.id=cw.id_wo WHERE cw.asignado='".$id_usuario."'  and atendido =0");
        if ($query->num_rows() > 0) {
            return $query;
        } else {
           return false;
        }
    }
    function subir_archivo($datos)
    {
         $this->db->db_debug = FALSE;
    
        if($this->db->insert('archivos_wo', $datos)){
          return $this->db->insert_id();
          echo var_dump($datos);die();
        }
        else {
          return FALSE;
      }
    }
    function verArchivos($id_ticket) {
        $this->db->where('id_wo', $id_ticket);
        $query = $this->db->get('archivos_wo');

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }
    function getFoto($id){
      $this->db->select('file');
      $this->db->where('id', $id);
      $res = $this->db->get('archivos_wo');
      if($res->num_rows() > 0)
      {
          return $res->row();
      }
      else
      {
          return false;
      }
    }
     function getFile($id, $tabla)
    {
        $this->db->where('id', $id);
        $res = $this->db->get($tabla);
        if($res->num_rows() > 0)
        {
            return $res->row();
        }
        else
        {
            return false;
        }
    }
    function comentarios_wo($id)
    {
       $query = $this->db->query("SELECT c.comentario, c.fecha, concat(u.nombre, ' ', u.paterno) as nombre, c.archivo FROM comentarios_wo c JOIN usuarios u on u.id=c.id_us WHERE 1=1 and c.id_wo = '$id'");
        if ($query->num_rows() > 0) {
            return $query;
        } else {
           return false;
        }
    }
}
