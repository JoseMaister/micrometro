<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('correos_po');
        $this->load->model('Tool_model','Modelo');
        //$this->load->library('AOS_funciones');
    }
    function index(){
        $this->load->model('Tool_model');

       $data['marcas'] = $this->Modelo->listadoMarcas();
       $data['caja']= $this->Conexion->consultar("SELECT caja from venta WHERE DATE(`fecha`) = curdate() AND caja is not null AND idus = ".$this->session->id." ORDER BY id DESC LIMIT 1", true);
        $this->load->view('header');
        $this->load->view('ventas/ventas', $data);
    }
    function catalogo(){
        
        $this->load->view('header');
        $this->load->view('ventas/catalogo');
    }
    function catalogo_ventas(){
        
        $this->load->view('header');
        $this->load->view('ventas/catalogo_ventas');
    }
     function catalogo_servicios(){
        
        $this->load->view('header');
        $this->load->view('ventas/catalogo_servicios');
    }
    function corte_caja(){
        $query="SELECT v.*, concat(u.nombre, ' ', u.paterno) as user FROM venta v join usuarios u on u.id=v.idus WHERE DATE(`fecha`) = CURDATE()";
    $data['venta'] = $this->Conexion->consultar($query);
    $data['caja']= $this->Conexion->consultar("SELECT caja from venta WHERE DATE(`fecha`) = curdate() AND caja is not null AND idus = ".$this->session->id." ORDER BY id DESC LIMIT 1", true);

        $this->load->view('header');
        $this->load->view('ventas/corte_caja', $data);
    }
    function garantias(){
        
        $this->load->view('header');
        $this->load->view('garantias/garantias');
    }
    function catalogo_garantias(){
        
        $this->load->view('header');
        $this->load->view('garantias/catalogo');
    }

    function crear_garantia($id){
        $query="SELECT v.*, concat(u.nombre,' ', u.paterno) as vendedor, c.* FROM venta v left JOIN clientes c on c.id=v.id_cliente JOIN usuarios u on u.id=v.idus WHERE v.id= ".$id;
    $res = $this->Conexion->consultar($query,true);

    //echo $query;die();
    $data['id']=$id;
    $data['venta']=$res;
    $data['detalles']=$this->Conexion->consultar("SELECT d.*, p.producto FROM detalles_venta d JOIN productos p on d.codigo=p.codigo WHERE d.id_venta = ".$id);
        $this->load->view('header');
        $this->load->view('garantias/crear_garantia', $data);
    }
    
    function ver_garantia($id){
        $query="SELECT g.*, v.*, c.*,concat(u.nombre,' ', u.paterno) as vendedor FROM garantia g JOIN venta v on v.id=g.id_venta JOIN clientes c on c.id= v.id_cliente JOIN usuarios u on u.id=v.idus WHERE g.id= ".$id;
    $res = $this->Conexion->consultar($query,true);

    //echo $query;die();
    $data['id']=$id;
    $data['venta']=$res;
    $data['detalles']=$this->Conexion->consultar("SELECT d.*, p.producto FROM detalles_venta d JOIN productos p on d.codigo=p.codigo WHERE d.id_venta = ".$res->id_venta);

    $this->load->model('tool_model');
        $this->load->model('privilegios_model');
        $data['productos']=$this->tool_model->ProdPedidos();
        $data['usuarios'] = $this->tool_model->listadoUsuarios();
        $data['usuarios'] = $this->privilegios_model->listadoJefes();
        //$datos['productos'] = $this->tool_model->listadoProductos();
        $data['tool'] = $this->tool_model->ventatemp();

        $data['ticket']=$this->Conexion->consultar("SELECT * from VentToolCrib WHERE id_garantia = ".$id);



        $this->load->view('header');
        $this->load->view('garantias/ver_garantia', $data);
    }

    function ver_venta($id){
        $query="SELECT dv.*, p.producto, p.codigo, u.ubicacion, v.id_cliente, c.nombre as cliente, v.total from detalles_venta dv join venta v on v.id=dv.id_venta JOIN productos p on p.idProducto=dv.codigo JOIN ubiProds u on dv.id_ubi=u.idUbi left join clientes c on c.id=v.id_cliente WHERE dv.id_venta = ".$id;
    $res = $this->Conexion->consultar($query);
    $estatus = $this->Conexion->consultar('select estatus FROM venta where id ='.$id, true);
    $total_anticipo=$this->Conexion->consultar('SELECT restante FROM pagos_venta where id_venta ="'.$id.'" ORDER BY fecha DESC LIMIT 1', true);
    //echo $query;die();
    $data['id']=$id;
    $data['venta']=$res;
    $data['estatus']=$estatus->estatus;
    if ($total_anticipo) {
        $data['total_anticipo']=$total_anticipo->restante;
    }
    
        $this->load->view('header');
        $this->load->view('ventas/ver_venta', $data);
    }


    function ver_servicio($id){
        $query="SELECT wo.*, concat(c.nombre, ' ',c.apellidos) as cliente FROM ordenes_trabajo wo join clientes c on c.id=wo.id_cliente WHERE wo.id = ".$id;
    $res = $this->Conexion->consultar($query);
    $estatus = $this->Conexion->consultar('select estatus FROM venta where id ='.$id, true);
    //echo $query;die();
    $data['id']=$id;
    $data['venta']=$res;
    //$data['estatus']=$estatus->estatus;
        $this->load->view('header');
        $this->load->view('ventas/ver_servicio', $data);
    }

 /*   function ajax_getProductos(){
    $texto=$this->input->post('texto');
    $modAuto=$this->input->post('modAuto');
    $year=$this->input->post('year');
    $slug=$this->input->post('slug');
    $motor=$this->input->post('motor');
    $query="SELECT p.idProducto, p.codigo, concat(p.producto, ' ',p.marca)as producto, p.precio, u.ubicacion, p.defecto from compatibles c JOIN productos p on p.idProducto=c.id_producto JOIN marcas m on m.id=c.id_marca join modelos mo on mo.Nombre= c.id_modelo left join ubiProds u on u.idUbi =p.defecto where 1=1";


if (!empty($modAuto) || !empty($year) || !empty($slug) || !empty($motor)) {
 $query.=  " and c.ano = '".$year."' and c.id_marca='".$slug."' AND c.id_modelo = '".$modAuto."' and p.producto like '%".$texto."%'  ";   
}
$query.=  "  and p.codigo like '%".$texto."%'  ";  
    $query .=" GROUP BY p.idProducto limit 100";
    $res = $this->Conexion->consultar($query);
    echo $query;die();

    if($res)
        {
            echo json_encode($res);
        }

}*/
function ajax_getProductos() {
    $texto   = trim($this->input->post('texto'));
    $modAuto = $this->input->post('modAuto');
    $year    = $this->input->post('year');
    $slug    = $this->input->post('slug');
    $motor   = $this->input->post('motor');

    $texto_esc = $this->db->escape_like_str($texto);

    // Consulta base con LEFT JOIN para no excluir productos
    $query = "
        SELECT 
            p.idProducto, 
            p.codigo, 
            CONCAT(p.producto, ' ', p.marca) AS producto, 
            p.precio, 
            u.ubicacion, 
            p.defecto 
        FROM productos p
        LEFT JOIN compatibles c ON p.idProducto = c.id_producto
        LEFT JOIN marcas m ON m.id = c.id_marca
        LEFT JOIN modelos mo ON mo.Nombre = c.id_modelo
        LEFT JOIN ubiProds u ON u.idUbi = p.defecto
        WHERE 1=1
    ";

    // Filtros opcionales (solo si se mandan)
    if (!empty($modAuto)) {
        $query .= " AND c.id_modelo = " . $this->db->escape($modAuto);
    }
    if (!empty($year)) {
        $query .= " AND c.ano = " . $this->db->escape($year);
    }
    if (!empty($slug)) {
        $query .= " AND c.id_marca = " . $this->db->escape($slug);
    }
    if (!empty($texto)) {
        $query .= " AND (p.codigo LIKE '%$texto_esc%' OR p.producto LIKE '%$texto_esc%')";
    }

    $query .= " GROUP BY p.idProducto LIMIT 100";

    $res = $this->Conexion->consultar($query);

    if ($res) {
        echo json_encode($res);
    } else {
        echo json_encode([]);
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
    $res = $this->Conexion->insertar("vent_temp", $data);
    

    if($res)
        {
           echo 1;
        }
}

 function ajax_getVentaTemp()
{
     $query="SELECT v.*, p.producto, p.precio,p.codigo, u.ubicacion FROM vent_temp v JOIN productos p on v.codigo=p.idProducto join ubiProds u on u.idUbi=v.id_ubi WHERE v.id_us =".$this->session->id;
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
        'tipo' => 'VENTA',
         'estatus'=>'CREADA',
    );
    $res = $this->Conexion->insertar("venta", $data);

    $temp = $this->Conexion->consultar("SELECT v.*, p.precio from vent_temp v JOIN productos p on p.idProducto=v.codigo WHERE v.id_us=".$this->session->id);

    foreach ($temp as $key) {
        $data = array(
            'id_venta' =>$res,
            'codigo' =>$key->codigo,
            'qty' =>$key->qty,
            'id_ubi' =>$key->id_ubi,
            'precio' =>$key->precio,

              );
         $this->Conexion->insertar("detalles_venta", $data);
    }
  $result=  $this->Conexion->comando("DELETE FROM vent_temp WHERE id_us =".$this->session->id);


    if($result)
        {
           echo 1;
        }
}
function ajax_del_venta()
{
  
  $result=  $this->Conexion->comando("DELETE FROM vent_temp WHERE id_us =".$this->session->id);


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

    $query = "SELECT v.*, concat(u.nombre, ' ', u.paterno) as user, concat(c.nombre, ' ', c.apellidos) as cliente from venta v join usuarios u on v.idus=u.id left join clientes c on c.id=v.id_cliente WHERE 1=1 ";

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
            if($parametro == "numero_cliente")
            {
                $query .= " and c.telefono = '$texto'";
            }
            if($parametro == "correo_cliente")
            {
                $query .= " and c.correo = '$texto'";
            }


        }
    if (!empty($fecha1) && !empty($fecha2)) {
            $query .=" and v.fecha BETWEEN '".$f1."' AND '".$f2."' ";
        }
    if($estatus != 'TODO')
        {
            $query .= " and v.estatus = '$estatus'";
        }
    
    $result = $this->Conexion->consultar($query);
    

    if($result)
        {
         echo json_encode($result);  
        }
}
function ajax_cerrar_venta(){
    $id=$this->input->post('id');
    $tipo=$this->input->post('tipo');
    $descuento=$this->input->post('descuento');
    $tipo_descuento=$this->input->post('tipo_descuento');
    $txt_desc=$this->input->post('txt_desc');
    $total_final=$this->input->post('total_final');

    $res= $this->Conexion->consultar("SELECT d.*, p.idProducto, u.ubicacion, concat('Total: $',v.total_final)as comentario FROM detalles_venta d JOIN productos p on  d.codigo=p.idProducto JOIN ubiProds u on u.idUbi=d.id_ubi JOIN venta v on v.id=d.id_venta where d.id_venta=".$id);
    foreach ($res as $key) {
        $prod =$this->Conexion->consultar("SELECT * from ubiProds where idUbi=".$key->id_ubi, true);
        $cant=intval($prod->cantidad) - intval($key->qty);
        $this->Conexion->comando("UPDATE ubiProds SET cantidad ='".$cant."' where idUbi=".$key->id_ubi); 

        $mov = array(
            'idProd'=>$key->idProducto,
            'idus' => $this->session->id,
            'cantidad'=>$key->qty,
            'local'=>$key->ubicacion,
            'tipo'=>'VENTA',
            'comentario'=>$key->comentario,
            'fecha' => date('Y-m-d'),
        );
        //cho 'kakaka';
        $id_inserted = $this->Modelo->registrarMov($mov);       
    }

    $tipo_descuento_final=null;
    $descuento_final=null;
    if ($descuento == "otro") {
        $tipo_descuento_final=$tipo_descuento;
        $descuento_final=$txt_desc;
    }else if ($descuento == "0"){
        $tipo_descuento_final="N/A";
    }
    else {
        $tipo_descuento_final="porcentaje";
        $descuento_final=$descuento;
    }
    $data  = array(
        'tipo_pago' =>$tipo ,
        'tipo_descuento' =>$tipo_descuento_final,
        'descuento' =>$descuento_final,
        'tipo' =>'VENTA' ,
        'total_final'=>$total_final,
        'estatus'=>'CERRADA',

    );
    $res=$this->Conexion->modificar('venta', $data, null, array('id' => $id));
    if ($res) {
        echo $id;
    }

}

