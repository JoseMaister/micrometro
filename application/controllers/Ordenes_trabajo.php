<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class ordenes_trabajo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('correos_facturacion');
        $this->load->model('MLConexion_model', 'MLConexion');
        $this->load->model('Conexion_model', 'Conexion');
        $this->load->model('Ordenes_model', 'Modelo');
        $this->load->model('usuarios_model');
        $this->load->library('correos');
        $this->load->library('AOS_funciones');
        $this->load->helper('download');
    }

    function index(){
        $data['wos']=$this->Modelo->get_wos(); 

        $this->load->view('header');
        $this->load->view('ordenes_trabajo/catalogo', $data);
    }
    function catalogo_wo(){
        $data['tecnicos']= $this->MLConexion->consultar("SELECT * from catalogo_tecnicos where activo = '-1'");
        $this->load->view('header');
        $this->load->view('ordenes_trabajo/catalogo_wo', $data);
    }

   
    function crear_orden(){
        

        $this->load->view('header');
        $this->load->view('ordenes_trabajo/work_orders');
    }

    function editar_solicitud(){
        if(isset($_POST["id"]))
        {
            $id = $this->input->post('id');
        }
        else if ($id == 0){
            redirect(base_url('inicio'));
        }

        $data["id"] = $id;
        $data["editar"] = true;

        $this->load->view('header');
        $this->load->view('facturas/solicitud_facturas', $data);
    }

    function ver_wo($id){
        $data['wo']=$this->Modelo->get_wo($id); 
        $data['ticktes']=$this->Modelo->get_ticktets($id); 
        $data['usuarios']=$this->usuarios_model->getUsuarios();
        $data['archivos'] = $this->Modelo->verArchivos($id);
        $data['comentarios'] = $this->Modelo->comentarios_wo($id);
        $this->load->view('header');
        $this->load->view('ordenes_trabajo/ver_wo', $data);
    }



    /////////////////////////////

    function ajax_setWO(){

        $data =  array(
            'idus' => $this->session->id,
            'id_cliente' => $this->input->post('cliente'),
            'id_asignado' => $this->input->post('usuario'),
            'estatus' => 'PROGRAMADA',
            'fecha_programada' => $this->input->post('fecha'),
            'piezas' => $this->input->post('piezas'),
            'vehiculo' => $this->input->post('vehiculo'),
            'motor' => $this->input->post('motor'),
            'descripcion' => $this->input->post('descripcion'),
             );
      //  echo var_dump($data);die();
       
$res=$this->Modelo->registrar_orden($data);
 $temp = $this->Conexion->consultar("SELECT st.*, s.clave_precio from servicios_wo_temp st join servicios s on s.id=st.id_servicio WHERE idus=".$this->session->id);

    foreach ($temp as $key) {
        $data = array(
            'id_wo' =>$res,
            'id_servicio' =>$key->id_servicio,
            'total' =>$key->precio,
              );
         $this->Conexion->insertar("servicios_wo", $data);
            
        
    }
              $this->Conexion->comando("DELETE FROM servicios_wo_temp WHERE idus =".$this->session->id);

$temp = $this->Conexion->consultar("SELECT * from piezas_temp WHERE idus=".$this->session->id);

    foreach ($temp as $key) {
        $data = array(
            'id_wo' =>$res,
            'id_pieza' =>$key->idpieza,
            'size' =>$key->size,
            'total' =>$key->precio,
              );
         $this->Conexion->insertar("piezas_ser_motor", $data);
            
        
    }
              $this->Conexion->comando("DELETE FROM piezas_temp WHERE idus =".$this->session->id);

if($res)
        {
            echo $res;
        }
    }

    function ajax_getSolicitudes(){
        $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');
        $cliente = $this->input->post('cliente');
        $estatus = $this->input->post('estatus');
        $tipo = $this->input->post('tipo');
        $cerradas = $this->input->post('cerradas');
    $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $f1=strval($fecha1).' 00:00:00';
        $f2=strval($fecha2).' 23:59:59';

          $query = "select wo.WorkOrder_ID, wo.rs, wo.correo_us, wo.FCreacion, wo.FProgramado, wo.FRetroalimentacion, wo.WorkOrder_Status, rs.`Nombre Corto` as Empresa, C.Cust_ID as empresa, e.Status_Descripcion from WO_Master wo join tblStatusWO e on e.Status_ID=wo.WorkOrder_Status JOIN rsheaders rs on rs.folio_id =wo.rs join catalogo_clientes C on rs.Cust_ID = C.Cust_ID where correo_us ='".$this->session->correo."'";

          if($cerradas == "0")
                {
                    $query .= " and (wo.WorkOrder_Status != '4')";
                }else{
                    $query .= " and (wo.WorkOrder_Status = '4')";
                }
          if(!empty($texto))
            {
                $query.=" and rs.folio_id = ".$texto;


            }
            if(!empty($cliente) && $cliente != 0)
            {
                $query .= " and C.Cust_ID  = '$cliente'";
            }
            if(!empty($estatus) && $estatus != 'TODO')
            {
                $query .= " and wo.WorkOrder_Status = '$estatus'";
            }
            if (!empty($fecha1) && !empty($fecha2)) {
            $query .=" and wo.FProgramado BETWEEN '".$f1."' AND '".$f2."' ";
        }
        
        $query .= " order by FProgramado desc";
//echo $query;die();
        $res = $this->MLConexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
    }
    function ajax_getWo(){
    $texto = $this->input->post('texto');
        $parametro = $this->input->post('parametro');
        $cliente = $this->input->post('cliente');
        $estatus = $this->input->post('estatus');
        $tecnico = $this->input->post('tecnico');
        $tipo = $this->input->post('tipo');
        $cerradas = $this->input->post('cerradas');
    $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $f1=strval($fecha1).' 00:00:00';
        $f2=strval($fecha2).' 23:59:59';
        

        $query = "select wo.WorkOrder_ID, wo.rs, wo.correo_us, wo.FCreacion, wo.FProgramado, wo.FRetroalimentacion, wo.WorkOrder_Status, rs.`Nombre Corto` as Empresa, e.Status_Descripcion, C.Cust_ID as empresa, ct.Nombre from WO_Master wo join tblStatusWO e on e.Status_ID=wo.WorkOrder_Status JOIN rsheaders rs on rs.folio_id =wo.rs join catalogo_tecnicos ct on ct.email_tecnico=wo.correo_us join catalogo_clientes C on rs.Cust_ID = C.Cust_ID where 1=1 ";
        if($cerradas == "0")
                {
                    $query .= " and (wo.WorkOrder_Status != '4')";
                }
                else{
                    $query .= " and (wo.WorkOrder_Status = '4')";
                }
          if(!empty($texto))
            {
                $query.=" and rs.folio_id = ".$texto;


            }
            if(!empty($cliente) && $cliente != 0)
            {
                $query .= " and C.Cust_ID  = '$cliente'";
            }
            if(!empty($estatus) && $estatus != 'TODO')
            {
                $query .= " and wo.WorkOrder_Status = '$estatus'";
            }
            if(!empty($tecnico) && $tecnico != 'TODO')
            {
                $query .= " and wo.correo_us = '$tecnico'";
            }
            if (!empty($fecha1) && !empty($fecha2)) {
            $query .=" and wo.FProgramado BETWEEN '".$f1."' AND '".$f2."' ";
        }

        $query .= " order by FProgramado desc";

        $res = $this->MLConexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
    }
    function realizado(){
        $id=$this->input->post('itemOk');
        $tipo_cal=$this->input->post('tipo_cal');
        $txtrealizado=$this->input->post('txtrealizado');

        $this->MLConexion->comando("UPDATE WO_Detail set Item_Status = 5, tipo_cal = '".$tipo_cal."', calibrado = 'SI' where id = ".$id);
        $wo=$this->MLConexion->consultar("SELECT * from WO_Detail where id=".$id, true);

         $res=$this->MLConexion->consultar("SELECT * from WO_Detail where id=".$id, true);
        $datos['id_wo']=$res->WorkOrder_ID;
        $datos['comentario']="Item Realizado #".$res->Item_Id." = ".$txtrealizado;
        $datos['mail_us']=$this->session->correo;

        $this->MLConexion->insertar('comentarios_wo', $datos);
         redirect(base_url('ordenes_trabajo/ver_wo/'.$wo->WorkOrder_ID));
    }
    function rechazar_item()
    {
        $id=$this->input->post('item');
        $txtrechazar=$this->input->post('txtrechazar');
        $motivo=$this->input->post('motivo');
        $this->MLConexion->comando("UPDATE WO_Detail set Item_Status = 6, motivo = '".$motivo."', calibrado = 'NO', vencimiento = null, tipo_cal=null where id = ".$id);
        $res=$this->MLConexion->consultar("SELECT * from WO_Detail where id=".$id, true);
        $datos['id_wo']=$res->WorkOrder_ID;
        $datos['comentario']="Item No Realizado #".$res->Item_Id." = ".$txtrechazar;
        $datos['mail_us']=$this->session->correo;

        $this->MLConexion->insertar('comentarios_wo', $datos);
        $this->MLConexion->comando("UPDATE rsitems set FechaInWO = null, WOrder_ID = null where item_id = ".$res->Item_Id);


        redirect(base_url('ordenes_trabajo/ver_wo/'.$res->WorkOrder_ID));
    }
    function fecha_vencimiento(){
        $id=$this->input->post('itemFecha');
        $vencimiento=$this->input->post('fecha');
        $this->MLConexion->comando("UPDATE WO_Detail set vencimiento ='".$vencimiento."' where id = ".$id);
        $wo=$this->MLConexion->consultar("SELECT * from WO_Detail where id=".$id, true);
         redirect(base_url('ordenes_trabajo/ver_wo/'.$wo->WorkOrder_ID));

    }
    function reprogramar()
    {
        $id=$this->input->post('itemR');
        $txtreprogramar="REPROGRAMAR WO: ".$this->input->post('txtreprogramar');
        $fecha=$this->input->post('txtFechaAccion');
        $this->MLConexion->comando("UPDATE WO_Master set FProgramado = '".$fecha."', WorkOrder_Status = 2 where WorkOrder_ID = ".$id);
        $datos['id_wo']=$id;
        $datos['comentario']=$txtreprogramar;
        $datos['mail_us']=$this->session->correo;

        $this->MLConexion->insertar('comentarios_wo', $datos);
                redirect(base_url('ordenes_trabajo/ver_wo/'.$id));

    }
    function concluir_wo($id)
    {
        $total_ser = 0;
        $total_tool = 0;
        $total=0;
        $ser=$this->Conexion->consultar("SELECT total from servicios_wo where id_wo=".$id);

        foreach ($ser as $key) {
            $total_ser=$total_ser+$key->total;
        }
        $tool=$this->Conexion->consultar("SELECT total from VentToolCrib where id_servicio=".$id);

        foreach ($tool as $key) {
            $total_tool=$total_tool+$key->total;
        }

$total=$total_ser+$total_tool;
        $this->Conexion->comando("UPDATE ordenes_trabajo set estatus = 'CONCLUIDA', total = ".$total." where ID = ".$id);        
        redirect(base_url('ordenes_trabajo/ver_wo/'.$id));

    }
    function cancelar_wo()
    {
        $id=$this->input->post('id');
        $res = $this->Conexion->comando("UPDATE ordenes_trabajo set estatus = 'CANCELADA'where ID = ".$id);        

        if ($res) {
            echo 1;
        }
        
    }
    function cerrar_wo($id)
    {
       $this->Conexion->comando("UPDATE ordenes_trabajo set estatus = 'CERRADA'where ID = ".$id);        
        redirect(base_url('ordenes_trabajo/ver_wo/'.$id));
    }
    function entregar_wo($id)
    {
       $this->Conexion->comando("UPDATE ordenes_trabajo set estatus = 'ENTREGADA' where ID = ".$id);        
        redirect(base_url('ordenes_trabajo/ver_wo/'.$id));
    }

    function ajax_editSolicitud(){

        $solicitud = json_decode($this->input->post('solicitud'));
        $other = json_decode($this->input->post('other'));
        //echo var_dump($solicitud);die();
        if(isset($_FILES['f_A']))
        {
            $solicitud->f_acuse = file_get_contents($_FILES['f_A']['tmp_name']);
        
        }
        if(isset($_FILES['f_F']))
        {
            $solicitud->f_factura = file_get_contents($_FILES['f_F']['tmp_name']);
            $solicitud->name_factura = $this->input->post('f_F_name');
            

        }
        if(isset($_FILES['f_X']))
        {
            $solicitud->f_xml = file_get_contents($_FILES['f_X']['tmp_name']);
            $solicitud->name_xml = $this->input->post('f_X_name');
            

        }

        $comentario = $this->input->post('comentario');

        $res = $this->Conexion->modificar('solicitudes_facturas', $solicitud, null, array('id' => $solicitud->id));
        if($solicitud->estatus_factura == "ACEPTADO")
        {
            
            $this->load->model('MLConexion_model', 'MLConexion');
            $this->MLConexion->comando("UPDATE rsitems set Factura = ifnull(Factura, $solicitud->folio) where Solicitud_ID = $solicitud->id;");
            
        }


        if($res > 0)
        {
            if(isset($_POST['comentario']) && !empty($comentario))
            {
                $this->Conexion->insertar('solicitudes_facturas_comentarios', array('solicitud' => $solicitud->id, 'usuario' => $this->session->id, 'comentario' => $comentario), array('fecha' => 'CURRENT_TIMESTAMP()'));
                $solicitud->comentario = $comentario;
                
            }

            $correos = [];
            $correos_a = $this->Conexion->consultar("SELECT U.correo from privilegios P inner join usuarios U on P.usuario = U.id where P.responder_facturas = 1");
            foreach ($correos_a as $key => $value) {
                array_push($correos, $value->correo);
            }
            $solicitud->correos = array_merge(array($this->session->correo), $correos);
            $solicitud->User = $other->User;
            $solicitud->Client = $other->Client;
            $solicitud->Contact = $other->Contact;
            $mail['id']=$solicitud->id;
            $mail['estatus_factura']=$solicitud->estatus_factura;
            $mail['comentario']=$solicitud->comentario;
            $mail['User']=$other->User;
            $mail['Client']=$other->Client;
            $mail['Contact']=$other->Contact;
            $mail['correos']=array_merge(array($this->session->correo), $correos);
            //echo var_dump($mail);die();

            
            $this->correos_facturacion->editar_solicitud($mail);
            echo "1";
        }
        else
        {
            echo "";
        }
    }

    function ajax_getReporteServicios(){

       

        $texto = $this->input->post('texto');
        $rs = $this->input->post('rs');

        $query = "SELECT * FROM `clientes` WHERE `telefono`";
        $res = $this->Conexion->Consultar($query);
        //echo var_dump($res);die();

        if($res){
            echo json_encode($res);
        }
    }
     function ajax_get_ticktes(){


        $query = "SELECT * FROM VentToolCrib WHERE id_servicio IS NULL";
        $res = $this->Conexion->Consultar($query);
       
        if($res){
            echo json_encode($res);
        }
    }
    function ajax_get_servicios(){


        $query = "SELECT * FROM servicios where activo =1";
        $res = $this->Conexion->Consultar($query);
       
        if($res){
            echo json_encode($res);
        }
    }
    function ajax_get_piezas(){


        $query = "SELECT * FROM piezas_motor";
        $res = $this->Conexion->Consultar($query);
       
        if($res){
            echo json_encode($res);
        }
    }

    function ajax_getRSItems(){
        $id_factura = $this->input->post('id_factura');
        $res = $this->Conexion->Consultar("SELECT * from rsitems_facturas where id_factura = $id_factura");
        if($res){
            echo json_encode($res);
        }
    }


    function ajax_setComentarios(){
        $comentario['comentario'] = $this->input->post('comentario');
        $comentario['id_wo'] = $this->input->post('wo');
        $comentario['id_us'] = $this->session->id;
        $comentario['asignado'] = $this->input->post('usuario');
        $comentario['archivo'] = file_get_contents($_FILES['file']['tmp_name']);
        
        $funciones = array('fecha' => 'CURRENT_TIMESTAMP()');
        

        $res = $this->Conexion->insertar('comentarios_wo', $comentario, $funciones);
        if($res > 0)
        {
            echo "1";
        }
        else
        {
            echo "";
        }


    }

    function ajax_getComentarios(){
        $id = $this->input->post('id');

        $query = "SELECT c.comentario, c.fecha, concat(u.nombre, ' ', u.paterno) as nombre FROM comentarios_wo c JOIN usuarios u on u.id=c.id_us WHERE 1=1 ";

        if($id)
        {
            $query .= " and c.id_wo = '$id'";
        }
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }


    }
    function ajax_getServicios(){
        $id = $this->input->post('id');

        $query = "SELECT sw.*, s.magnitud, s.descripcion, s.sitio from servicios_wo sw JOIN servicios s on s.id=sw.id_servicio WHERE 1=1 ";

        if($id)
        {
            $query .= " and sw.id_wo = '$id'";
        }
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }


    }
    function ajax_getPiezas(){
        $id = $this->input->post('id');

        $query = "SELECT ps.*, p.nombre FROM piezas_ser_motor ps JOIN piezas_motor p ON ps.id_pieza = p.id WHERE 1=1 ";

        if($id)
        {
            $query .= " and ps.id_wo = '$id'";
        }
       // echo $query;die();
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }


    }

    function ajax_getRequisitores(){
        $id = $this->input->post('id');

        $query = "SELECT U.id, concat(U.nombre, ' ', U.paterno) as Nombre, P.puesto as Puesto from usuarios U inner join puestos P on U.puesto = P.id inner join privilegios PR on PR.usuario = U.id where U.activo = 1 and PR.solicitar_facturas = 1";

        if($id)
        {
            $query .= " and U.id = '$id'";
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

   /* function ajax_getVFPData(){
        $modelo = $this->input->post('modelo');
        $res = shell_exec("C:/xampp/htdocs/MASMetrologia/vfp_reader/vfp_reader.exe \"$modelo\"");
        echo $res;
    }

    function archivo_impresion(){

  ob_end_clean();
        $id = $this->input->post('id');
        $codigo = $this->input->post('codigo');
        
                         ob_start();
  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 0);
  ini_set('log_errors', 1);

  


        $pdf = new PDFMerger();

        $q="SELECT SF.* from solicitudes_facturas SF where SF.id = $id";
        //echo $q;die();
        $res = $this->Conexion->consultar($q, TRUE);


        for ($i=0; $i < strlen($codigo); $i++) { 
            switch (strtoupper($codigo[$i])) {
                
                case 'F':
                    $campo = 'f_factura';
                    break;
    
                case 'R':
                    $campo = 'f_remision';
                    break;
    
                case 'O':
                    $campo = 'f_orden_compra';
                    break;
    
                case 'A':
                    $campo = 'f_acuse';
                    break;

                case 'P':
                    $campo = 'OPINION';
                    break;

                case 'S':
                    $campo = 'EMISI ON';
                    break;

                default:
                    $campo = null;
                    break;
            }

            
            if($campo != null)
            {
                if(substr($campo, 0, 2 ) == "f_")
                {

                    $file = $res->$campo; 

                    $fichero = sys_get_temp_dir(). '/' . $campo . '.pdf';
                    file_put_contents($fichero, $file);
                   
                    $pdf->addPDF($fichero, 'all');
                }
                else
                {
                    $fichero = "data/empresas/documentos_globales/" . $campo . "_000001.pdf";
                    $pdf->addPDF($fichero, 'all');
                }
            }
        }
        

ob_end_clean();
       $pdf->merge('browser');

       
        
    }*/

    function ajax_getClientes(){
        
        $query = "SELECT C.id, C.nombre, C.razon_social, C.foto, C.opinion_positiva, C.emision_sua from empresas C where C.cliente = 1";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_getClientesSolicitudes(){
        $texto = $this->input->post('texto');
        
        $query = "SELECT E.id, E.nombre, count(S.id) as NumSol from solicitudes_facturas S inner join empresas E on E.id = S.cliente";

        if($texto)
        {
            $query .= " where E.nombre like '%$texto%'";
        }
        $query .= " group by E.id;";

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getEjecutivosSolicitudes(){
        $texto = $this->input->post('texto');
        
        $query = "SELECT U.id, concat(U.nombre, ' ', U.paterno) as Ejecutivo, count(S.id) as NumSol from solicitudes_facturas S inner join usuarios U on U.id = S.ejecutivo";

        if($texto)
        {
            $query .= " where concat(U.nombre, ' ', U.paterno) like '%$texto%'";
        }
        $query .= " group by U.id;";

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }
    }

    function ajax_getDocumentosGlobales(){
        
        $query = "SELECT id, opinion_positiva, emision_sua from documentos_globales where id = 1";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }

    function ajax_filesExists($id){
        $this->load->helper('file');

        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        $acuse = read_file(base_url("data/empresas/documentos_facturacion/ACUSE_" . $id . ".pdf")) ? "1" : "0";
        $emision = read_file(base_url("data/empresas/documentos_facturacion/EMISION_" . $id . ".pdf")) ? "1" : "0";

        echo json_encode(array($acuse, $emision));
    }

    function ajax_readXML(){
        $dom = new DomDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML(file_get_contents($_FILES['f_X']['tmp_name']));
      //$dom->loadXML(file_get_contents(base_url('data/1.xml')));
        $comp = $dom->getElementsByTagName('Comprobante');
        $ext = 1;
        $data = array();
        foreach ($comp[0]->attributes as $elem)
        {
            if($elem->name == "Serie" | $elem->name == "Folio" | $elem->name == "SubTotal")
            {
                $e = array($elem->name => $elem->value);
                array_push($data, $e);
            }


            if($elem->name == "Folio")
            {
                $folio = $elem->value;

                $res = $this->Conexion->consultar("SELECT count(*) as existe FROM solicitudes_facturas where folio = '$folio'", TRUE);
                $ext = $res->existe;
            }

            
        }

        if($ext == 0)
        {
            echo json_encode($data);
        }
        else
        {
            echo "0";
        }
        
    }

    function ajax_setDocumentoFacturacion(){
        $file = $this->input->post('file');
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        
        if($file != "undefined")
        {
            $config['upload_path'] = 'data/empresas/documentos_facturacion/';
            $config['allowed_types'] = 'pdf';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $documento . '_' . $id;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file'))
            {
                $where['id'] = $id;
                switch($documento)
                {
                    case "EMISION":
                    $campo = "emision_sua";
                    break;
                    
                    case "OPINION":
                    $campo = "opinion_positiva";
                    break;
                }
                $data[$campo] = $this->upload->data('file_name');
                $this->Conexion->modificar('empresas', $data, null, $where);
                echo "1";
            } 
        }
    }

    function ajax_deleteDocumentoFacturacion(){
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        unlink('data/empresas/documentos_facturacion/' . $documento . '_' . $id . '.pdf');

        $where['id'] = $id;
        switch($documento)
        {
            case "EMISION":
            $campo = "emision_sua";
            break;
            
            case "OPINION":
            $campo = "opinion_positiva";
            break;
        }
        $data[$campo] = "";
        $this->Conexion->modificar('empresas', $data, null, $where);
    }

    function ajax_setDocumentoGlobal(){
        $file = $this->input->post('file');
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        
        if($file != "undefined")
        {
            $config['upload_path'] = 'data/empresas/documentos_globales/';
            $config['allowed_types'] = 'pdf';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $documento . '_' . $id;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file'))
            {
                $where['id'] = $id;
                switch($documento)
                {
                    case "EMISION":
                    $campo = "emision_sua";
                    break;
                    
                    case "OPINION":
                    $campo = "opinion_positiva";
                    break;
                }
                $data[$campo] = $this->upload->data('file_name');
                $this->Conexion->modificar('documentos_globales', $data, null, $where);
                echo "1";
            } 
        }
    }

    function ajax_deleteDocumentoGlobal(){
        $documento = $this->input->post('documento');
        $id = $this->input->post('empresa');
        $id = str_pad($id, 6, "0", STR_PAD_LEFT);
        unlink('data/empresas/documentos_globales/' . $documento . '_' . $id . '.pdf');

        $where['id'] = $id;
        switch($documento)
        {
            case "EMISION":
            $campo = "emision_sua";
            break;
            
            case "OPINION":
            $campo = "opinion_positiva";
            break;
        }
        $data[$campo] = "";
        $this->Conexion->modificar('documentos_globales', $data, null, $where);
    }

    function ajax_enviarCorreo(){
        $id = $this->input->post('id');
        $body = $this->input->post('body');
        $subject = $this->input->post('subject');
        $para = $this->input->post('para');
        $cc = $this->input->post('cc');
        
        $campos = json_decode($this->input->post('campos'));

        $archivos = [];
        $res = $this->Conexion->consultar("SELECT SF.* from solicitudes_facturas SF where SF.id = $id", TRUE);
        foreach ($campos as $value) {
            if(substr($value, 0, 2 ) == "f_")
            {
                $file = $res->$value;
                $fichero = sys_get_temp_dir(). '/' . $value . ($value == "f_xml" ? '.xml' : '.pdf');
                file_put_contents($fichero, $file);
            }
            else
            {
                switch ($value) {
                    case 'opinion_positiva':
                        $value = 'OPINION';
                        break;
                    
                    case 'emision_sua':
                        $value = 'EMISION';
                        break;
                }
                $fichero = "data/empresas/documentos_globales/" . $value . "_000001.pdf";
            }

            array_push($archivos, $fichero);
        }

        $datos['id'] = $id;
        $datos['para'] = $para;
        $datos['cc'] = $cc;
        $datos['subject'] = $subject;
        $datos['body'] = $body;
        $datos['campos'] = $campos;
        $datos['archivos'] = $archivos;
        $this->correos_facturacion->enviarCorreo($datos);

    }

    ////////////////////////////////// F A C T U R A S //////////////////////////////////

    function ajax_getFacturas(){
        $id = $this->input->post('id');

        $query = "SELECT F.id, F.fecha, F.usuario, F.cliente, F.contacto, F.reporte_servicio, F.orden_compra, F.forma_pago, F.pagada, F.conceptos, F.notas, F.estatus_factura, F.documentos_requeridos, F.serie, F.folio, F.codigo_impresion, (SELECT count(id) from recorrido_conceptos where id_concepto = F.id and tipo = 'FACTURA') as Recorridos, (SELECT count(id) from envios_factura where factura = F.id) as Envios, E.nombre as Cliente, concat(U.nombre, ' ', U.paterno) as User, U.correo, ifnull(EC.correo, 'N/A') as CorreoContacto from solicitudes_facturas F inner join empresas E on E.id = F.cliente inner join usuarios U on U.id = F.usuario left join empresas_contactos EC on EC.id = F.contacto";
        $query .= " where F.folio > 0 and F.estatus = 'ACEPTADO'";

        if($id)
        {
            $query .= " and F.id = '$id'";
        }
        
        if(isset($_POST['estatus']))
        {
            $estatus = $this->input->post('estatus');
            $query .= " and F.estatus = '$estatus'";
        }

        $res = $this->Conexion->consultar($query, $id);
        if($res)
        {
            echo json_encode($res);
        }
    }


    ////////////////////////////////// L O G I S T I C A //////////////////////////////////
    function ajax_getMensajeros(){
        $query = "SELECT U.id, U.nombre, U.paterno, U.materno, U.no_empleado, U.puesto, U.correo, U.ultima_sesion, U.departamento, U.activo, U.jefe_directo, U.autorizador_compras, U.autorizador_compras_venta, concat(U.nombre, ' ', U.paterno) as User, concat(U.nombre, ' ', U.paterno, ' ', U.materno) as CompleteName from usuarios U inner join privilegios P on P.usuario = U.id where U.activo = '1'";// having Name like '%$texto%'";
        $query .= " and P.mensajero = '1'";
        $query .= " order by User";
        
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }

    }

    function ajax_setRecorrido(){
        $mensajero = $this->input->post('mensajero');
        $fecha = $this->input->post('fecha');
        $recorrido = json_decode($this->input->post('recorrido'));

        $data['mensajero'] = $mensajero;
        $data['fecha_recorrido'] = $fecha;
        $recorrido_id = $this->Conexion->insertar('recorridos', $data);

        foreach ($recorrido as $value) {
            $data2['recorrido'] = $recorrido_id;
            $data2['factura'] = $value[1];
            $data2['accion'] = $value[0];
            $data2['estatus'] = "EN RECORRIDO";

            $this->Conexion->insertar('recorrido_conceptos', $data2);
            $this->Conexion->modificar('solicitudes_facturas', array('estatus' => $data2['estatus']), null, array('id' => $data2['factura']));
        }
        
    }

    function ajax_getRecorridos(){
        $pendientes = $this->input->post('pendientes');
        $factura = $this->input->post('factura');

        $query = "SELECT RF.*, R.mensajero, R.fecha_recorrido, (SELECT count(RC.id) from recorrido_comentarios RC where RC.recorrido_factura = RF.id) as Comentarios, (SELECT count(RF2.id) from recorrido_facturas RF2 where RF2.recorrido = RF.recorrido and RF2.estatus = 'EN RECORRIDO') as Pendientes, (SELECT E.nombre from solicitudes_facturas F inner join empresas E on E.id = F.cliente where F.id = RF.factura) as Cliente, ifnull(concat(M.nombre, ' ', M.paterno), 'N/A') as Mensajero from recorrido_facturas RF inner join recorridos R on R.id = RF.recorrido left join usuarios M on M.id = R.mensajero where 1 = 1";

        if(isset($_POST['factura']))
        {
            $query .= " and RF.factura = $factura";
        }

        if($pendientes == "1")
        {
            $query .= " having Pendientes > 0";
        }

        $query .= " order by R.fecha_recorrido, R.id, RF.id asc";

        $res = $this->Conexion->consultar($query);

        echo json_encode($res);
    }

    function ajax_updateRecorrido(){
        $recorrido = json_decode($this->input->post('recorrido'));
        $recolecta = $this->input->post('recolecta');
        $comentario = $this->input->post('comentario');
        
        $this->Conexion->modificar('recorrido_facturas', $recorrido, null, array('id' => $recorrido->id));

        if(substr($recorrido->estatus, 0, 2) == "NO")
        {
            $estat = "PENDIENTE " . $recorrido->accion;
            $this->Conexion->modificar('solicitudes_facturas', array('estatus' => $estat), null, array('id' => $recorrido->factura));
        }
        else
        {
            $estat = $recolecta == "1" ? "PENDIENTE RECOLECTA" : "CERRADO";
            $this->Conexion->modificar('solicitudes_facturas', array('estatus' => $estat), null, array('id' => $recorrido->factura));
        }

        if($comentario)
        {
            $color = substr($recorrido->estatus, 0, 2) == "NO" ? "red" : "green";
            $comentario = '<font color=' . $color . '><b>' . $recorrido->estatus . ':</b></font> ' . $comentario;

            $data_com['recorrido_factura'] = $recorrido->id;
            $data_com['usuario'] = $this->session->id;
            $data_com['comentario'] = $comentario;
            $func_com['fecha'] = "CURRENT_TIMESTAMP()";
            $this->Conexion->insertar('recorrido_comentarios', $data_com, $func_com);
        }
        
        
    }

    function ajax_getComentariosRecorrido(){
        $id = $this->input->post('id');

        $query = "SELECT C.*, concat(U.nombre, ' ', U.paterno) as User from recorrido_comentarios C inner join usuarios U on U.id = C.usuario where 1 = 1";

        if($id)
        {
            $query .= " and C.recorrido_factura = '$id'";
        }
        $query .= " order by C.fecha";

        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }


    }
    function ver_POD($id){
        //$query = "SELECT sf.id,sf.folio, sf.reporte_servicio, sf.fecha, sf.reporte_servicio, sf.orden_compra, concat(u.nombre, ' ',u.paterno) as responsable, e.razon_social, ec.nombre as contacto, ec.correo, concat(e.calle, ' ',e.numero, ' CP ',e.cp) as direccion,e.ciudad, e.estado, e.rfc,e.colonia FROM `solicitudes_facturas` sf JOIN usuarios u on u.id = sf.ejecutivo join empresas e on e.id = sf.cliente join empresas_contactos ec on ec.id = sf.cliente WHERE sf.id= $id";
//echo $query;
        $query = "SELECT sf.id, sf.folio,sf.serie, sf.reporte_servicio, sf.fecha, sf.orden_compra, concat(u.nombre, ' ', u.paterno) as responsable, e.razon_social, concat(e.calle, ' ',e.numero, ' CP ',e.cp) as direccion,e.ciudad, e.estado, e.rfc,e.colonia, ec.nombre as contacto, ec.correo FROM solicitudes_facturas sf join usuarios u on sf.ejecutivo = u.id JOIN empresas e on sf.cliente = e.id JOIN empresas_contactos ec on sf.contacto = ec.id WHERE sf.id =$id";
        $factura = $this->Conexion->consultar($query, TRUE);

  //      $query2 = "SELECT * FROM rsitems_facturas WHERE id_factura =".$id;
$query2 = "SELECT rs.descripcion, rs.Equipo_ID, rs.Fec_CalibracionMT, s.DescripcionDeServicio, concat(rs.descripcion, if(isnull(rs.Fabricante), '', concat(' ', rs.Fabricante)), if(isnull(rs.Modelo), '', concat(' ', rs.Modelo)), if(isnull(rs.Serie), '', concat(' Serie: ', rs.Serie)) ) as CadenaDescripcion from rsitems rs JOIN catalogo_servicios s on s.servicio_id = rs.item_servicio_id WHERE rs.Solicitud_ID =".$id." and rs.Factura = '".$factura->folio."'";
        $rs = $this->MLConexion->consultar($query2);
        $total=0;
        foreach($rs as $row){
            $total++;
        }
        ini_set('display_errors', 0);
        $this->load->library('pdfview');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
       

        $f=$factura->serie . "-".$factura->folio; 
     
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle('Masmetrologia');
        $pdf->SetSubject('Formato Cotización');
        $spc = "           ";
        $head = "$spc           Prueba de Entrega      $spc Folio: $id / Factura: $f";
        $txt = "                             Proof of delivery                       Responsable: " . $factura->responsable;
        $txt .= "\n                                                                                Fec. de elaboración:: " . $factura->fecha;
       

        $pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', $head, $txt);


        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('helvetica', '', 8);

        $pdf->AddPage();
        $pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 10);
        $tbl = <<<EOD
        <br>
            <table border="0">
                <tr>
                    <td>
                        <b>Cliente/Customer:</b><br>
                        $factura->razon_social<br>
                        $factura->direccion<br>
                        $factura->colonia<br>
                        $factura->ciudad, $factura->estado<br>
                        RFC: $factura->rfc<br>
                        
                    </td>
                    <td>
EOD;


        $tbl .= <<<EOD
        <b>Orden de Compra: </b>
        $factura->orden_compra<br>
        <b>Contacto / Contact: </b><br>
        $factura->contacto<br>
        $factura->correo<br>
        <br>        
        Total de Equipo(s):  $total<br>
        </td>
        </tr>
    </table>
EOD;

        $pdf->writeHTML($tbl, false, false, false, false, '');
        $w = array(8, 125, 12, 24, 24);


        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(255);
        $pdf->Ln();$pdf->Ln();
        $w = array(20, 20, 125, 20);

        $pdf->SetTextColor(0);
        $pdf->SetFont('helvetica', '', 10);
            $pdf->Ln();
        $tabla_items='';

            $tabla_items .= '<table style=" ">
                            <thead> 
                                <tr>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 15%;">Servicio</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 15%;">Equipo ID</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 55%;">Descripcion</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 15%;">Realizado</th>
                                </tr>
                            </thead>
                            <tbody>';
         foreach($rs as $row){
            $date=date_create($row->Fec_CalibracionMT);
            $tabla_items .='
                        <tr>
                            <td style="border-bottom: 1px solid #000; text-align: center; width: 15%; tr:nth-child:background: #F8F8F8;">'.$row->DescripcionDeServicio .'</td>
                            <td style="border-bottom: 1px solid #000; text-align: center; width: 15%; tr:nth-child:background: #F8F8F8;">'.$row->Equipo_ID.'</td>
                            <td style="border-bottom: 1px solid #000; text-align:center ; width: 55%; tr:nth-child:background: #F8F8F8;">'.$row->CadenaDescripcion.'</td>
                            <td style="border-bottom: 1px solid #000; text-align: center;width: 15%; tr:nth-child:background: #F8F8F8;">'.date_format($date,'d/M/Y').'</td>
                        </tr>';
             }
             $tabla_items .= '</tbody>
                </table>
                <br> 
                <br> 
                <br> 
                <br> 
                <br> 
                <br> ';

        $pdf->writeHTML($tabla_items, true, false, false, false, '');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(150, 8,"Recibí el servicio a los equipos arriba listados", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->writeHTML("_________________________", true, false, false, false, '');
        $pdf->MultiCell(150, 8,"Firma de recibido", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->Ln();
        $name = "POD ".$id." - PO ".$factura->orden_compra.'.pdf';
  
        $pdf->Ln();
$pdf->Output(sys_get_temp_dir().'/'.$name, 'I');
    }
function ajax_enviarCorreoPOD(){
        $id = $this->input->post('id');
        $body = $this->input->post('body');
        $subject = $this->input->post('subject');
        $para = $this->input->post('para');
        $cc = $this->input->post('cc');
        $certificados=[];
        $pdfname=null;
        $xmlname =null;

        $campos = json_decode($this->input->post('campos'));
        $archivos = [];
        $name_files = [];
        $res = $this->Conexion->consultar("SELECT SF.* from solicitudes_facturas SF where SF.id = $id", TRUE);
        $pdfname=$res->name_factura;
        $xmlname=$res->name_xml;
         //echo var_dump(file_put_contents($_FILES[$res->f_factura]['name']));die();
        foreach ($campos as $value) {

            if(substr($value, 0, 2 ) == "f_")
            {
                $file = $res->$value;

                $fichero = sys_get_temp_dir(). '/' . $value . ($value == "f_xml" ? '.xml' : '.pdf');
                $name =$value == "f_xml" ? $res->name_xml : $res->name_factura;
               // echo var_dump($fichero);die();
                 file_put_contents($fichero, $file);
            }
            else
            {
                switch ($value) {
                    case 'opinion_positiva':
                        $value = 'OPINION';
                        break;
                    
                    case 'emision_sua':
                        $value = 'EMISION';
                        break;
                }
                $fichero = "data/empresas/documentos_globales/" . $value . "_000001.pdf";
            }

            array_push($archivos, $fichero);
            
        }

        $query = "SELECT sf.id, sf.folio,sf.serie, sf.reporte_servicio, sf.fecha, sf.orden_compra, concat(u.nombre, ' ', u.paterno) as responsable, e.razon_social, concat(e.calle, ' ',e.numero, ' CP ',e.cp) as direccion,e.ciudad, e.estado, e.rfc,e.colonia, ec.nombre as contacto, ec.correo FROM solicitudes_facturas sf join usuarios u on sf.ejecutivo = u.id JOIN empresas e on sf.cliente = e.id JOIN empresas_contactos ec on sf.contacto = ec.id WHERE sf.id =$id";

        $factura = $this->Conexion->consultar($query, TRUE);

        $query2 = "SELECT rs.descripcion, rs.Equipo_ID, rs.documento_id, rs.Fec_CalibracionMT, s.DescripcionDeServicio, concat(if(isnull(rs.Fabricante), '', concat(' ', rs.Fabricante)), if(isnull(rs.Modelo), '', concat(' ', rs.Modelo)), if(isnull(rs.Serie), '', concat(' Serie: ', rs.Serie)) ) as CadenaDescripcion from rsitems rs JOIN catalogo_servicios s on s.servicio_id = rs.item_servicio_id WHERE rs.Solicitud_ID =".$id." and rs.Factura = '".$factura->folio."'";
        //echo $query2;die();
         $rs = $this->MLConexion->consultar($query2);
         $total=0;
        foreach($rs as $row){
            $total++;
        }

        foreach ($rs as $key) {
        array_push($certificados, $key->documento_id);
    }

        ini_set('display_errors', 0);
        $this->load->library('pdfview');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
       


        $f=$factura->serie . "-".$factura->folio; 
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle('Masmetrologia');
        $pdf->SetSubject('Formato Cotización');
        $spc = "           ";
        $head = "$spc           Prueba de Entrega      $spc Folio: $id / Factura: $f";
        $txt = "                             Proof of delivery                       Responsable: " . $factura->responsable;
        $txt .= "\n                                                                                Fec. de elaboración:: " . $factura->fecha;
       

        $pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', $head, $txt);


        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('helvetica', '', 8);

        $pdf->AddPage();
        $pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 10);
        $tbl = <<<EOD
        <br>
            <table border="0">
                <tr>
                    <td>
                        <b>Cliente/Client:</b><br>
                        $factura->razon_social<br>
                        $factura->direccion<br>
                        $factura->colonia<br>
                        $factura->ciudad, $factura->estado<br>
                        $factura->rfc<br>
                        
                    </td>
                    <td>
EOD;


        $tbl .= <<<EOD
        <b>Orden de Compra: </b>
        $factura->orden_compra<br>
        <b>Contacto / Contact: </b><br>
        $factura->contacto<br>
        $factura->correo<br>
        <br>        
        Total de Equipo(s):  $total<br>
        </td>
        </tr>
    </table>
EOD;

        $pdf->writeHTML($tbl, false, false, false, false, '');
        $w = array(8, 125, 12, 24, 24);


        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(255);
        $pdf->Ln();$pdf->Ln();
        $w = array(20, 20, 125, 20);

        $pdf->SetTextColor(0);
        $pdf->SetFont('helvetica', '', 10);
            $pdf->Ln();
        $tabla_items='';

            $tabla_items .= '<table style=" ">
                            <thead> 
                                <tr>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 15%;">Servicio</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 15%;">Equipo ID</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 55%;">Descripcion</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold; width: 15%;">Realizado</th>
                                </tr>
                            </thead>
                            <tbody>';
         foreach($rs as $row){
            $date=date_create($row->Fec_CalibracionMT);
            $tabla_items .='
                         <tr>
                            <td style="border-bottom: 1px solid #000; text-align: center; width: 15%; tr:nth-child:background: #F8F8F8;">'.$row->DescripcionDeServicio .'</td>
                            <td style="border-bottom: 1px solid #000; text-align: center; width: 15%; tr:nth-child:background: #F8F8F8;">'.$row->Equipo_ID.'</td>
                            <td style="border-bottom: 1px solid #000; text-align:center ; width: 55%; tr:nth-child:background: #F8F8F8;">'.$row->CadenaDescripcion.'</td>
                            <td style="border-bottom: 1px solid #000; text-align: center;width: 15%; tr:nth-child:background: #F8F8F8;">'.date_format($date,'d/M/Y').'</td>
                        </tr>';
             }
             $tabla_items .= '</tbody>
                </table>
                <br> 
                <br> 
                <br> 
                <br> 
                <br> 
                <br> ';
        $pdf->writeHTML($tabla_items, true, false, false, false, '');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(150, 8,"Recibí el servicio a los equipos arriba listados", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->writeHTML("_________________________", true, false, false, false, '');
        $pdf->MultiCell(150, 8,"Firma de recibido", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->Ln();
        $name = "POD ".$id." - PO ".$factura->orden_compra.'.pdf';
  
        $pdf->Ln();
$pdf->Output(sys_get_temp_dir().'/'.$name, 'F');

$datos['pod']=sys_get_temp_dir().'/'.$name;

        $datos['id'] = $id;
        $datos['para'] = $para;
        $datos['cc'] = $cc;
        $datos['subject'] = "POD ".$id." - PO ".$factura->orden_compra;
        $datos['body'] = $body;
        $datos['campos'] = $campos;
        $datos['archivos'] = $archivos;
        $datos['certificados'] = $certificados;
        $datos['pdfname']=$pdfname;
        $datos['xmlname']=$xmlname;
        $datos['po']=$factura->orden_compra;
//echo var_dump($certificados);die();
        $this->correos_facturacion->archivos_facturacion($datos);

    }
    public function validar_archivos(){
        $id=$this->input->post('ID');
        $factura = $this->Conexion->consultar("SELECT id, folio  from solicitudes_facturas where id= ".$id, true);

        $query = " select item_id, documento_id,Fec_CalibracionMT from rsitems where factura = ".$factura->folio." and Solicitud_ID";
        //echo $query;die()
        $rs = $this->MLConexion->consultar($query);
        
        if($rs)
        {
            echo json_encode($rs);
            //echo $query;
        }
        else{
            echo "";
        }
    }
    function ver_wo_pdf($id)
    {
        $query = "SELECT wo.*, wd.*, rs.folio_id, rs.Localizacion, ei.Status_Descripcion as estatus_item, ew.Status_Descripcion as estatus_wo, concat(rs.descripcion, if(isnull(rs.Fabricante), '', concat(' ', rs.Fabricante)), if(isnull(rs.Modelo), '', concat(' ', rs.Modelo)), if(isnull(rs.Serie), '', concat(' Serie: ', rs.Serie)), if(isnull(rs.Equipo_ID), '', concat(' ID: ', rs.Equipo_ID))) as CadenaDescripcion from WO_Master wo JOIN WO_Detail wd on wo.WorkOrder_ID=wd.WorkOrder_ID JOIN rsitems rs ON rs.item_id=wd.Item_Id JOIN tblStatusWO ei on ei.Status_id = wd.Item_Status JOIN tblStatusWO ew on ew.Status_ID=wo.WorkOrder_Status where wo.WorkOrder_ID = ".$id;
        $wo_detail=$this->MLConexion->consultar($query);
        $query2 = "SELECT wo.*, wd.*,rsn.Notas, we.Status_Descripcion, ct.nombre, rs.folio_id, rh.Empresa, rh.Direccion1, rh.Contacto, rh.TelefonoContacto, rh.CelularContacto from WO_Master wo JOIN WO_Detail wd on wo.WorkOrder_ID=wd.WorkOrder_ID JOIN tblStatusWO we on we.Status_ID=wo.WorkOrder_Status JOIN catalogo_tecnicos ct on ct.email_tecnico=wo.correo_us join rsitems rs on rs.item_id =wd.Item_Id join rsheaders rh on rh.folio_id=rs.folio_id join rsheadersnotas rsn on wo.rs=rsn.Folio_ID where wo.WorkOrder_ID=   ".$id;
        $wo=$this->MLConexion->consultar($query2, TRUE);
        $comentario="SELECT cm.*, ct.nombre FROM comentarios_wo cm JOIN catalogo_tecnicos ct on cm.mail_us=ct.email_tecnico where 1 = 1 and cm.id_wo =".$id;
        $cm=$this->MLConexion->consultar($comentario);
         ini_set('display_errors', 0);
        $this->load->library('pdfview');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


       

        
     
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle('Masmetrologia');
        $pdf->SetSubject('Formato Cotización');
        $spc = "                                         ";
        $head = "$spc                              Orden De Servicio      $spc Folio: $id";
        $txt = "$spc$spc Work Order                  $spc    Responsable: " . $wo->nombre;
        $txt .= "\n       $spc    $spc                                                                        Fec. de Programada: " . $wo->FProgramado;
        $txt .= "\n         $spc  $spc                                                                        RS: " . $wo->folio_id;
       

        $pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '40', $head, $txt);


        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('helvetica', '', 8);

        //$pdf->AddPage();
        $pdf->AddPage('L', array('format' => 'A4'));

        $pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 10);
        $tbl = <<<EOD
        <br>
            <table border="0">
                <tr>
                    <td>
                        <b>Cliente/Customer:</b><br>
                        $wo->Empresa<br>
                        $wo->Direccion1<br>
                        $wo->Contacto<br>
                        Telefono: $wo->TelefonoContacto Celular: $wo->CelularContacto<br>
                        
                    </td>
                    <td>
EOD;

        $pdf->writeHTML($tbl, false, false, false, false, '');
        $w = array(8, 125, 12, 24, 24);


        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(255);
        $pdf->Ln();$pdf->Ln();
        $w = array(20, 20, 125, 20);

        $pdf->SetTextColor(0);
        $pdf->SetFont('helvetica', '', 10);
            $pdf->Ln();
        $tabla_items='';

            $tabla_items .= '<table >
                            <thead> 
                                <tr>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold; width: 10%;" >RS</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold; width: 10%;" >Item</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 20%;" >Descripcion</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 10%;" >Loc.</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 10%;" >Venc.</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 10%;" >Cal.</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 10%;" >Tipo</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 10%;" >Motivo</th>
                                                      <th style="border: 1px solid #000; text-align: center; font-weight: bold;width: 10%;" >Estatus</th>
                              </tr>
                            </thead>
                            <tbody>';
         foreach ($wo_detail as $key){
           
            $tabla_items .='
                        <tr>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->folio_id.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->Item_Id.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 20%;">'.$key->CadenaDescripcion.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->Localizacion.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->vencimiento .'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->calibrado.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->tipo_cal.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->motivo.'</td>
                            <td style="border: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8; width: 10%;">'.$key->estatus_item.'</td>
                        </tr>';
             }
             $tabla_items .= '</tbody>
                </table>
                <br> 
                <br> 
                <br> ';

$pdf->SetFont('helvetica', '', 9);

        $pdf->writeHTML($tabla_items, true, false, false, false, '');
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->writeHTML("_____________________________________", true, false, false, false, '');
        $pdf->MultiCell(150, 8,"Nombre y firma de quien recibe el servicio.", 0, 'L', 1, 0, '', '', true, 0, false, true, 0);
        $pdf->Ln();
        $pdf->Ln();
             $lista = "";
             $lista .="<h2>Comentarios:</h2>";
             foreach ($cm as $ul) {
                 $lista.="
                 <li>
                    
                    <span>
                                ".$ul->nombre."<small> ".$ul->fecha."</span>
                    </span>

                    <span >".$ul->comentario."</span>
                    <br>
                    
                    </li>";
             }
             
    

$pdf->writeHTML($lista, true, false, false, false, '');

$pdf->Ln();
             $notas = "";
             $notas .="<h3>Notas:</h3>";
             $notas.="                    
                    <span>
                                ".$wo->Notas."</span>
                    </span>";
        $pdf->writeHTML($notas, true, false, false, false, '');
        $name = "POD ".$id." - PO ".$factura->orden_compra.'.pdf';

  
        $pdf->Ln();
$pdf->Output(sys_get_temp_dir().'/'.$name, 'I');
    }

    function ajax_getClientesCotizaciones(){
        $texto = $this->input->post('texto');
        
        $query = "SELECT Cust_ID, `Nombre Corto`  as nombre FROM catalogo_clientes where `Nombre Corto` is not null and  `Nombre Corto`  != '.'  ";

        if($texto)
        {
            $query .= "  and `Nombre Corto` like '%$texto%'";
        }
        

        $res = $this->MLConexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }
    }
    function ver_foto($id){
      $photo = $this->MLConexion->consultar('select * from WO_Master where WorkOrder_ID = '.$id);
      if($photo)
      {
        header("Content-type: image/png");
        echo $photo->foto;
      }
      else {
        echo "ERROR";
      }
    }
    function ajax_setCliente(){
          $id = $this->input->post('id');
        
        $query ="select * from clientes where id = ".$id;

        $res = $this->Conexion->consultar($query, TRUE);

        if($res)
        {
            echo json_encode($res);
        }

    }

    function ajax_setTicket(){
          $id = $this->input->post('id');
          $wo = $this->input->post('wo');
        
       $res= $this->Conexion->comando("UPDATE VentToolCrib set id_servicio = ".$wo." where  idToolCrib = ".$id);        
       

        if($res)
        {
            echo json_encode($res);
        }

    }
    function ajax_setServicios(){
          $id = $this->input->post('id');
          $wo = $this->input->post('wo');
          $servicio = $this->Conexion->consultar("SELECT * from servicios where id=".$id, TRUE);
        
        $datos['id_wo']=$wo;
        $datos['id_servicio']=$id;
        $datos['total']=$servicio->clave_precio;


        $res=$this->Conexion->insertar('servicios_wo', $datos);

        if($res)
        {
            echo json_encode($res);
        }

    }
  function ajax_setPiezas(){
    $id = $this->input->post('id');
    $wo = $this->input->post('wo');
    $size = $this->input->post('size'); // ← nuevo valor recibido

    $datos['id_wo'] = $wo;
    $datos['id_pieza'] = $id;
    $datos['size'] = $size; // ← lo agregas aquí

    $res = $this->Conexion->insertar('piezas_ser_motor', $datos);

    if ($res) {
        echo json_encode($res);
    }
}

    function ajax_setPrecio(){
          $id = $this->input->post('id');
          $total = $this->input->post('total');
        
       $res= $this->Conexion->comando("UPDATE servicios_wo set total = ".$total." where  id = ".$id);        
       

        if($res)
        {
            echo json_encode($res);
        }

    }
    function ajax_setPrecioPieza(){
          $id = $this->input->post('id');
          $total = $this->input->post('total');
        
       $res= $this->Conexion->comando("UPDATE piezas_ser_motor set total = ".$total." where  id = ".$id);        
       

        if($res)
        {
            echo json_encode($res);
        }

    }
     function ajax_setPrecioTemp(){
          $json = $this->input->post('datos');
    $datos = json_decode($json);

    foreach ($datos as $item) {
        $id = (int)$item->id;
        $precio = (float)$item->precio;
        $this->Conexion->comando("UPDATE servicios_wo_temp SET precio = $precio WHERE id = $id");
    }

    $query = "SELECT st.*, s.magnitud FROM servicios_wo_temp st
              JOIN servicios s ON s.id = st.id_servicio
              WHERE idus = " . $this->session->id;

    $res = $this->Conexion->consultar($query);

    echo json_encode($res);
    }
       function ajax_setPrecioPiezasTemp(){
          $json = $this->input->post('datos');
    $datos = json_decode($json);

    foreach ($datos as $item) {
        $id = (int)$item->id;
        $precio = (float)$item->precio;
        $this->Conexion->comando("UPDATE piezas_temp SET precio = $precio WHERE id = $id");
    }

    $query ="SELECT pt.*, p.nombre FROM piezas_temp pt join piezas_motor p on p.id=pt.idpieza where pt.idus =".$this->session->id;

    $res = $this->Conexion->consultar($query);

    echo json_encode($res);
    }
     function ajax_setTicket_garantia(){
          $id = $this->input->post('id');
          $venta = $this->input->post('venta');
        
       $res= $this->Conexion->comando("UPDATE VentToolCrib set id_garantia = ".$venta." where  idToolCrib = ".$id);        
       

        if($res)
        {
            echo json_encode($res);
        }

    }

    function buscarServicios()
    {
        $query = "SELECT * FROM `servicios`";
        $res = $this->Conexion->Consultar($query);
        //echo var_dump($res);die();

        if($res){
            echo json_encode($res);
        }
    }
    function buscarPiezas()
    {
        $query = "SELECT * FROM `piezas_motor`";
        $res = $this->Conexion->Consultar($query);
        //echo var_dump($res);die();

        if($res){
            echo json_encode($res);
        }
    }
    function ajax_setServicio(){
        $id = $this->input->post('id');
//echo $id;die();
        
        $query ="select clave_precio from servicios where id= ".$id;

        $precio = $this->Conexion->consultar($query, TRUE);
        $datos['idus']=$this->session->id;
        $datos['id_servicio']=$id;
        $datos['id_servicio']=$id;
        $datos['precio']=$precio->clave_precio;

        $this->Conexion->insertar('servicios_wo_temp', $datos);
        
        $query ="select st.*, s.magnitud from servicios_wo_temp st join servicios s on s.id=st.id_servicio where idus = ".$this->session->id;

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }

    }
    function ajax_setPieza(){
        $id = $this->input->post('id');
        $size = $this->input->post('size');
        $query ="select precio from piezas_motor where id= ".$id;

        $precio = $this->Conexion->consultar($query, TRUE);
        $datos['idus']=$this->session->id;
        $datos['idpieza']=$id;
        $datos['precio']=$precio->precio;
        $datos['size'] = $size;

        $this->Conexion->insertar('piezas_temp', $datos);
        
        $query ="SELECT pt.*, p.nombre FROM piezas_temp pt join piezas_motor p on p.id=pt.idpieza where pt.idus =".$this->session->id;

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }

    }
    function ajax_delServicio(){
        $id = $this->input->post('id');
          $this->Conexion->comando("DELETE FROM servicios_wo_temp WHERE id =".$id);

        
        $query ="select st.*, s.magnitud from servicios_wo_temp st join servicios s on s.id=st.id_servicio where idus = ".$this->session->id;

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }

    }
     function ajax_delPieza(){
        $id = $this->input->post('id');
          $this->Conexion->comando("DELETE FROM piezas_temp WHERE id =".$id);

        
        $query ="SELECT pt.*, p.nombre FROM piezas_temp pt join piezas_motor p on p.id=pt.idpieza where pt.idus =".$this->session->id;

        $res = $this->Conexion->consultar($query);

        if($res)
        {
            echo json_encode($res);
        }

    }
 function buscarUsuarios()
    {
        $query = "SELECT id,concat(nombre, ' ', paterno) as name, correo FROM `usuarios`";
        $res = $this->Conexion->Consultar($query);
        //echo var_dump($res);die();

        if($res){
            echo json_encode($res);
        }
    }
     function ajax_setUsuarios(){
          $id = $this->input->post('id');
        
        $query ="SELECT id, concat(nombre, ' ', paterno) as name, correo FROM `usuarios`  WHERE id= ".$id;

        $res = $this->Conexion->consultar($query, TRUE);

        if($res)
        {
            echo json_encode($res);
        }

    }
     function ajax_setAnticipo(){
          $anticipo = $this->input->post('anticipo');
          $wo = $this->input->post('wo');
        
        $datos['id_venta']=$wo;
        $datos['cantidad']=$anticipo;
        $datos['us']=$this->session->id;


        $res=$this->Conexion->insertar('pagos_wo', $datos);

        if($res)
        {
            echo json_encode($res);
        }

    }
    function ajax_getAnticipos(){
        $id = $this->input->post('id');

        $query = "SELECT p.*, concat(u.nombre,' ', u.paterno) as user FROM pagos_wo p JOIN usuarios u on u.id=p.us WHERE 1=1 ";

        if($id)
        {
            $query .= " and  id_venta  = '$id'";
        }
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }


    }
    function cerrar_comentario($id){

        $this->Conexion->comando("UPDATE comentarios_wo set atendido = 1 where id = ".$id);
        redirect(base_url('inicio'));
    }

