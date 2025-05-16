<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Toolcrib extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('correos_po');
        $this->load->model('tool_model');
        $this->load->model('Tool_model');

        //$this->load->library('AOS_funciones');
    }
    function tool_crib(){
        $this->load->model('tool_model');
        $this->load->model('privilegios_model');
        $datos['productos']=$this->tool_model->ProdPedidos();
        $datos['usuarios'] = $this->tool_model->listadoUsuarios();
        $datos['usuarios'] = $this->privilegios_model->listadoJefes();
        //$datos['productos'] = $this->tool_model->listadoProductos();
        $datos['venta'] = $this->tool_model->ventatemp();
        //echo var_dump($datos['venta']);die();
        ////$datos['vt']=$this->compras_model->ventatemp();
        $this->load->view('header');
        $this->load->view('toolcrib/toolcrib', $datos);
    }
    function pedidos(){
               $this->load->model('tool_model');

        $datos['pedido'] = $this->tool_model->pedidos();
        //echo var_dump($datos['venta']);die();
        ////$datos['vt']=$this->compras_model->ventatemp();
        $this->load->view('header');
        $this->load->view('toolcrib/pedido', $datos);
    }
    function producto_nuevo(){
        $this->load->model('tool_model');
        $this->load->view('header');
        $this->load->view('toolcrib/productoNuevo');}

     function inventario(){
        $this->load->model('tool_model');
        //$data['productos']=$this->tool_model->productos();

        $this->load->view('header');
        $this->load->view('toolcrib/inventario');
    }
    function movimientos(){
        $this->load->model('tool_model');
        $data['movimientos']=$this->tool_model->movimientos();

        $this->load->view('header');
        $this->load->view('toolcrib/movimientos', $data);
    }


    function verProducto($idp){
        $this->load->model('tool_model');

        $datosProd=$this->tool_model->getProds($idp);
        $data['codigo']=$datosProd->codigo;
        $data['producto']=$datosProd->producto;

        //$data['cantidad']=$datosProd->cantidad;

        $data['productos']=$this->tool_model->getProd($idp);   
        $data['movimientos']=$this->tool_model->movimientosProd($idp);   
        $data['qty'] =$this->tool_model->prodCant($idp);
        $data['ubicacion']=$this->tool_model->ubicaciones($idp);
        $this->load->view('header');
        $this->load->view('toolcrib/ver_Prod', $data);
        //echo var_dump($data);die();
    }
    function cancelarProducto($idp){
        $this->load->model('tool_model');
        $this->tool_model->cancelarProducto($idp);
        redirect(base_url('toolcrib/tool_crib'));
    }

    function modificarProd($idp){
        $this->load->model('tool_model');
      $data['marcas'] = $this->tool_model->listadoMarcas();

        $datosProd=$this->tool_model->getProds($idp);
        $data['codigo']=$datosProd->codigo;
        $data['producto']=$datosProd->producto;

        //$data['cantidad']=$datosProd->cantidad;

        $data['productos']=$this->tool_model->getProd($idp);   
        $data['movimientos']=$this->tool_model->movimientosProdCom($idp);    
        $data['ubicacion']=$this->tool_model->ubicaciones($idp);
        $this->load->view('header');
        $this->load->view('toolcrib/modProd', $data);
        //echo var_dump($data);die();
    }
    function EditarPedido($idp){
        $this->load->model('tool_model');

        $datosProd=$this->tool_model->getDetalleVent($idp);
        //echo var_dump($datosProd);die();
        
        $data['producto']=$datosProd->idProd;
        $data['producto']=$datosProd->cantidad;
        $idProd=$datosProd->idProd;


        //$data['cantidad']=$datosProd->cantidad;

        $data['productos']=$this->tool_model->DetalleVent($idp);       
        $data['ubi']=$this->tool_model->ubicacionAjuste($idProd);
        $this->load->view('header');
        $this->load->view('toolcrib/editarPedido', $data);
        //echo var_dump($data);die();
    }
    function EditarProd($idp){
        $this->load->model('tool_model');

        //$datosProd=$this->tool_model->getProds($idp);
        $datosub=$this->tool_model->ubicacion($idp);
       // $data['codigo']=$datosProd->codigo;
        //$data['producto']=$datosProd->producto;

        //$data['ubicacion']=$datosub->ubicacion;

        //$data['cantidad']=$datosProd->cantidad;

        $data['productos']=$this->tool_model->getProd($idp);       
        $data['ubicaciones']=$this->tool_model->locacion($idp);       
        $this->load->view('header');
        $this->load->view('toolcrib/editar_Prod', $data);
        //echo var_dump($data);die();
    }
    function verPedido($idVenta)
    {
        $this->load->model('tool_model');
        $this->load->model('privilegios_model');
        $data['privilegios'] = $this->privilegios_model->listadoPuestos();
        $venta=$this->tool_model->getventaDet($idVenta);
        $data['idVenta']=$venta->idToolCrib;/*
        $data['idUs']=$venta->idUs;
        $data['idProd']=$venta->idProd;
        $data['cantidad']=$venta->cantidad;
        $data['producto']=$venta->producto;*/
       // 
        $data['pedido']=$this->tool_model->getPedido($idVenta);
        

        $this->load->view('header');
        $this->load->view('toolcrib/verPedido', $data);      
    }
    function aprobarPedido($idVenta)
    {
        $this->load->model('tool_model');
        $venta=$this->tool_model->getventaDet($idVenta);
        $data['idVenta']=$venta->idToolCrib;/*
        $data['idUs']=$venta->idUs;
        $data['idProd']=$venta->idProd;
        $data['cantidad']=$venta->cantidad;
        $data['producto']=$venta->producto;*/
       // 
        $data['pedido']=$this->tool_model->getPedido($idVenta);
        

        $this->load->view('header');
        $this->load->view('toolcrib/aprobar', $data);      
    }
    function reporte(){
        $this->load->model('tool_model');
        $data['pedidos']=$this->tool_model->reporte();
        $this->load->view('header');
        $this->load->view('toolcrib/reporte', $data);
    }
    function registrarVenta(){
        //$datos['idUs'] = $this->session->id;
        /*$datos['idProd']=$this->input->post('producto');
        $datos['cantidad']=$this->input->post('cantidad');*/
        $datos = array(
            'idUs'=>$this->session->id,
            'idProd' =>$this->input->post('producto'),
            'cantidad'=>$this->input->post('cantidad'),

        );
//                echo var_dump($datos);die();

        $this->load->model('tool_model');

        $res = $this->tool_model->registrarVentaTemp($datos);
        redirect(base_url('toolcrib/tool_crib'));
    
        }
   

    function registrarProducto() {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
     $data = array(
            'codigo' => $this->input->post('codigo'),
            'categoria' => $this->input->post('categoria'),
            'producto' => $this->input->post('producto'),
            'descripcion' => $this->input->post('descripcion'),
            'proveedor' => $this->input->post('proveedor'),
            'marca' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'precio' => $this->input->post('precio'),
            'tipo' => $this->input->post('tipo'),
            'um' => $this->input->post('um'),
            'garantia' => $this->input->post('garantia'),
            'cantMax' => $this->input->post('cantMax'),
            'cantMin' => $this->input->post('cantMin'),
            'estatus' => '1',
            'foto' => $foto,
            
                 
        );
       

        $this->load->model('tool_model');       
        $id_inserted =  $this->tool_model->registrarProducto($data);
        redirect(base_url('toolcrib/producto_nuevo'));
    }

    function actualizarProducto() {
        $idp=$this->input->post('idp');
        $check =$this->input->post('estatus');
        if ($check==1) {
            $estatus='1';
        }else{
               $estatus='0';
        }
     $data = array(
            'codigo' => $this->input->post('codigo'),
            'categoria' => $this->input->post('categoria'),
            'producto' => $this->input->post('producto'),
            'descripcion' => $this->input->post('descripcion'),
            'proveedor' => $this->input->post('proveedor'),
            'marca' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'precio' => $this->input->post('precio'),
            'um' => $this->input->post('um'),
            'garantia' => $this->input->post('garantia'),
            'cantMax' => $this->input->post('cantMax'),
            'cantMin' => $this->input->post('cantMin'),
            'estatus' => $estatus,
        );
       

        $this->load->model('tool_model');       
        $id_inserted =  $this->tool_model->updateProd($idp,$data);
        $mov = array(
            'idProd'=>$idp,
            'idus' => $this->session->id,
            'cantidad'=>'0',
            'local'=>'N/A',
            'tipo'=>'MODIFICACION',
            'comentario'=>$this->input->post('comentario'),
            'fecha' => date('Y-m-d'),
        );
        //cho 'kakaka';
        $id_inserted = $this->tool_model->registrarMov($mov);

        redirect(base_url('toolcrib/inventario'));
    }

    function editarProducto() {
        $this->load->model('tool_model');
        $this->load->model('conexion_model', 'Conexion');
        $idp = $this->input->post('idProducto');
        $qty=$this->input->post('cantidad');
        $ubicacion = $this->input->post('ubicacion');
        $stock = $this->input->post('stock');
        $qtyF=$stock+$qty;
        


        $query = "SELECT * from ubiProds where ubicacion ='".$ubicacion."' and idProd='".$idp."'";
        $result=$this->db->query($query)->result_array();
        if ($result) {
            echo '<script type="text/javascript">'; 
            echo 'alert("Ubicacion ya ha sido registraad");'; 
            echo 'window.location = "verProducto/'.$idp.'"';
            echo '</script>';
        

            
        }else{
              $data = array(
            'idProd' => $this->input->post('idProducto'),
            'ubicacion' => $this->input->post('ubicacion'),
            'cantidad' => $this->input->post('cantidad'),
            
        );
       
          $this->tool_model->registrarubicacion($data);

        $mov = array(
            'idProd'=>$idp,
            'idUs' => $this->session->id,
            'cantidad'=>$qty,
            'local'=>$ubicacion,
            'tipo'=>'ENTRADA',
            'comentario'=>$this->input->post('comentario'),
            'fecha' => date('Y-m-d'),
        );
        $this->tool_model->registrarMov($mov);

        

        redirect(base_url('toolcrib/verProducto/'.$idp));


        }    

    }


    function updateProducto() {
        $this->load->model('tool_model');
        $idp = $this->input->post('idProducto');
        $stock = $this->input->post('stock');
        $qty=$this->input->post('cantidad');
        $qtyF=$stock+$qty;
        //echo var_dump($qtyF); die();
        $ubi = $this->input->post('ubicacion');
        


        $data = array(
            'cantidad' => $qtyF,
            
        );
       
         $id_inserted =  $this->tool_model->updateProducto($idp,$ubi,$data);

         $mov = array(
            'idProd'=>$idp,
            'idUs' => $this->session->id,
            'cantidad'=>$qty,
            'local'=>$ubi,
            'tipo'=>'ENTRADA',
            'comentario'=>$this->input->post('comentario'),
            'fecha' => date('Y-m-d'),
        );
         $this->tool_model->registrarMov($mov);

        

         


         redirect(base_url('toolcrib/verProducto/'.$idp));

    }
    function eliminarProducto() {
        $idp=trim($this->input->post('idProducto'));
        $datosP=$this->tool_model->getProds($idp);
    
        $qty=$data['cantidad']=$datosP->cantidad;
        if($qty==0){
                  $data = array(
            'idProducto' => $idp,
        );

        $res = $this->tool_model->deleteProducto($data);
        if ($res) 
        {
            echo "1";
        } else {
            echo "";
        }
    }}
     function registrarPedido() {
        $this->load->model('tool_model');
        $this->load->model('privilegios_model');
        $op=$this->input->post('apro');
        $apro=$this->input->post('aprobador');
        $fecha=date("Y/m/d");
        //echo $op;die();
           
         if ($this->session->privilegios['autorizarTC']) {
                $data = array(
            'idUs' => $this->session->id,   
            'aprobador' =>$this->session->id, 
            'estatus'=>"APROBADO",
            'fecha' => $fecha,


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
        

        $query='SELECT vt.*, p.precio from VentTCTemp vt join productos p on p.idProducto=vt.idProd where idUs ='.$this->session->id;
        //var_dump($query);die();
        $res = $this->Conexion->consultar($query);



    foreach($res as $val) {

        //echo var_dump($val->idUs.$val->idProd.$val->cantidad);
        
        $data = array(
            'idVenta' => $idToolCrib,
            'idUs' => $val->idUs,
            'idProd' => $val->idProd,
            'cantidad' => $val->cantidad,
            'total' => $val->cantidad * intval($val->precio),
             'estatus' => 'PENDIENTE'
            
        );

        $this->tool_model->registrarVentaDet($data);
        $this->tool_model->delVentTemp();
        $total = $this->Conexion->consultar('SELECT SUM(total) as total from detalleVentTC WHERE idVenta = '.$id_inserted, TRUE);
        $res= $this->Conexion->comando("UPDATE VentToolCrib set total = ".$total->total." where  idToolCrib = ".$id_inserted);        
    }
           redirect(base_url('toolcrib/tool_crib'));





         
         }

         function entregarPedido() {
            $this->load->library('correos');
            $this->load->model('tool_model');
        $idVenta = $this->input->post('idVenta');
        $prod= $this->input->post('prod');
        $cant= $this->input->post('cant');
        $idVD = $this->input->post('idVenta');
        $idP = $this->input->post('idProd');

       
         $venta=$this->tool_model->getventaDet($idVenta);
         
        $p=$data['idVenta']=$venta->idToolCrib;
        $idUs=$data['idVenta']=$venta->idUs;
        $correo=$this->tool_model->correoJefe($idUs,$p);
        $correoJefe=$data['correo']=$correo->correo;
        
        $pedido=$this->tool_model->getPedido($idVenta);
        
    /* echo"<table>
                                    <thead>
                                        <tr>
                                           <th class='column-title text-center'>Codigo</th>
                                            <th class='column-title text-center'>Descripción</th>
                                            
                                            <th class='column-title text-center'>Cantidad</th>
                                            <th class='column-title text-center'>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                                    $suma=null;
                                     foreach ($pedido->result() as $elem) { 

                                            echo "<tr><td class='text-center'>".$elem->codigo."</td>";
                                            echo "<td class='text-center'>".$elem->descripcion."</td>";
                                             
                                              echo "<td class='text-center'>".$elem->cantidad."</td>";
                                               echo "<td class='text-center'>".$elem->total."</td></tr>";
                                               $suma +=$elem->total;
                                          
                                           }
                                                echo "</tbody></table><p>TOTAL: $".$suma."</p>";
                                               // echo var_dump("algo ".$suma);
       
        


        echo var_dump($total);
        die();*/
        
         
        $mail['pedido']=$p;
        $mail['pedidos']=$this->tool_model->getPedido($idVenta);
        $mail['correo']=$correoJefe;
        //echo var_dump($correoJefe);die();




        $this->correos->entregarPedido($mail);
         

        $data = array(
            'estatus' => 'ENTREGADO',  
        );

        $res = $this->tool_model->updateVenta($idVenta,$data);
      

        if ($res) 
        {
            echo json_encode($data);

        } else {
            echo "";
        }
        redirect(base_url('toolcrib/pedidos'));
       
    }



    function excel()
    {
        $txt = $this->input->post('txtBuscar');
        $opc = $this->input->post('rbBusqueda');

        $query = 'SELECT p.idProducto as CODIGO, p.producto as PODUCTO, p.descripcion AS DESCRIPCION, p.proveedor as PROVEEDOR, p.marca AS MARCA, p.modelo AS MODELO, p.precio AS PRECIO, p.um AS UNIDAD_DE_MEDIDA,u.ubicacion as LOCAL, u.cantidad AS STOCK FROM productos p JOIN ubiProds u on p.idProducto=u.idProd';

         if(!empty($txt))
        {
            if($opc == "prod")
            {
                $query .= " where producto like '$txt'";
            }
            else if($opc == "marca")
            {
                $query .= " where marca like '$txt'";
            }
            else if($opc == "prov")
            {
                $query .= " where proveedor like '$txt'";
            }
        }
        $result=$this->db->query($query)->result_array();

        $timestamp = date('m/d/Y', time());
       
        $filename='inventario_'.$timestamp.'.xls';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $isPrintHeader=false;

        foreach($result as $row){

            if (!$isPrintHeader) {
                echo implode("\t", array_keys($row)). "\n";
                $isPrintHeader=true;
                
            }
            echo implode("\t", array_values($row)). "\n";

        }

        exit;
        }   
        function getProds() {
    $texto = trim($this->input->post('texto'));
    $parametro = $this->input->post('parametro');

    $query = "SELECT idProducto, codigo, categoria, producto, descripcion, proveedor, marca, modelo, precio, tipo, um, garantia, cantMax, cantMin, estatus, defecto 
              FROM productos";
    
    $where = [];

    if (!empty($texto)) {
        // Búsqueda general (LIKE en varios campos)
        $likeTexto = $this->db->escape_like_str($texto); // Escapa el texto para LIKE
        if ($parametro == "prod") {
            $where[] = "codigo LIKE '%$likeTexto%'";
        } else if ($parametro == "marca") {
            $where[] = "marca LIKE '%$likeTexto%'";
        } else if ($parametro == "prov") {
            $where[] = "proveedor LIKE '%$likeTexto%'";
        } else if ($parametro == "modelo") {
            $where[] = "modelo LIKE '%$likeTexto%'";
        } else {
            // Búsqueda libre en varios campos
            $where[] = "(descripcion LIKE '%$likeTexto%' OR producto LIKE '%$likeTexto%' OR codigo LIKE '%$likeTexto%' OR modelo LIKE '%$likeTexto%' OR marca LIKE '%$likeTexto%' OR proveedor LIKE '%$likeTexto%')";
        }
    }

    if (count($where) > 0) {
        $query .= " WHERE " . implode(" AND ", $where);
    }

    $query .= " LIMIT 100";

    $res = $this->Conexion->consultar($query);
    echo $res ? json_encode($res) : "";
}
 

   /*     function getProds() {


        $texto = $this->input->post('texto');
        $texto = trim($texto);
        $parametro = $this->input->post('parametro');

        
                $query = "SELECT idProducto, codigo, categoria, producto, descripcion, proveedor, marca, modelo, precio, tipo, um, garantia, cantMax, cantMin, estatus, defecto from productos";

         if(!empty($texto))
        {
$query .=" where descripcion like '%$texto%'";

        }

            //$query = "SELECT * from productos";
            if($parametro == "prod")
            {
               // $query .= " where producto like '$texto'";
		$query .=" where codigo like '$texto'";
            }
            else if($parametro == "marca")
            {
                $query .= " where marca like '$texto'";
            }
            else if($parametro == "prov")
            {
                $query .= " where proveedor like '$texto'";
            }
            else if($parametro == "modelo")
            {
                $query .= " where modelo like '$texto'";
            }
        
        $query .= " limit 100";
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
            //echo $query;
        }
        else{
            echo "";
        }
    }  */

    function productos() {


        $texto = $this->input->post('texto');
        $texto = trim($texto);
        $parametro = $this->input->post('parametro');

        $query = "SELECT p.idProducto, p.codigo, p.categoria, p.producto, p.descripcion, p.proveedor,p.marca, p.modelo, p.precio, p.tipo, p.um, p.garantia, p.cantMax, p.cantMin, p.estatus, p.defecto, SUM(u.cantidad) as cantidad FROM productos p left JOIN ubiProds u ON p.idProducto=u.idProd ";
    
         if(!empty($texto))
        {
            if($parametro == "prod")
            {
                $query .= " where producto like '$texto' ";
            }
            else if($parametro == "codigo")
            {
                $query .= " where codigo like '$texto' ";
            }
            
        }
        $query .=" GROUP BY p.idProducto";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
            //echo $query;
        }
        else{
            echo "";
        }
    } 

    function getRep()
    {
        $texto = $this->input->post('texto');
        $texto = trim($texto);
        $parametro = $this->input->post('parametro');
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');


        $query = "SELECT dv.*, v.fecha, p.marca, p.proveedor, p.producto, p.precio, concat(u.nombre, ' ', u.paterno) as nombre, u.no_empleado FROM detalleVentTC dv JOIN usuarios u ON dv.idUs=u.id JOIN VentToolCrib v ON dv.idVenta=v.idToolCrib JOIN productos p ON dv.idProd=p.idProducto ";
    
        if($parametro == "date")
        {
                $query .= " where v.fecha BETWEEN '".$fecha1."' and '".$fecha2."'";
            }
            if(!empty($texto))
            {
                if($parametro == "prod")
                {
                 $query .= " where p.producto like '$texto'";
                }
                else if($parametro == "marca")
                {
                    $query .= " where p.marca like '$texto'";
                }
                else if($parametro == "prov")
                {
                 $query .= " where p.proveedor like '$texto'";
                }
                 else if($parametro == "user")
                {
                    $query .= " where u.nombre like '$texto'";
                }
             
            }

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
            //echo $query;
        }
        else{
            echo "";
        }
    }
    function mov()
    {
       /* $texto = $this->input->post('texto');
        $texto = trim($texto);
        $parametro = $this->input->post('parametro');*/
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $f1=strval($fecha1);
        $f2=strval($fecha2);


        $query = "SELECT m.*, concat(u.nombre, ' ', u.paterno) as nombre, p.producto FROM movimientosTool m JOIN usuarios u ON u.id=m.idus JOIN productos p ON p.idProducto=m.idProd ";
        if (!empty($fecha1) && !empty($fecha2)) {
            $query .="where m.fecha BETWEEN '".$f1."' AND '".$f2."' ";
        }
        $query .=" ORDER BY m.fecha DESC";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
            //echo $query;
        }
        else{
            echo "";
        }
    }
    function excelRep()
    {
        $texto = $this->input->post('txtBuscar');
        $parametro = $this->input->post('rbBusqueda');
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $f1=strval($fecha1);
        $f2=strval($fecha2);

        

        //$query = 'SELECT idProducto as CODIGO, producto as PODUCTO, descripcion AS DESCRIPCIO, proveedor as PROVEEDOR, marca AS MARCA, modelo AS MODELO, localizacion AS LOCAL, precio AS PRECIO, um AS UNIDAD_DE_MEDIDA, cantidad AS CANTIDAD FROM productos';

         $query = "SELECT dv.*, v.fecha, p.marca, p.proveedor, p.producto, p.precio, concat(u.nombre, ' ', u.paterno) as nombre, u.no_empleado FROM detalleVentTC dv JOIN usuarios u ON dv.idUs=u.id JOIN VentToolCrib v ON dv.idVenta=v.idToolCrib JOIN productos p ON dv.idProd=p.idProducto ";
    
         if(!empty($texto))
        {
            if($parametro == "prod")
            {
                $query .= " where p.producto like '$texto'";
            }
            else if($parametro == "marca")
            {
                $query .= " where p.marca like '$texto'";
            }
            else if($parametro == "prov")
            {
                $query .= " where p.proveedor like '$texto'";
            }
             else if($parametro == "user")
            {
                $query .= " where u.nombre like '$texto'";
            }
           
        }
          else if($parametro = "date")
            {
                $query .= " where v.fecha BETWEEN '$f1' and '$f2'";
            }

        $result=$this->db->query($query)->result_array();

        $timestamp = date('m/d/Y', time());
       
        $filename='Reporte_'.$timestamp.'.xls';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $isPrintHeader=false;

        foreach($result as $row){

            if (!$isPrintHeader) {
                echo implode("\t", array_keys($row)). "\n";
                $isPrintHeader=true;
                
            }
            echo implode("\t", array_values($row)). "\n";

        }

        exit;
        
    }  

    function ajuesteInventario(){
        $this->load->model('tool_model');
        $idV=$this->input->post('idV');
        $idDV=$this->input->post('idDV');
        //echo var_dump($idDV);die();
        $idProd = $this->input->post('idProd');
        $producto = $this->input->post('producto');
        $ubi= $this->input->post('ubicacion');
        $qty= $this->input->post('cantidad');
        $datos = $this->tool_model->getUbi($idProd,$ubi);
        $cant = $datos->cantidad;
        $qtyF=$cant-$qty;

        if ($qty > $cant) {
  //echo "</tbody></table><p>TOTAL: $".$suma."</p>";
            echo '<script type="text/javascript">'; 
            echo 'alert("No hay suficientes productos en la local, elija otra local o modifique la cantidad a entregar");'; 
            echo 'window.history.back();';
            echo '</script>';

        }
        else{
        


        //$f = date('Y-m-d');
        //echo var_dump($idProd); die();
        

        $data = array(
            'cantidad' => $qty,
            'estatus' => 'ENTREGADO'  
        );
        $this->tool_model->ajusteDetalle($idDV, $data);
        //die();


        $data = array(
            'cantidad' => $qtyF,  
        );
        $this->tool_model->ajuste($idProd,$ubi, $data);

        $mov = array(
            'idProd'=>$idProd,
            'idUs' => $this->session->id,
            'cantidad'=>$qty,
            'local'=>$ubi,
            'tipo'=>'SALIDA',
            'comentario'=>$this->input->post('comentario'),
            'fecha' => date('Y-m-d'),
        );
        $this->tool_model->registrarMov($mov);
        


       
        redirect(base_url('toolcrib/verPedido/'.$idV));
        }die();

    }

    function aprobPedido() {
        $this->load->model('tool_model');
        $idVenta = $this->input->post('idVenta');
        $prod= $this->input->post('prod');
        $cant= $this->input->post('cant');
        $idVD = $this->input->post('idVenta');
        $idP = $this->input->post('idProd');

        //print_r( $idVD);die();
        $data = array(
            'estatus' => 'APROBADO'
            
            
        );
        //echo var_dump($data);die();
         $res = $this->tool_model->aprobar($idVenta,$data);

        if ($res) 
        {
            echo json_encode($data);

        } else {
            echo "";
        }
        redirect(base_url('inicio'));
       
    }
    function excelMov()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $f1=strval($fecha1);
        $f2=strval($fecha2);

        

        //$query = 'SELECT idProducto as CODIGO, producto as PODUCTO, descripcion AS DESCRIPCIO, proveedor as PROVEEDOR, marca AS MARCA, modelo AS MODELO, localizacion AS LOCAL, precio AS PRECIO, um AS UNIDAD_DE_MEDIDA, cantidad AS CANTIDAD FROM productos';

         $query = "SELECT m.tipo, concat(u.nombre, ' ', u.paterno) as nombre, p.producto, m.local, m.cantidad, m.fecha,m.comentario FROM movimientosTool m JOIN usuarios u ON u.id=m.idus JOIN productos p ON p.idProducto=m.idProd  ";
    
         if(!empty($fecha1) && !empty($fecha2))
        {
            $query .= " where m.fecha BETWEEN '$f1' and '$f2'";

                
        }
        

        $result=$this->db->query($query)->result_array();