function ajax_cobrar_anticipo(){
    $id=$this->input->post('id');
    $tipo=$this->input->post('tipo');
    $monto=$this->input->post('monto');
    $total_anticipo=$this->input->post('total_anticipo');
    $datos  = array(
        'id_venta' => $id, 
        'total' => $total_anticipo, 
        'adelanto' => $monto, 
        'restante' => $total_anticipo-$monto, 
        'us' => $this->session->id, 
    );
    $result = $this->Conexion->insertar("pagos_venta", $datos);
     $data  = array(
        'tipo_pago' =>$tipo ,
        'tipo' =>'ANTICIPO' ,
        'total_final'=>$monto,

    );

    $res=$this->Conexion->modificar('venta', $data, null, array('id' => $id));
    if ($res && $result) {
        echo 1;
    }

}



function ajax_cerrar_venta_servicio(){
    $id=$this->input->post('id');
    $tipo=$this->input->post('tipo');
    $descuento=$this->input->post('descuento');
    $tipo_descuento=$this->input->post('tipo_descuento');
    $txt_desc=$this->input->post('txt_desc');
    $total_final=$this->input->post('total_final');

    $tipo_descuento_final=null;
    $descuento_final=null;
    if ($descuento == "otro") {
        $tipo_descuento_final=$tipo_descuento;
        $descuento_final=$txt_desc;
    }else if ($descuento == "0"){
        $tipo_descuento_final="N/A";
    }
    else {
        $tipo_descuento_final="porcentaje";
        $descuento_final=$descuento;
    }
    $cliente=$this->Conexion->consultar("SELECT wo.*, concat(c.nombre, ' ',c.apellidos) as cliente FROM ordenes_trabajo wo join clientes c on c.id=wo.id_cliente WHERE wo.id = ".$id,true);
    $data  = array(
        'idus' => $this->session->id, 
        'id_cliente'=>$cliente->id_cliente,
        'tipo_pago' =>$tipo ,
        'tipo' =>'SERVICIO' ,
        'tipo_descuento' =>$tipo_descuento_final,
        'descuento' =>$descuento_final,
        'total'=>$total_final,
        'total_final'=>$total_final,
        'estatus'=>'CERRADA',
    );
    $result = $this->Conexion->insertar("venta", $data);




    $res=$this->Conexion->modificar('venta', $data, null, array('id' => $id));
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

    $query="SELECT v.*, c.nombre from venta v LEFT JOIN clientes c on c.id =v.id_cliente WHERE 1=1  ";

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
    $garantia = $this->input->post('garantia');
    $motivo = $this->input->post('motivo');
    $venta = $this->input->post('venta');
    $articulo = $this->input->post('articulo');
    $dinero = $this->input->post('dinero');
    $credito = $this->input->post('credito');
$data  = array(
        'idus' => $this->session->id, 
        'motivo' => $motivo,
        'garantia' => $garantia,
        'accion' => $accion,
        'id_venta' => $venta,
        'estatus' => 'CREADA',
        'articulo' =>$articulo,
        'dinero' =>$dinero,
        'articulo' =>$articulo,

    );
    $result = $this->Conexion->insertar("garantia", $data);
    if($result)
        {
         echo json_encode($result);  
        }
}
function registrarVentaTool(){
        //$datos['idUs'] = $this->session->id;
        /*$datos['idProd']=$this->input->post('producto');
        $datos['cantidad']=$this->input->post('cantidad');*/
        $datos = array(
            'idUs'=>$this->session->id,
            'idProd' =>$this->input->post('producto'),
            'cantidad'=>$this->input->post('cantidad'),

        );
       
        $this->load->model('tool_model');

        $res = $this->tool_model->registrarVentaTemp($datos);
        redirect(base_url('ventas/ver_garantia/'.$this->input->post('id_garantia')));
    
        }
        function cancelarProducto($idp, $id_garantia){
        $this->load->model('tool_model');
        $this->tool_model->cancelarProducto($idp);
        redirect(base_url('ventas/ver_garantia/'.$id_garantia));


    }

      function registrarPedido() {
        $this->load->model('tool_model');
        $this->load->model('privilegios_model');
        $op=$this->input->post('apro');
        $id_garantia=$this->input->post('garantia');
        $apro=$this->input->post('aprobador');
        $fecha=date("Y/m/d");
        //echo $op;die();
           
         if ($this->session->privilegios['autorizarTC']) {
                $data = array(
            'idUs' => $this->session->id,   
            'aprobador' =>$this->session->id, 
            'estatus'=>"APROBADO",
            'fecha' => $fecha,
            'id_garantia' => $id_garantia,


            );

       $id_inserted =  $this->tool_model->registrarDetVenta($data);
            }else{

            $consulta = 'SELECT autorizadorTC from usuarios WHERE id='.$this->session->id.'';
        
            $r = $this->Conexion->consultar($consulta);    
            
            foreach($r as $atc){
//                echo var_dump($atc->autorizadorTC);die();

                $data = array(
            'idUs' => $this->session->id,   
            'aprobador' =>$atc->autorizadorTC,  
            'estatus'=>"PENDIENTE",
            'fecha' => $fecha,
            'id_garantia' => $id_garantia,


            );

       $id_inserted =  $this->tool_model->registrarDetVenta($data);

            }



            }  

           
       //die();
       $consulta = 'SELECT * from VentToolCrib WHERE idToolCrib =(SELECT MAX(idToolCrib) from VentToolCrib WHERE idUs ='.$this->session->id.');';
       // echo var_dump($consulta);die();
        $resV = $this->Conexion->consultar($consulta);
        //echo var_dump($resV->idToolCrib);die();
        foreach($resV as $valV) {
            $idToolCrib=$valV->idToolCrib;

        
        
        }
        //echo var_dump($idToolCrib);die();
        

        $query='SELECT * from VentTCTemp where idUs ='.$this->session->id;
        //var_dump($query);die();
        $res = $this->Conexion->consultar($query);



    foreach($res as $val) {

        //echo var_dump($val->idUs.$val->idProd.$val->cantidad);
        
        $data = array(
            'idVenta' => $idToolCrib,
            'idUs' => $val->idUs,
            'idProd' => $val->idProd,
            'cantidad' => $val->cantidad,
            'estatus' => 'PENDIENTE'
            
        );

        $id_inserted =  $this->tool_model->registrarVentaDet($data);
        $this->tool_model->delVentTemp();
    }

    redirect(base_url('ventas/ver_garantia/'.$id_garantia));
         
         }

