<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Scrap extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('correos_po');
        $this->load->model('Tool_model','Modelo');
        //$this->load->library('AOS_funciones');
    }
    function index(){
        $this->load->model('Tool_model');

       $data['marcas'] = $this->Modelo->listadoMarcas();
        //echo var_dump($datos['venta']);die();
        ////$datos['vt']=$this->compras_model->ventatemp();
        $this->load->view('header');
        $this->load->view('scrap/scrap', $data);
    }
    function catalogo(){
        
        $this->load->view('header');
        $this->load->view('scrap/catalogo');
    }
    function garantias(){
        
        $this->load->view('header');
        $this->load->view('garantias/garantias');
    }

    function crear_garantia($id){
        $query="SELECT v.*, concat(u.nombre,' ', u.paterno) as vendedor, c.* FROM venta v JOIN clientes c on c.id=v.id_cliente JOIN usuarios u on u.id=v.idus WHERE v.id= ".$id;
    $res = $this->Conexion->consultar($query,true);

    //echo $query;die();
    $data['id']=$id;
    $data['venta']=$res;
    $data['detalles']=$this->Conexion->consultar("SELECT d.*, p.producto FROM detalles_venta d JOIN productos p on d.codigo=p.codigo WHERE d.id_venta = ".$id);
        $this->load->view('header');
        $this->load->view('garantias/crear_garantia', $data);
    }
    
    function ver_scrap($id){
        $query="SELECT dv.*, p.producto, p.codigo, u.ubicacion from detalles_scrap dv join scrap v on v.id=dv.id_scrap JOIN productos p on p.codigo=dv.codigo JOIN ubiProds u on dv.id_ubi=u.idUbi WHERE dv.id_scrap = ".$id;
    $res = $this->Conexion->consultar($query);
    //echo $query;die();
    $data['id']=$id;
    $data['venta']=$res;
        $this->load->view('header');
        $this->load->view('scrap/ver_scrap', $data);
    }

    function ajax_getProductos(){
    $texto=$this->input->post('texto');
    $query="SELECT p.idProducto, p.producto, p.codigo, p.precio, u.ubicacion, u.idUbi from productos p JOIN ubiProds u on p.idProducto=u.idProd WHERE p.codigo = '$texto'";
    $res = $this->Conexion->consultar($query);
    //echo $query;die();

    if($res)
        {
            echo json_encode($res);
        }

}
 function ajax_setVentaTemp()
{
    $qty=$this->input->post('qty');
    $codigo=$this->input->post('codigo');
    $ubi=$this->input->post('ubi');
    
    $data  = array(
        'id_us' => $this->session->id, 
        'codigo' => $codigo,
        'id_ubi' => $ubi,
        'qty' => $qty,
    );
    $res = $this->Conexion->insertar("scrap_temp", $data);
    

    if($res)
        {
           echo 1;
        }
}

 function ajax_getVentaTemp()
{
     $query="SELECT v.*, p.producto, p.precio, p.codigo,u.ubicacion FROM scrap_temp v JOIN productos p on v.codigo=p.codigo join ubiProds u on u.idUbi=v.id_ubi WHERE v.id_us =".$this->session->id;
    $res = $this->Conexion->consultar($query);
    //echo $query;die();

    if($res)
        {
            echo json_encode($res);
        }
}
function ajax_set_venta()
{
      $total=$this->input->post('total');
    
    $data  = array(
        'idus' => $this->session->id, 
        'total' => $total,
         'estatus'=>'CREADA',
    );
    $res = $this->Conexion->insertar("scrap", $data);

    $temp = $this->Conexion->consultar("SELECT v.*, p.precio from scrap_temp v JOIN productos p on p.codigo=v.codigo WHERE v.id_us=".$this->session->id);

    foreach ($temp as $key) {
        $data = array(
            'id_scrap' =>$res,
            'codigo' =>$key->codigo,
            'qty' =>$key->qty,
            'id_ubi' =>$key->id_ubi,
            'precio' =>$key->precio,

              );
         $this->Conexion->insertar("detalles_scrap", $data);
    }
  $result=  $this->Conexion->comando("DELETE FROM scrap_temp WHERE id_us =".$this->session->id);


    if($result)
        {
           echo 1;
        }
}
function ajax_get_locales()
{
     $id=$this->input->post('id');
     $query="SELECT * FROM ubiProds where idProd=".$id;
    $res = $this->Conexion->consultar($query);
    //echo $query;die();

    if($res)
        {
            echo json_encode($res);
        }
}
function ajax_getVentas()
{
    $estatus = $this->input->post('estatus');
    $texto = $this->input->post('texto');
    $parametro = $this->input->post('parametro');
    $fecha1 = $this->input->post('fecha1');
    $fecha2 = $this->input->post('fecha2');
    $f1=strval($fecha1).' 00:00:00';
    $f2=strval($fecha2).' 23:59:59';

    $result = $this->Conexion->consultar("SELECT s.*, concat(u.nombre, ' ', u.paterno) as user from scrap s join usuarios u on s.idus=u.id where estatus = '$estatus'");

    if(!empty($texto))
        {
            if($parametro == "id")
            {
                $query .= " and v.id = '$texto'";
            }
            if($parametro == "user")
            {
                $query .= " having user like '%$texto%'";
            }
        }
    if (!empty($fecha1) && !empty($fecha2)) {
            $query .=" and v.fecha BETWEEN '".$f1."' AND '".$f2."' ";
        }
    

    if($result)
        {
         echo json_encode($result);  
        }
}
function ajax_cerrar_venta(){
    $id=$this->input->post('id');
    $motivo=$this->input->post('motivo');
    $res= $this->Conexion->consultar("SELECT d.*, p.idProducto, u.ubicacion FROM detalles_scrap d JOIN productos p on  d.codigo=p.idProducto JOIN ubiProds u on u.idUbi=d.id_ubi JOIN scrap v on v.id=d.id_scrap where d.id_scrap=".$id);
    foreach ($res as $key) {
        $prod =$this->Conexion->consultar("SELECT * from ubiProds where idUbi=".$key->id_ubi, true);
        $cant=intval($prod->cantidad) - intval($key->qty);
        $this->Conexion->comando("UPDATE ubiProds SET cantidad ='".$cant."' where idUbi=".$key->id_ubi); 

        $mov = array(
            'idProd'=>$key->idProducto,
            'idus' => $this->session->id,
            'cantidad'=>$key->qty,
            'local'=>$key->ubicacion,
            'tipo'=>'SCRAP',
            'comentario'=>$motivo,
            'fecha' => date('Y-m-d'),
        );
        //cho 'kakaka';
        $id_inserted = $this->Modelo->registrarMov($mov);       
    }

    
    $data  = array(
        'motivo'=>$motivo,
        'estatus'=>'CERRADA',

    );
    $res=$this->Conexion->modificar('scrap', $data, null, array('id' => $id));
    if ($res) {
        echo 1;
    }

}