//        echo var_dump($result); die();

        $timestamp = date('m/d/Y', time());
       
        $filename='movimientos_'.$timestamp.'.xls';
        header("Content-type: application/vnd-ms-xls; name='excel'");
        header('Content-Disposition: attachment; filename='.$filename);
      

  
        
        $isPrintHeader=false;

        foreach($result as $row){

            if (!$isPrintHeader) {
                echo implode("\t", array_keys($row)). "\r";
                $isPrintHeader=true;
                
            }
            echo implode("\t", array_values($row)). "\r";

        }

        exit;
    }  

    function autorizadores(){
        $this->load->model('conexion_model', 'Conexion');
        $query = "SELECT U.id, concat(U.nombre,' ',U.paterno,' ',U.materno) as Name from usuarios U inner join privilegios P on P.usuario = U.id where U.activo = 1 and P.autorizarTC = 1";
        
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }

    }
    function updateFoto() {
      $id=$this->input->post('id');
      //$datos['id'] = $id;
      $datos['foto'] = file_get_contents($_FILES['file']['tmp_name']);
        //$datos['nombre_archivoEjemplo'] = $_FILES['file']['name'];
      //echo var_dump($datos);die();
        ///echo var_dump($datos);die();
      $this->Tool_model->updateFoto($id,$datos);   
    }

    