function ajax_getWos()
{
    $this->load->model('privilegios_model');
    $texto = $this->input->post('texto');
    $estatus = $this->input->post('estatus');
    $parametro = $this->input->post('parametro');

    if ($this->session->privilegios['admin_orden'] == 1) {
        $query = "SELECT DISTINCT wo.id AS wo_id, wo.*, CONCAT(a.nombre, ' ', a.paterno) AS asignado, c.* 
                  FROM ordenes_trabajo wo 
                  JOIN usuarios a ON a.id = wo.id_asignado 
                  JOIN clientes c ON c.id = wo.id_cliente 
                  LEFT JOIN comentarios_wo cw ON cw.id_wo = wo.id 
                  WHERE 1=1";
    } else {
        $query = "SELECT DISTINCT wo.id AS wo_id, wo.*, CONCAT(a.nombre, ' ', a.paterno) AS asignado, c.* 
                  FROM ordenes_trabajo wo 
                  JOIN usuarios a ON a.id = wo.id_asignado 
                  JOIN clientes c ON c.id = wo.id_cliente 
                  LEFT JOIN comentarios_wo cw ON cw.id_wo = wo.id 
                  WHERE wo.id_asignado = " . $this->session->id;
    }

    if (!empty($texto)) {
        if ($parametro == 'wo') {
            $query .= " AND wo.id = " . intval($texto);
        } else {
            $query .= " AND (
                wo.descripcion LIKE '%$texto%' OR 
                wo.motor LIKE '%$texto%' OR 
                wo.vehiculo LIKE '%$texto%' OR 
                cw.comentario LIKE '%$texto%'
            )";
        }
    }

    if ($estatus != 'TODO') {
        $query .= " AND wo.estatus = '$estatus'";
    } else {
        $query .= " AND wo.estatus != 'CANCELADA'";
    }

    $res = $this->Conexion->consultar($query);
    if ($res) {
        echo json_encode($res);
    } else {
        echo "";
    }
}


 /*   function ajax_getWos()
    {
          $this->load->model('privilegios_model');
        $texto = $this->input->post('texto');
        $estatus = $this->input->post('estatus');
        $parametro = $this->input->post('parametro');
//echo var_dump($this->session->privilegios['admin_orden']);die();
if ($this->session->privilegios['admin_orden']==1) {
             
        $query = "SELECT `wo`.`id` as `wo_id`, `wo`.*, concat(a.nombre, ' ', a.paterno) as asignado, `c`.* FROM `ordenes_trabajo` `wo` JOIN `usuarios` `a` ON `a`.`id` = `wo`.`id_asignado` JOIN `clientes` `c` ON `c`.`id` = `wo`.`id_cliente` where 1=1 ";
}else{
    $query = "SELECT `wo`.`id` as `wo_id`, `wo`.*, concat(a.nombre, ' ', a.paterno) as asignado, `c`.* FROM `ordenes_trabajo` `wo` JOIN `usuarios` `a` ON `a`.`id` = `wo`.`id_asignado` JOIN `clientes` `c` ON `c`.`id` = `wo`.`id_cliente` where 1=1 and wo.id_asignado = ".$this->session->id;
}
        if (!empty($texto)) {
            if ($parametro=='wo') {
                $query .=" and wo.id = ".$texto;
            }elseif ($parametro=='contenido') {
                $query .=" and wo.descripcion like '%$texto%'";
            }
        }
          if($estatus != 'TODO')
        {
            $query .= " and wo.estatus = '$estatus'";
        }else{
            $query .= " and wo.estatus !='CANCELADA'";
        }
     
        $res = $this->Conexion->consultar($query);
        if($res)
        {
            echo json_encode($res);
        }
        else
        {
            echo "";
        }
    }
    */
      function etiqueta_wo($id){
        $wo='WO-' . str_pad($id, 6, "0", STR_PAD_LEFT);
        ini_set('display_errors', 0);
        $this->load->library('pdfview');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
     
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle($wo);
        $pdf->SetSubject('Formato Cotización');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->AddPage('L', 'A7');
        $pdf->writeHTML($tbl, false, false, false, false, '');
        $w = array(8, 125, 12, 24, 24);


        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(255);
        $pdf->Ln();$pdf->Ln();
        $w = array(20, 20, 125, 20);

        $pdf->SetTextColor(0);
        $pdf->SetFont('helvetica', '', 25);
            $pdf->Ln();
        $tabla_items='<h1>'.$wo.'</h1>';

        $pdf->writeHTML($tabla_items, true, false, false, false, '');
        $pdf->Ln();
        $pdf->Ln();
  
        $pdf->Ln();
$pdf->Output( 'WO-'.$id.'.pdf', 'I');
    }
    function subir_archivo() {
      $wo=$this->input->post('wo');
      //$datos['id'] = $id;
      $datos['id_wo'] = $wo;
      $datos['id_us'] = $this->session->id;
      $datos['nombre'] = $_FILES['file']['name'];
      $datos['file'] = file_get_contents($_FILES['file']['tmp_name']);

      $this->Modelo->subir_archivo($datos);   
    }
    function get_foto($id){
      $photo = $this->Modelo->getFoto($id);
      if($photo)
      {
        header("Content-type: image/png");
        echo $photo->file;
      }
      else {
        echo "ERROR";
      }
    }
    function descargas($id)
    {
      $row = $this->Modelo->getFile($id, 'archivos_wo');
      $file = $row->file;
      $nombre = $row->nombre;

      force_download($nombre,$file);
    }

    function ticket($id){
    $query = "
        SELECT 
            wo.*, 
            CONCAT(c.nombre, ' ', c.apellidos) AS cliente, 
            c.dir_fiscal, 
            c.correo, 
            c.telefono,
            CONCAT(u.nombre, ' ', u.paterno) AS asignado 
        FROM ordenes_trabajo wo 
        JOIN clientes c ON c.id = wo.id_cliente 
        JOIN usuarios u ON u.id = wo.id_asignado 
        WHERE wo.id = $id";

    $rs = $this->Conexion->consultar($query);
    $data = $this->Conexion->consultar($query, TRUE);

    // Consultar piezas
    $query_piezas = "SELECT pm.nombre FROM piezas_ser_motor ps JOIN piezas_motor pm on ps.id_pieza=pm.id WHERE ps.id_wo=$id";
    $piezas = $this->Conexion->consultar($query_piezas);

    // Consultar servicios
    $query_servicios = "SELECT sw.*, s.magnitud, s.descripcion, s.sitio FROM servicios_wo sw JOIN servicios s on s.id=sw.id_servicio WHERE sw.id_wo=$id";
    $servicios = $this->Conexion->consultar($query_servicios);

    $query_pagos = "SELECT p.*, concat(u.nombre,' ', u.paterno) as user FROM pagos_wo p JOIN usuarios u on u.id=p.us WHERE id_venta = '$id'";
$pagos = $this->Conexion->consultar($query_pagos);

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

    // Logo
    $image_file = base_url().'template/images/logo_original.png';
    $pdf->Image($image_file, '', '', 20, '', '', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
    $pdf->Ln(10);

    // Encabezado
    $pdf->SetFont('courier', 'B', 9);
    $pdf->MultiCell(0, 5, "EL MICROMETRO", 0, 'C', 0, 1);
    $pdf->SetFont('courier', '', 8);
    $pdf->MultiCell(0, 5, "Miguel Ahumada #2675\nJuárez, Chihuahua, CP 32070\nTel: 6563829306 / 6566151628", 0, 'C', 0, 1);

    $pdf->Ln(1);
    $pdf->MultiCell(0, 5, "Fecha: {$data->fecha_creacion}", 0, 'C', 0, 1);
    $pdf->MultiCell(0, 5, "Folio: $id", 0, 'C', 0, 1);
    $pdf->Ln(2);

    // Datos del cliente y trabajo
    $pdf->MultiCell(0, 5, "Cliente: {$data->cliente}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Dirección: {$data->dir_fiscal}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Correo: {$data->correo}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Teléfono: {$data->telefono}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Estatus: {$data->estatus}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Descripción de Trabajo:\n{$data->descripcion}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Asignado: {$data->asignado}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Vehículo: {$data->vehiculo}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Motor: {$data->motor}", 0, 'L', 0, 1);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);
    $pdf->Ln(2);

    // Tabla: Piezas a Trabajar
    $pdf->SetFont('courier', 'B', 8);
    $pdf->MultiCell(0, 5, "Piezas a Trabajar", 0, 'L', 0, 1);
    $pdf->SetFont('courier', '', 8);
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);
    foreach ($piezas as $pieza) {
        $pdf->MultiCell(0, 5, $pieza->nombre, 0, 'L', 0, 1);
    }
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);

    // Tabla: Servicios
    $pdf->Ln(3);
    $pdf->SetFont('courier', 'B', 8);
    $pdf->MultiCell(0, 5, "Servicios", 0, 'L', 0, 1);
    $pdf->SetFont('courier', '', 8);

    // Total
    $total = 0;
    foreach ($servicios as $s) {
        $total += floatval($s->total);
    }
    $pdf->MultiCell(0, 5, "Total: $" . number_format($total, 2), 0, 'R', 0, 1);
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);
    $pdf->MultiCell(0, 5, "Servicio        Descripcion       Total", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);

    foreach ($servicios as $s) {
        $line = str_pad(substr($s->magnitud, 0, 12), 12) . ' ' . str_pad(substr($s->descripcion, 0, 12), 12) . ' ' . number_format($s->total, 0);
        $pdf->MultiCell(0, 5, $line, 0, 'L', 0, 1);
    }
    $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);

    // Mostrar pagos en el ticket
    $pdf->Ln(3);
    $pdf->SetFont('courier', 'B', 8);
    $pdf->MultiCell(0, 5, "Pagos", 0, 'L', 0, 1);
    $pdf->SetFont('courier', '', 8);
    $pdf->MultiCell(0, 5, "Cantidad        Fecha       Usuario", 0, 'L', 0, 1);
        $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);
    // Mostrar cada pago
    foreach ($pagos as $pago) {
        // Separar la fecha y hora
        list($fecha, $hora) = explode(' ', $pago->fecha);

        // Mostrar anticipo, fecha y hora
        $linea = "$".number_format($pago->cantidad, 2)." $pago->fecha {$pago->user}";
        $pdf->MultiCell(0, 5, $linea, 0, 'L', 0, 1);

        $pdf->MultiCell(0, 0, str_repeat('-', 38), 0, 'L', 0, 1);
    }

    $pdf->Output('Ticket-'.$id.'.pdf', 'I');
}