function ajax_get_AllVentas()
{
    $estatus = $this->input->post('estatus');
    $texto = $this->input->post('texto');
    $parametro = $this->input->post('parametro');
    $fecha1 = $this->input->post('fecha1');
    $fecha2 = $this->input->post('fecha2');
    $f1=strval($fecha1).' 00:00:00';
    $f2=strval($fecha2).' 23:59:59';

    $query = "SELECT v.*, concat(u.nombre, ' ', u.paterno) as user, concat(c.nombre, ' ', c.apellidos) as cliente from venta v join usuarios u on v.idus=u.id join clientes c on c.id=v.id_cliente WHERE 1=1 ";

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
            if($parametro == "numero_cliente")
            {
                $query .= " and c.telefono = '$texto'";
            }
            if($parametro == "correo_cliente")
            {
                $query .= " and c.correo = '$texto'";
            }


        }
    if (!empty($fecha1) && !empty($fecha2)) {
            $query .=" and v.fecha BETWEEN '".$f1."' AND '".$f2."' ";
        }
    if($estatus != 'TODO')
        {
            $query .= " and v.estatus = '$estatus'";
        }
    
    $result = $this->Conexion->consultar($query);

    if($result)
        {
         echo json_encode($result);  
        }
}

function ajax_get_Allservicios()
{
    $estatus = $this->input->post('estatus');
    $texto = $this->input->post('texto');
    $parametro = $this->input->post('parametro');
    $fecha1 = $this->input->post('fecha1');
    $fecha2 = $this->input->post('fecha2');
    $f1=strval($fecha1).' 00:00:00';
    $f2=strval($fecha2).' 23:59:59';

    $query = "SELECT wo.*, concat(c.nombre, '', c.apellidos) as cliente, concat(u.nombre, '', u.paterno) as user FROM ordenes_trabajo wo JOIN clientes c on c.id=wo.id_cliente JOIN usuarios u on u.id=wo.id_asignado WHERE wo.total IS NOT NULL ";

  /*  if(!empty($texto))
        {
            if($parametro == "id")
            {
                $query .= " and v.id = '$texto'";
            }
            if($parametro == "user")
            {
                $query .= " having user like '%$texto%'";
            }
            if($parametro == "numero_cliente")
            {
                $query .= " and c.telefono = '$texto'";
            }
            if($parametro == "correo_cliente")
            {
                $query .= " and c.correo = '$texto'";
            }


        }
    if (!empty($fecha1) && !empty($fecha2)) {
            $query .=" and v.fecha BETWEEN '".$f1."' AND '".$f2."' ";
        }
    if($estatus != 'TODO')
        {
            $query .= " and v.estatus = '$estatus'";
        }*/
    
    $result = $this->Conexion->consultar($query);

    if($result)
        {
         echo json_encode($result);  
        }
}