function modelos() {
            $this->load->model('tool_model');

        $marca = $this->input->post('marca');
        //echo $marca;die();
        if($marca){
            //$this->load->Modelo;
            //$mod = $this->tool_model->getModelos($marca);
            $query = 'SELECT * from modelos where id_marca = "'.$marca.'" group by Nombre';
$res = $this->Conexion->consultar($query);

            //echo '<option value="0">Estados</option>';
            foreach($res as $fila){

                echo '<option value="'. $fila->Nombre .'">'. $fila->Nombre .'</option>';

            }
        }  else {
            echo '<option value="0">Modelos</option>';
        }
    }
    function year() {
            $this->load->model('tool_model');

        $modelo = $this->input->post('modelo');
        //echo $modelo;die();
        if($modelo){
            //$this->load->Modelo;
            //$mod = $this->tool_model->getYear($modelo);
            $query = 'SELECT * from modelos where Nombre = "'.$modelo.'" group by ano';
$res = $this->Conexion->consultar($query);

            //echo '<option value="0">Estados</option>';
            foreach($res as $fila){
                 


                echo '<option value="'. $fila->ano .'">'. $fila->ano .'</option>';

            }
        }  else {
            echo '<option value="0">Año</option>';
        }
    }
     function motor() {
            $this->load->model('tool_model');

        $year = $this->input->post('year');
        //echo $modelo;die();
        if($year){
            //$this->load->Modelo;
            //$mod = $this->tool_model->getYear($modelo);
            $query = 'SELECT * from modelos where ano = "'.$year.'" group by motor';
$res = $this->Conexion->consultar($query);

            //echo '<option value="0">Estados</option>';
            foreach($res as $fila){
                 


                echo '<option value="'. $fila->motor .'">'. $fila->motor .'</option>';

            }
        }  else {
            echo '<option value="0">Año</option>';
        }
    }
    
