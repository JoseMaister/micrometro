<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retiros extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Conexion_model', 'Conexion');

    }

    function index() {
        $data['total_efectivo']=$this->Conexion->consultar("SELECT SUM(total_final) as total from venta where tipo_pago = 'efectivo' AND idus = ".$this->session->id, true);
        $data['total_ventas_efectivo']=$this->Conexion->consultar("SELECT SUM(total_final) as total from venta where tipo_pago = 'efectivo' AND  tipo = 'VENTA' AND idus = ".$this->session->id, true);
        $data['total_tarjeta']=$this->Conexion->consultar("SELECT SUM(total_final) as total from venta where tipo_pago = 'tarjeta' AND idus = ".$this->session->id, true);
        $data['total_retiro']=$this->Conexion->consultar("SELECT SUM(total_final) as total from venta where tipo_pago = 'efectivo' and estatus ='RETIRO' AND idus = ".$this->session->id, true);
        $data['total_dia']=$this->Conexion->consultar("SELECT SUM(total_final) as dia FROM venta WHERE DATE(`fecha`) = CURDATE() AND idus = ".$this->session->id, true);
        $data['efectivo_caja']=$this->Conexion->consultar("SELECT SUM(total_final) as dia FROM venta WHERE tipo_pago='efectivo' and DATE(`fecha`) = CURDATE() AND idus = ".$this->session->id, true);
        $data['anticipo']=$this->Conexion->consultar("SELECT sum(pw.cantidad) as dia from pagos_wo pw JOIN venta v on v.id=pw.id_venta WHERE DATE(pw.fecha) = CURDATE()", true);
         $data['anticipo_ventas']=$this->Conexion->consultar("SELECT SUM(total_final) as total from venta where tipo = 'anticipo' AND DATE(`fecha`) = CURDATE()", true);

        $this->load->view('header');
        $this->load->view('retiros/retiros', $data);
    }
    function registrar_retiro(){
        $total=$this->input->post('retiro');
        $total_final=0-$total;
        $data = 
        array(
            'idus' => $this->session->id, 
            'total' => $total,
            'estatus' => 'RETIRO',
            'tipo' => 'RETIRO',
            'total_final' => $total_final,
            'tipo_pago' =>'efectivo',

        );
        $res = $this->Conexion->insertar('venta', $data);

        $atts = array(
              'target' => '_blank'              
            );
redirect(base_url('retiros/retiro_ticket/'.$res));
        //window.open(base_url('retiros/retiro_ticket/'.$res), '_blank');
        //redirect(base_url('retiros'));
    }
    function retiro_ticket($id){
        $query = "SELECT v.*, concat(u.nombre, ' ', u.paterno) as user from venta v JOIN usuarios u on u.id=v.idus WHERE v.id =$id";
        $rs = $this->Conexion->consultar($query);
        $data = $this->Conexion->consultar($query, TRUE);

        ini_set('display_errors', 0);
        $this->load->library('pdfview');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
       

     
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AleksOrtiz');
        $pdf->SetTitle('Ticket Retiro-'.$id);
        $pdf->SetSubject('Formato Cotización');
        $spc = "           ";
        $head = "Folio: $id";
          $txt .= "\nFecha: " . $data->fecha;
       

        $pdf->SetHeaderData(PDF_HEADER_LOGO_ORIGINAL, '15', $head,$txt);


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

        $pdf->AddPage('P', 'A7');
        $pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 8);
        $tbl = <<<EOD
            <table border="0">
                <tr>
                    <td>
                        <b>Usuario:</b><br>
                        $data->user<br>
                        
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
        $pdf->SetFont('helvetica', '', 8);
            $pdf->Ln();
        $tabla_items='';

            $tabla_items .= '<table style=" ">
                            <thead> 
                                <tr>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold;">User</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold;">Fecha</th>
                                    <th style="border-bottom: 1px solid #000; text-align: center; font-weight: bold;">$$</th>
                                    
                                </tr>
                            </thead>
                            <tbody>';
         foreach($rs as $row){
            $date=date_create($row->fecha);
            $tabla_items .='
                        <tr>
                            <td style="border-bottom: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8;">'.$row->user .'</td>
                            <td style="border-bottom: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8;">'.$row->fecha.'</td>
                            <td style="border-bottom: 1px solid #000; text-align: center; tr:nth-child:background: #F8F8F8;">$ '.$row->total.'</td>
                        </tr>';
             }
             $tabla_items .= '</tbody>
                </table>';
                $tabla_items .='
                <b>TOTAL:</b> $ 
                '.$data->total.'<br>';

        $pdf->writeHTML($tabla_items, true, false, false, false, '');
        $pdf->Ln();
        $pdf->Ln();
  
        $pdf->Ln();
$pdf->Output( 'Ticket-'.$id.'.pdf', 'I');
    }


}