function exportar_excel(){
    
    $query="SELECT v.*, concat(u.nombre, ' ', u.paterno) as user FROM venta v join usuarios u on u.id=v.idus WHERE DATE(`fecha`) = CURDATE()";
    $result= $this->Conexion->consultar($query);

        $salida='';

            $salida .= '<table style="border: 1px solid black; border-collapse: collapse;">
                            <thead> 
                                <tr>
                                    <th style="background-color: #F3F1F1; color: black;  border: 1px solid black; border-collapse: collapse"># Venta</th>
                                    <th style="background-color: #F3F1F1; color: black;  border: 1px solid black; border-collapse: collapse">Fecha</th>
                                    <th style="background-color: #F3F1F1; color: black;  border: 1px solid black; border-collapse: collapse">Tipo</th>
                                    <th style="background-color: #F3F1F1; color: black;  border: 1px solid black; border-collapse: collapse">Usuario</th>
                                    <th style="background-color: #F3F1F1; color: black;  border: 1px solid black; border-collapse: collapse">Total</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $d=2;
        foreach($result as $row){
            $salida .='
                        <tr>
                            <td style="color: $444;  border: 1px solid black; border-collapse: collapse">'.$row->id.'</td>
                            <td style="color: $444;  border: 1px solid black; border-collapse: collapse">'.$row->fecha.'</td>
                            <td style="color: $444;  border: 1px solid black; border-collapse: collapse">'.$row->tipo.'</td>
                            <td style="color: $444;  border: 1px solid black; border-collapse: collapse">'.$row->user.'</td>
                            <td style="color: $444;  border: 1px solid black; border-collapse: collapse">'.$row->total_final.'</td>
                        </tr>';
                        $d=$d+1;
             }
                $salida .= '</tbody>
                </table>';

        $timestamp = date('m/d/Y', time());
       
        $filename='Corte_Caja_'.$timestamp.'.xls';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Content-Transfer-Encoding: binary'); 
        echo $salida;
}
function ajax_abrir_caja(){
    $apertura = $this->input->post('apertura');
     $data  = array(
        'idus' => $this->session->id, 
        'total' => $apertura,
        'tipo' => 'APERTURA',
        'caja' => 'APERTURA',
        'tipo_pago' => 'efectivo',
        'total_final' => $apertura,
    );
    $result = $this->Conexion->insertar("venta", $data);
    if($result)
        {
         echo json_encode($result);  
        }

}
function ajax_cerrar_caja(){
    $tipo_corte = $this->input->post('tipo_corte');
    $res=$this->Conexion->consultar("SELECT SUM(total_final) as dia FROM venta WHERE DATE(`fecha`) = CURDATE() and idus=".$this->session->id, true);
    $total_corte=$res->dia;

    $data  = array(
        'idus' => $this->session->id, 
        'total' => $total_corte,
        'tipo' => $tipo_corte,
        'caja' => $tipo_corte,
        'tipo_pago' => $tipo_corte,
        'total_final' => $total_corte,
    );
    $result = $this->Conexion->insertar("venta", $data);
    if($result)
        {
         echo json_encode($result);  
        }

}
function ajax_getAnticipos(){
        $id = $this->input->post('id');
        $query = "SELECT pv.*, concat(u.nombre, ' ', u.paterno) as user from pagos_venta pv JOIN usuarios u on u.id=pv.us WHERE id_venta =".$id;

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else {
            echo "";
        }

    }
    function cerrar_venta($id)
    {
        $this->Conexion->comando("UPDATE venta SET estatus ='CERRADA' where id=".$id); 
        redirect(base_url('ventas/ticket/'.$id));
    }

     function ticket($id){
    $query = "SELECT dv.*, p.producto, p.codigo as cod, u.ubicacion, v.id_cliente, c.nombre as cliente, v.total, v.fecha, concat(s.nombre, '', s.paterno) as seller FROM detalles_venta dv JOIN venta v on v.id=dv.id_venta JOIN productos p on p.idProducto=dv.codigo JOIN ubiProds u on dv.id_ubi=u.idUbi JOIN usuarios s on s.id=v.idus LEFT JOIN clientes c on c.id=v.id_cliente WHERE dv.id_venta = $id";
   // echo $query;die();
    
    $rs = $this->Conexion->consultar($query);
    $data = $this->Conexion->consultar($query, TRUE);

    ini_set('display_errors', 0);

    $this->load->library('pdfview');
    $pdf = new TCPDF('P', 'mm', array(80, 250), true, 'UTF-8', false);

    $pdf->SetCreator('Ticket');
    $pdf->SetAuthor('Sistema');
    $pdf->SetTitle('Ticket-'.$id);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->SetMargins(4, 4, 4, true);
    $pdf->SetAutoPageBreak(true, 2);
    $pdf->SetFont('courier', '', 8);
    $pdf->AddPage();

    // Logo (ajusta la ruta a tu imagen)
    
    $image_file = base_url().'template/images/logo_original.png';
    $pdf->Image($image_file, '', '', 20, '', '', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
    $pdf->Ln(10);

    // Nombre del negocio en negritas
    $pdf->SetFont('courier', 'B', 9);
    $pdf->MultiCell(0, 5, "EL MICROMETRO", 0, 'C', 0, 1);
    $pdf->SetFont('courier', '', 8);
    $pdf->MultiCell(0, 5, "Miguel Ahumada #2675\nJuárez, Chihuahua, CP 32070\nTel: 6563829306 / 6566151628", 0, 'C', 0, 1);
    
    $pdf->Ln(1);
    $pdf->MultiCell(0, 5, "Fecha: {$data->fecha}", 0, 'C', 0, 1);
    $pdf->MultiCell(0, 5, "Folio: $id", 0, 'C', 0, 1);
    $pdf->Ln(2);

    // Encabezado productos
    $pdf->MultiCell(0, 5, "Cant Cod  Producto           Precio", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);

    foreach ($rs as $row) {
        $cant = str_pad($row->cantidad, 4, ' ', STR_PAD_LEFT);
        $cod  = str_pad(substr($row->codigo, 0, 4), 4);
        $prod = str_pad(substr($row->producto, 0, 12), 12);
        $prec = number_format($row->precio, 2);
        $prec = str_pad($prec, 8, ' ', STR_PAD_LEFT);
        $line = "$cant $cod $prod $prec";
        $pdf->MultiCell(0, 5, $line, 0, 'L', 0, 1);
    }

    $pdf->Ln(1);
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);
    $pdf->Ln(1);

    $total = number_format($data->total, 2);
    $pdf->MultiCell(0, 5, "TOTAL:             $total", 0, 'R', 0, 1);
    $pdf->Ln(3);

    $pdf->MultiCell(0, 5, "Cliente: {$data->cliente}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Vendedor: {$data->seller}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Forma de pago: Efectivo", 0, 'L', 0, 1);
    $pdf->Ln(2);

    $pdf->MultiCell(0, 5, "¡Gracias por su compra!", 0, 'C', 0, 1);

    $pdf->Output('Ticket-'.$id.'.pdf', 'I');
}
    function ingresar_garantia()
    {

        $data  = array(
        'titulo' => $this->input->post('titulo'), 
        'descripcion' => $this->input->post('descripcion'), 
        'idus' => $this->session->id,
    );
    $res = $this->Conexion->insertar("catalogo_garantias", $data); 

    if ($res) {
        redirect(base_url('ventas/catalogo_garantias/'));
    }

    }
    function ajax_getCatalogoGarantias()
{
    
    $result = $this->Conexion->consultar("SELECT * from catalogo_garantias where 1=1");
    if($result)
        {
         echo json_encode($result);  
        }
}
 function ajax_getGarantia(){
        $id = $this->input->post('id');

        $query = "SELECT * from catalogo_garantias  where 1 = 1 and id = $id";

        $res = $this->Conexion->consultar($query, TRUE);
        if($res)
        {
            echo json_encode($res);
        }
        else{
            echo "";
        }
    }



}

?>