function ajax_guardarDatos()
{
    $data = array(
            'ano' => $this->input->post('year'),
            'id_producto' => $this->input->post('idp'),
            'id_marca' => $this->input->post('slug'),
            'id_modelo' => $this->input->post('modAuto'),
            'motor' => $this->input->post('motor'),
        );
    //echo var_dump($data);die();
    $res = $this->tool_model->guardarDatos($data);
    if ($res) {
        echo 1;
    }
    
}
function cargar_datos()
{
    $id=$this->input->post('id');
    $res = $this->Conexion->consultar('SELECT c.*, s.Nombre as marca, m.Nombre as modelo, p.codigo, p.producto FROM compatibles c JOIN marcas s on s.id=c.id_marca JOIN modelos m on m.Nombre=c.id_modelo JOIN productos p on p.idProducto=c.id_producto WHERE c.id_producto = '.$id.' GROUP by c.id_modelo, c.motor');

    if($res)
        {
            echo json_encode($res);
        }

}
function ubicacion_defecto($id)
{
    $res = $this->Conexion->consultar('SELECT * from ubiProds where idUbi ='.$id, true);

    $this->Conexion->comando("UPDATE ubiProds set defecto =NULL where idProd =$res->idProd");

    $data = array('defecto' => '1', 
        );
    $where['idUbi'] = $id;


    $this->Conexion->modificar('ubiProds', $data, null, $where); 
    $datos = array('defecto' => $id, 
        );
    $where2['idProducto'] = $res->idProd;


    $this->Conexion->modificar('productos', $datos, null, $where2); 

    redirect(base_url('toolcrib/verProducto/'.$res->idProd));

    
}


    
}