function ajax_getClientes(){
        $texto = $this->input->post('texto');
        $cliente = $this->input->post('cliente');
        $query = "SELECT * FROM clientes where 1=1 ";

        if ($cliente == 'telefono') {
            $query .= " and telefono = '$texto' ";
        }else if ($cliente == 'correo') {
            $query .= " and correo = '$texto' ";
        }


        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }

    }
function ajax_getCliente(){
        $id = $this->input->post('id');

        $query = "SELECT * from clientes where id='" . $id . "'";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }

    }
function ajax_setCliente(){
    $id_cliente = $this->input->post('id');
    $venta = $this->input->post('venta');
     $data  = array(
        'id_cliente' =>$id_cliente ,

    );
    $res=$this->Conexion->modificar('venta', $data, null, array('id' => $venta));
    if($res)
        {
            echo 1;
        }

}
function ajax_getGarantias()
{
    $parametro = $this->input->post('parametro');
    $texto = $this->input->post('texto');

    $query="SELECT v.*, c.nombre from venta v JOIN clientes c on c.id =v.id_cliente WHERE 1=1  ";

    if ($parametro=='venta') {
        $query .=" and v.id='$texto'";
    }else if($parametro=='cliente'){
        $query .=" and c.nombre like '%".$texto."%'";
    }
    $result = $this->Conexion->consultar($query);
    if($result)
        {
         echo json_encode($result);  
        }
}
function ajax_setGarantia(){
      $accion = $this->input->post('accion');
    $motivo = $this->input->post('motivo');
    $venta = $this->input->post('venta');
$data  = array(
        'idus' => $this->session->id, 
        'motivo' => $motivo,
        'accion' => $accion,
        'id_venta' => $venta,
    );
    $result = $this->Conexion->insertar("garantia", $data);
    if($result)
        {
         echo json_encode($result);  
        }
}


}

?>