function ticket2($id) {
    $query = "
        SELECT 
            wo.*, 
            CONCAT(c.nombre, ' ', c.apellidos) AS cliente, 
            c.dir_fiscal, 
            c.correo, 
            c.telefono,
            CONCAT(u.nombre, ' ', u.paterno) AS asignado 
        FROM ordenes_trabajo wo 
        JOIN clientes c ON c.id = wo.id_cliente 
        JOIN usuarios u ON u.id = wo.id_asignado 
        WHERE wo.id = $id";

    $rs = $this->Conexion->consultar($query);
    $data = $this->Conexion->consultar($query, TRUE);

    $query_piezas = "SELECT pm.nombre FROM piezas_ser_motor ps JOIN piezas_motor pm on ps.id_pieza=pm.id WHERE ps.id_wo=$id";
    $piezas = $this->Conexion->consultar($query_piezas);

    $query_servicios = "SELECT sw.*, s.magnitud, s.descripcion, s.sitio FROM servicios_wo sw JOIN servicios s on s.id=sw.id_servicio WHERE sw.id_wo=$id";
    $servicios = $this->Conexion->consultar($query_servicios);

    $query_pagos = "SELECT p.*, concat(u.nombre,' ', u.paterno) as user FROM pagos_wo p JOIN usuarios u on u.id=p.us WHERE id_venta = '$id'";
    $pagos = $this->Conexion->consultar($query_pagos);

    ini_set('display_errors', 0);
    $this->load->library('pdfview');
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetCreator('Sistema');
    $pdf->SetAuthor('Sistema');
    $pdf->SetTitle('Orden de Trabajo - ' . $id);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->SetMargins(15, 15, 15, true);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->AddPage();

    // Logo y encabezado
    $image_file = base_url().'template/images/logo_original.png';
    $pdf->Image($image_file, 15, 10, 40);
    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->MultiCell(0, 8, "EL MICROMETRO", 0, 'C', 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 8, "Miguel Ahumada #2675, Juárez, Chihuahua, CP 32070\nTel: 6563829306 / 6566151628", 0, 'C', 0, 1);
    $pdf->Ln(10);

    // Info general
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, "Orden de Trabajo #$id", 0, 'C', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 6, "Fecha: {$data->fecha_creacion}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Cliente: {$data->cliente}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Dirección: {$data->dir_fiscal}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Correo: {$data->correo}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Teléfono: {$data->telefono}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Estatus: {$data->estatus}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Descripción: {$data->descripcion}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Asignado: {$data->asignado}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Vehículo: {$data->vehiculo}", 0, 'L', 0, 1);
    $pdf->MultiCell(0, 6, "Motor: {$data->motor}", 0, 'L', 0, 1);
    $pdf->Ln(10);

    // Tabla Piezas
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, "Piezas a Trabajar", 0, 'L', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $tbl = '<table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th><b>Nombre de la Pieza</b></th>
                    </tr>
                </thead><tbody>';
    foreach ($piezas as $pieza) {
        $tbl .= '<tr><td>' . $pieza->nombre . '</td></tr>';
    }
    $tbl .= '</tbody></table>';
    $pdf->writeHTML($tbl, true, false, false, false, '');

    // Tabla Servicios
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, "Servicios", 0, 'L', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $tbl = '<table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th><b>Magnitud</b></th>
                        <th><b>Descripción</b></th>
                        <th><b>Total ($)</b></th>
                    </tr>
                </thead><tbody>';
    $total = 0;
    foreach ($servicios as $s) {
        $total += floatval($s->total);
        $tbl .= "<tr>
                    <td>{$s->magnitud}</td>
                    <td>{$s->descripcion}</td>
                    <td align='right'>" . number_format($s->total, 2) . "</td>
                 </tr>";
    }
    $tbl .= "<tr>
                <td colspan='3' align='right'><b>Total:</b></td>
                <td align='right'><b>" . number_format($total, 2) . "</b></td>
             </tr>";
    $tbl .= '</tbody></table>';
    $pdf->writeHTML($tbl, true, false, false, false, '');

    // Tabla Pagos
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(0, 6, "Pagos Realizados", 0, 'L', 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $tbl = '<table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th><b>Fecha</b></th>
                        <th><b>Cantidad ($)</b></th>
                        <th><b>Usuario</b></th>
                    </tr>
                </thead><tbody>';
   $totalPagado = 0;
foreach ($pagos as $pago) {
    $totalPagado += floatval($pago->cantidad);
    list($fecha, $hora) = explode(' ', $pago->fecha);
    $tbl .= "<tr>
                <td>$fecha</td>
                <td align='right'>" . number_format($pago->cantidad, 2) . "</td>
                <td>{$pago->user}</td>
             </tr>";
}
$restante = $total - $totalPagado;
$tbl .= "<tr>
            <td colspan='2' align='right'><b>Total Abonado:</b></td>
            <td align='right'><b>" . number_format($totalPagado, 2) . "</b></td>
         </tr>";
$tbl .= "<tr>
            <td colspan='2' align='right'><b>Restante:</b></td>
            <td align='right'><b>" . number_format($restante, 2) . "</b></td>
         </tr>";
$tbl .= '</tbody></table>';

    $pdf->writeHTML($tbl, true, false, false, false, '');

    $pdf->Output('Orden-de-Trabajo-'.$id.'.pdf', 'I');
}

 function ajax_insertarServicioManual() {
    $desc = $this->input->post('descripcion');

    if (trim($desc) === '') {
        http_response_code(400);
        echo "Descripción vacía";
        return;
    }

    // Insertar en la tabla servicios
    $datos = [
        'magnitud' => $desc,
        'descripcion' => $desc,
        'clave_precio' => 0,
        
    ];

    $id = $this->Conexion->insertar('servicios', $datos);

    // Regresa el id para que se use en asignarServicio
    echo $id;
}
function ajax_insertarPiezaManual() {
    $desc = $this->input->post('descripcion');

    if (trim($desc) === '') {
        http_response_code(400);
        echo "Descripción vacía";
        return;
    }

    // Insertar en la tabla servicios
    $datos = [
        'nombre' => $desc,
        'precio' => 10,
        
    ];

    $id = $this->Conexion->insertar('piezas_motor', $datos);

    // Regresa el id para que se use en asignarServicio
    echo $id;
}

}
